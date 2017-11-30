<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movement extends Model
{
   	use SoftDeletes;

    protected $fillable=[ 'user_id', 'title', 'introduction', 'image', 'html_content', 'published_at' ,'expiry_at'];

    // sofe deleted date 
    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
