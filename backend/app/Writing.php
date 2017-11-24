<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Writing extends Model
{
    use SoftDeletes;

    protected $fillable=[ 'title_writing', 'user_writing', 'introduction_writing', 'image_writing', 'html_writing'];

    // sofe deleted date 
    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
