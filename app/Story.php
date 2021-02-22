<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Story extends Model
{
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
     * Thêm vào trước mỗi lần query
     * 
     * @Document : https://laravel.com/docs/7.x/eloquent#query-scopes
     */
    protected static function booted () 
    {
        // static::addGlobalScope('active', function (Builder $builder) {
        //     $builder->where('status', 1);
        // });
    }
}
