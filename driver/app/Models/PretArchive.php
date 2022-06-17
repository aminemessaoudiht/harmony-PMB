<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

//this is new
use Tymon\JWTAuth\Contracts\JWTSubject;

class PretArchive extends Model 
{
    protected $table = 'pret_archive';  
    public function exemplaire()
    {
        return $this->hasOne(Exemplaire::class, 'expl_id', 'arc_expl_id');
    }

    public function notice()

    {

        return $this->hasOne(Notice::class, 'notice_id', 'arc_expl_notice');

    }
}
