<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
  protected $guarded = array();
  
  public $timestamps=false;

  public function user()
  {
    return $this->belongsTo('App\Models\User', 'user_id')->first();
  }

}
