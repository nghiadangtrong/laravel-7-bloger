<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Thao Tac - Manipulation -- 8806 - 4.11

```
composer create-project laravel/laravel :nameProject 7.x

php artisan list
php artisan serve
yarn watch
php artisan route:list
php artisan cache:clear
php artisan config:cache

composer require laravel/ui:^2.4
php artisan ui vue --auth
npm install && npm run dev

php artisan make:modal Story -m
php artisan migrate
php artisan make:controller StoriesController -r
php artisan make:request StoryRequest

php artisan tinker
App\Stories::truncate()     'Xóa hết bản ghi trong table'
Hash::make('passowrd')      'Hash password'
$story->refresh();           <!-- Làm mới dữ liệu trong bảng story -->
```

### authorize - Dùng Policy vs Gate

`php artisan make:policy StoryPolicy -m Story`

c1: Theo chuẩn REST API
**file:** App\Http\Controllers\StoriesController.php

```php
    public function __construct()
    {
        // Authorize theo chuẩn REST API
        $this->authorizeResource(Story::class, 'story');
    }
```

c2: Chặn theo route khai báo Policy
**file:** App\Http\Controllers\StoriesController.php

```php
    public function destroy(Story $story)
    {
        $this->authorize('delete', $story); // Dung StoryPolicy function delete()
        $story->delete();
    }
```

c3: Dùng Gate

**Định nghĩa Gate** App\Providers\AuthServiceProvider.php

```php
    use Illuminate\Support\Facades\Gate;

    public function boot()
    {
        $this->registerPolicies();

        Gate::define('story-edit', function ($user, $story) {
            return $user->id === $story->user_id;
        });
    }
```

**Use Gate** App\Http\Controllers\StoriesController.php

```php
    public function update(StoryRequest $request, Story $story)
    {
        Gate::authorize('story-edit', $story); // Dinh nghia authorize trong AuthServiceProvider
        $story->update($request->all());
    }
```

### factory

- Tạo dữ liệu test cho Model(Table) tương ứng
- Gọi Hàm factory trong unit test hoặc thông qua tinker

`php artisan make:factory StoryFactory -m Story`

`php artisan tinker`
    `factory(App\Story::class, 3)->create() 'Tạo 3 bản ghi trong bảng User'`

### Route::bind

