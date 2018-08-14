<?php

namespace App\Models;

use App\Traits\CreatedUpdatedTimeToDate;

class TopicCategory extends Model
{
    use CreatedUpdatedTimeToDate;

    protected $casts = [
        'is_online' => 'integer',
    ];

    public function topic()
    {
        return $this->hasMany('App\Models\Topic');
    }

}
