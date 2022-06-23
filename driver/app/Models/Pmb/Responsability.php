<?php

namespace App\Models\Pmb;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

//this is new
use Tymon\JWTAuth\Contracts\JWTSubject;

class Responsability extends Model
{
  protected $table = 'responsability';
  protected $primaryKey = 'id_responsability';

  protected $hidden = [
    "id_responsability",
    "responsability_author",
    "responsability_notice",
    "responsability_fonction",
    "responsability_type",
    "responsability_ordre"
  ];




  public function author()
  {
    return $this->hasOne(Author::class, 'author_id', 'responsability_author');
  }
  public function notice()
  {
    return $this->hasOne(Notice::class,'notice_id', "responsability_notice" );
  }
}
