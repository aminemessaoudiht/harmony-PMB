<?php

namespace App\Models\Pmb;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

//this is new
use Tymon\JWTAuth\Contracts\JWTSubject;

class Pret extends Model
{
    protected $table = 'pret';
    public function exemplaire()
    {
        return $this->hasOne(Exemplaire::class, 'expl_id', 'pret_idexpl');
    }


}
