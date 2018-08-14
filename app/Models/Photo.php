<?php

namespace App\Models;

class Photo extends Model
{
    public $timestamps = false;

    protected $appends = ['file_url'];

    protected $casts = [
        'imageable_id' => 'integer',
    ];

    public function getFileUrlAttribute()
    {
        return (!empty($this->name)) ? env('S3_SHOW_URL') . '/' . $this->path . $this->name : '';
    }

}
