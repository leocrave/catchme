<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    //
    protected $fillable= ['social_id', 'username', 'email', 'ic', 'mobile', 'photo'];
}
