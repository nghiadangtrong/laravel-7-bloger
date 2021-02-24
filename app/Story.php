<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Story extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     * 
     * @var array
     */
    protected $fillable = [
        'title', 'body', 'type', 'status'
    ];

    public function user () 
    {
        return $this->belongsTo(\App\User::class);
    }

    /**
     * Tiền xử lý mỗi lần query
     * 
     * @Document : https://laravel.com/docs/7.x/eloquent#query-scopes
     */
    protected static function booted () 
    {
        // static::addGlobalScope('active', function (Builder $builder) {
        //     $builder->where('status', 1);
        // });
    }

    /**
     * Hiển thị chữ cái đầu viết hoa đối với title
     */
    public function getTitleAttribute ($value) {
        return ucfirst($value);
    }

    /**
     * thêm 'footnote' attribute
     */
    public function getFootnoteAttribute () {
        return $this->type.' Type, created at '.date('d-m-y', strtotime($this->created_at));
    }

    /**
     * Khi lưu title cũng lưu lại slug tương ứng
     */
    public function setTitleAttribute ($value) {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
}
