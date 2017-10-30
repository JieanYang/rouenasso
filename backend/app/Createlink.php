<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Createlink extends Model
{

 protected $table = 'createlinks';
 protected $fillable = ['user_id','link'];
  public $primaryKey = 'link';
  public $incrementing = false;

 public function user()
 {
     return $this->belongsTo(User::class);
 }

}
