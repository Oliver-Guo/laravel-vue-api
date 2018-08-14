<?php

namespace App\Models;

class Article extends Model
{
	public $timestamps = false;
	
    protected $hidden = ['pivot'];

}
