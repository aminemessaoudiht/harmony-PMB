<?php



namespace App\Models\Pmb;



use Illuminate\Auth\Authenticatable;

use Laravel\Lumen\Auth\Authorizable;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;



//this is new

use Tymon\JWTAuth\Contracts\JWTSubject;



class Publisher extends Model

{

    protected $table = 'publishers';

    protected $primaryKey = 'ed_id';

    protected $appends = array('name');



  protected $hidden = [


    "ed_name",

    "ed_adr1",

    "ed_adr2",

    "ed_cp",


    "ed_pays",

    "ed_web",

    "index_publisher",

    "ed_comment",

    "ed_num_entite"

    ];

    public function getNameAttribute()

    {

        return $this->ed_name;

    }

    public function notice()
  {
    if($this->hasMany(Notice::class, 'ed1_id','ed_id')){
      return $this->hasMany(Notice::class, 'ed1_id','ed_id');
    }
    else{
      return $this->hasMany(Notice::class, 'ed2_id','ed_id');
    }

  }



}

