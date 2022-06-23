<?php

namespace App\Models\Pmb;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

//this is new
use Tymon\JWTAuth\Contracts\JWTSubject;

class Suggestion extends Model
{
    protected $table = 'suggestions';
    protected $primaryKey = 'id_suggestion';
   public $timestamps = false;
}
