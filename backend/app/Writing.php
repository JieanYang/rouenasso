<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Writing extends Model
{
    use SoftDeletes;

    protected $fillable=[ 'title', 'username', 'introduction', 'image', 'html_content', 'published_at'];

    // sofe deleted date 
    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
