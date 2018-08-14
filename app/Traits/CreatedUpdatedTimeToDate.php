<?php

namespace App\Traits;

use Carbon\Carbon;

trait CreatedUpdatedTimeToDate
{

    public function getCreatedAtAttribute($value)
    {
        return (empty($value)) ? '' : Carbon::createFromTimestamp($value)->toDateTimeString();
    }

    public function getUpdatedAtAttribute($value)
    {
        return (empty($value)) ? '' : Carbon::createFromTimestamp($value)->toDateTimeString();
    }

/*
public function setCreatedAtAttribute($value)
{
$this->attributes['created_at'] = $value->getTimestamp();
}

public function setUpdatedAtAttribute($value)
{
$this->attributes['updated_at'] = $value->getTimestamp();
}
 */
}
