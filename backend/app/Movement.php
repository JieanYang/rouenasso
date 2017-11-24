<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movement extends Model
{
   	use SoftDeletes;

    protected $fillable=[ 'user_id', 'title_movement', 'introduction_movement', 'image_movement', 'html_movement', 'published_movement'];

    // sofe deleted date 
    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
