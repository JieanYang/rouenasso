<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Work extends Model
{
    use SoftDeletes;

    protected $fillable=['title_work', 'company_work', 'city_work', 'salary_work', 'html_work'];

    // Sofe deleted date
	protected $dates = ['deleted_at'];

    
}