- Tạo liên kết giữa một biến hiển thị tại Route và trả về kết quả mong muốn
[https://laravel.com/docs/7.x/routing#explicit-binding](https://laravel.com/docs/7.x/routing#explicit-binding)

'/story/{activeStory}'  => bind => \App\Story::where('id', $id)->where('status', 1)->firstOrFail()

#### Accessors & Mutators

[https://laravel.com/docs/7.x/eloquent-mutators#accessors-and-mutators](https://laravel.com/docs/7.x/eloquent-mutators#accessors-and-mutators)

**Accessors:**
Cho phép thực hiện tiền sử lý trước khi hiển thị attribute

Khai báo:

```php
    // File: App\Story
    // Hàm thay đổi giá trị 'title' khi lấy ra
    // Viết hoa chữ cái đầu tiền
    public function getTitleAttribute ($value) {
        return ucfirst($value);
    }
```

Sử dụng

```php
    ...
    $title = \App\Story::find(1)->title; // Chữ cái đầu tiên title tự động viết hoa
```

**Mutators:**
Cho phép thực hiện tiền sử lý trước khi lưu một attribute vào column

```php
    // File: App\Story
    // Khi lưu attribute title thì tạo và lưu slug theo title
    public function setTitleAttribute ($value) {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = \Illuminate\Support\Str::slug($value);
    }
```

### Mail

`php artisan make:mail NotifyAdmin`

Tạo dựa trên Markdown có sẵn của laravel
`php artisan make:mail NotifyAdminMarkdown --markdown=mails.markdown.notifyAmdin`

Copy larvel-mail markdown ra folder /vendor/email/ và có thể tùy chỉnh
`php artisan vendor:publish --tag=laravel-mail`

Tìm hiểu vendor:publish => [https://laravel.com/docs/7.x/packages](https://laravel.com/docs/7.x/packages)

### Event + Listen

**Dùng khi:** Muốn thực hiện một tác vụ độc lập hoặc tốn nhiều thời gian

**follow:** Bind event to listens = > dispatch event => listens thực hiện

B1: Tạo event `php artisan make:event StoryCreated` => Chuyền Data

B2: Tạo listens và viết hàm thực hiện

`php artisan make:listen SendNotification -e StoryCreated`
`php artisan make:listen SendNotification -e WriteLog`

B3: Bind Event với nhiều listens : App\Providers\EventServiceProvider -> $listen[]

B4: Gọi event `event (new StoryCreate(data))`

#### Subscribers cho Event + Listen

**Tác dụng:** Cho phép đăng ký nhiều listener trong 1 class

B1: Tạo file listen subscribe `php artisan make:listen StoryEventSubscribe`

- *Bind event vào listen tương ứng*

**file: App\Listeners\StoryEventSubscribe**:

```php
    // bind event to method handle
    public function subscribe($events) {
        $event->listen(
            'App\Events\StoryCreated',
            'App\Listeners\StoryEventSubscribe@HanldeCreated'
        )
    }

    // Define Method Handle
    public function HanldeCreated($event) {}
```

B2: Đăng ký subscribe
**file: App\Providers\EventServiceProvider**

`protected $subscribe = ['App\Listeners\StoryEventSubscribe']`

### SoftDelete - Xóa mềm

B1: Tạo migrate `php artisan make:migration add_softdelete_to_stories --table=stories`

B2: $table->softDeleles() & $table->dropSoftDeleles()

B3: Thêm phương thức SoftDeletes vào model
**file: App\Story**

```php
    use Illumanite\Database\Eloquent\Model;
    use Illumanite\Database\Eloquent\SoftDeletes;

    class Story extends Model{
        use SoftDeletes;
    }
```

### Admin - middleware (admin) bảo vệ route

B1: Thêm role cho user

`php artisan make:migration add_type_to_users`

B2: Thêm controller Admin\*

`php artisan make:controller Admin\StoriesController`

B3: Thêm Middle kiểm tra có phải admin không

`php artisan make:middleware CheckAdmin`

*file:* App\Http\Middleware\CheckAdmin

```php
    public function handle($request, Closure $next)
    {
        if ($request->user()->type !== 1) {
            abort(404);
        }
        return $next($request);
    }
```

B3: Thêm Route Cho admin (namespace, prefix url, middleware)

```php
Route::namespace('Admin')
    ->prefix('admin')
    ->middleware([
        'auth', 
        \App\Http\Middleware\CheckAdmin::class
    ])
    ->group(function () {
        Route::patch('/restore/{deletedStory}', 'StoriesController@restore')->name('admin.stories.restore');
    });
```

### Upload files

B1: Cài đặt/config package thao tác với image

**source** [http://image.intervention.io/](http://image.intervention.io/)

`composer require intervention/image`

**file** `config/app.php`

```php
    'providers' => [
        ...
        Intervention\Image\ImageServiceProvider::class
    ]

    'aliases' => [
        ...
        'Image' => Intervention\Image\Facades\Image::class
    ]
```

B2: Cho phép truy cập files

**document:** [https://laravel.com/docs/8.x/filesystem#the-public-disk](https://laravel.com/docs/8.x/filesystem#the-public-disk)

Liên kết thư mục /storage/app/public đến thư mục (không tạo) /public/storage

`php artisan storage:link`

B3:Thực hiện đọc/ghi file image

```php
    $imagePath = public_path('/storage/pikachu.jpg');
    $writePath = public_path('/storage/thumbnail.jpg');

    $image = Image::make($imagePath)->resize(300, 200);
    $image->save($writePath);
    return $image->response('jpg');
```

**Get file** [https://laravel.com/docs/7.x/filesystem#file-uploads](https://laravel.com/docs/7.x/filesystem#file-uploads)

*file*: app\Http\Controller\StoriesController.php

```php
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $fileName = time().$image->getClientOriginalExtension();
        
        Image::make($image)->resize(300, 200)->save(public_path('storage/'.$fileName));
        $story->image = $fileName;
        $story->save();
    }
```

### Many-to-Many (create Tags)

- **Create Modal/migration** và sửa file migration

`php artisan make:model Tag -m`

- ***Tạo seed/run**

```
php artisan make:seed TagSeed

<!-- Load config mới -->
composer dump-autoload
php artisan db:seed --class=TagSeed
```

- **Update model Story**

```php
    public function tags () 
    {
        return $this->belongsToMany(\App\Tag::class);
    }
```

- **Update model Tag**

```php
    public function stories () 
    {
        return $this->belongsToMany(\App\Story::class);
    }
```

- **ORM dùng cho Many-To-Many**

```php
    $story->tags                    // show tags
    $story->tags()->attach([1,3]);  // (update) thêm quan hệ story với tag_id = 1,3
    $story->tags()->detach([1]);    // (update) xóa quan hệ giữa story_id và tag_id = 1
    $story->tags()->sync([1,2,4]);  // (override) Ghi đè dữ liệu hiện tại

    $story->refresh();

    $story->tags->pluck('id')->toArray(); // return: TagIds: Number[] ~ pluck convert
```

- **[Eager Loading](https://laravel.com/docs/8.x/eloquent-relationships#eager-loading)** (::with(['table']))

*[Tiếng việt](https://viblo.asia/p/eloquent-relationships-trong-laravel-phan-4-RQqKL920Z7z)*

- Vấn đề (N+1): Khi gọi 1 relationship của model như 1 thuộc tính, thực hiện thêm 1 câu query nữa
- Giải pháp: Dùng Eager Loading

```php
    $story = DB::Story->with(['tags'])
    $story->tags
```


## Document

[https://laravel-news.com/laravel-boilerplate-7-0](https://laravel-news.com/laravel-boilerplate-7-0)

[https://spatie.be/docs/laravel-permission/v4/introduction](https://spatie.be/docs/laravel-permission/v4/introduction)

## Note

- **File log** : storage/logs/larvel.log
