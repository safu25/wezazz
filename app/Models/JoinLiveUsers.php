<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JoinLiveUsers extends Model
{
  protected $guarded = array();

  public function user()
  {
    return $this->belongsTo('App\Models\User', 'user_id')->first();
  }

}
