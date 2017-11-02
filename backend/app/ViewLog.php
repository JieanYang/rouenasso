<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViewLog extends Model
{
    protected $table = 'viewlogs';
    protected $fillable = ['ip', 'user'];
}
