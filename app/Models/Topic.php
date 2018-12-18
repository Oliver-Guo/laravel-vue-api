<?php

namespace App\Models;

use App\Traits\CreatedUpdatedTimeToDate;
use Carbon\Carbon;

class Topic extends Model
{

    use CreatedUpdatedTimeToDate;

    protected $hidden = ['pivot'];

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($topic) {

            $topic->photo()->delete();
            $topic->tags()->sync([]);
            $topic->articles()->sync([]);

            return true;
        });
    }

    public function getOnlinedAtAttribute($value)
    {
        return (empty($value)) ? '' : Carbon::createFromTimestamp($value)->toDateString();
    }

    public function photo()
    {
        return $this->hasOne('App\Models\Photo', 'imageable_id', 'id')->where('imageable_type', 'topic');
    }

    public function topicCategory()
    {
        return $this->belongsTo('App\Models\TopicCategory');
    }

    public function author()
    {
        return $this->belongsTo('App\Models\Author');
    }

    public function articles()
    {
        return $this->belongsToMany('App\Models\Article');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag');
    }

}
