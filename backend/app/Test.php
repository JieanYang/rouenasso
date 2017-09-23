<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $table = 'test';
	
	public $timestamps = false;
	
	protected $fillable = array('col1', 'col2', 'col3');
}
