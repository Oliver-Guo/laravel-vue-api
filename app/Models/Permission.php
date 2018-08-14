<?php

namespace App\Models;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    public $timestamps = false;

    protected $guarded = ['id'];
}
