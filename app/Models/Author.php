<?php

namespace App\Models;

use App\Traits\CreatedUpdatedTimeToDate;

class Author extends Model
{
    use CreatedUpdatedTimeToDate;

    protected $casts = [
        'is_online'     => 'integer',
    ];

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($author) {

            $author->photo()->delete();

            return true;
        });
    }

    public function photo()
    {
        return $this->hasOne('App\Models\Photo', 'imageable_id', 'id')->where('imageable_type', 'author');
    }

    public function topic()
    {
        return $this->hasMany('App\Models\Topic');
    }
}
