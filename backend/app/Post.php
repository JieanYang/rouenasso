<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
	use SoftDeletes;

    protected $fillable = ['title', 'user_id', 'html_content', 'published_at', 'category', 'view', 'preview_img_url', 'preview_text'];
    
    /**
     * Sofe deleted date
     */
    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
