<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

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

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Thao Tac - Manipulation -- 8806 - 4.1

composer create-project laravel/laravel <name> 7.x

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
    `App\Stories::truncate()` Xóa hết bản ghi trong table
### authorize
php artisan make:policy StoryPolicy -m Story 

### factory
    - Tạo dữ liệu test cho Model(Table) tương ứng
    - Gọi Hàm factory trong unit test hoặc thông qua tinker

    php artisan make:factory StoryFactory -m Story

    php artisan tinker
    factory(App\Story::class, 3)->create() 'Tạo 3 bản ghi trong bảng User'

### Route::bind
    - Tạo liên kết giữa một biến hiển thị tại Route và trả về kết quả mong muốn
    https://laravel.com/docs/7.x/routing#explicit-binding

    '/story/{activeStory}'  => bind => \App\Story::where('id', $id)->where('status', 1)->firstOrFail()

### Accessors & Mutators
    https://laravel.com/docs/7.x/eloquent-mutators#accessors-and-mutators
    Accessors: 
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

    Mutators:
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

    Tìm hiểu vendor:publish => https://laravel.com/docs/7.x/packages

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
    **Tác dụng: ** Cho phép đăng ký nhiều listener trong 1 class

    B1: Tạo file listen subscribe `php artisan make:listen StoryEventSubscribe` 
        bind event vào listen tương ứng
        
        **file: App\Listeners\StoryEventSubscribe**

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
        **file: App\Providers\EventServiceProvider **
        
        `protected $subscribe = ['App\Listeners\StoryEventSubscribe']`

## Document
https://laravel-news.com/laravel-boilerplate-7-0

## Note
    **File log** : storage/logs/larvel.log