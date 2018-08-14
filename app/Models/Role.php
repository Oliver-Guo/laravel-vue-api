<?php

namespace App\Models;

use App\Traits\CreatedUpdatedTimeToDate;
use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    use CreatedUpdatedTimeToDate;

    protected $dateFormat = 'U';

    protected $guarded = ['id'];

    protected $hidden = ['description', 'created_user', 'updated_user'];

}
