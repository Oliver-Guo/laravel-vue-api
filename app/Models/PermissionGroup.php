<?php

namespace App\Models;

class PermissionGroup extends Model
{
    public $timestamps = false;

    public function permission()
    {
        return $this->hasMany('App\Models\Permission');
    }
}
