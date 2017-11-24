<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Work extends Model
{
    use SoftDeletes;

    protected $fillable=['job', 'company', 'city', 'salary', 'html_content', 'published_at'];

    // Sofe deleted date
	protected $dates = ['deleted_at'];

	public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
