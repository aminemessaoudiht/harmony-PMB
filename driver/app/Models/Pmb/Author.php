<?php



namespace App\Models\Pmb;



use Illuminate\Auth\Authenticatable;

use Laravel\Lumen\Auth\Authorizable;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;



//this is new

use Tymon\JWTAuth\Contracts\JWTSubject;



class Author extends Model

{

    protected $table = 'authors';

    protected $primaryKey = 'author_id';

    protected $appends = array( 'fullname');

    protected $hidden = [


        "author_type",

        "author_see",

        "author_web",

        "index_author",




        "author_numero",

        "author_import_denied",

        "author_isni"

    ];

    public function responsabilities()
    {
        return $this->hasMany(Responsability::class, 'responsability_author','author_id' );
    }



    public function getFullnameAttribute()

    {

        return $this->author_name." ".$this->author_rejete ;

    }





}

