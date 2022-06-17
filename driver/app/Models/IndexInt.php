<?php



namespace App\Models;



use Illuminate\Auth\Authenticatable;

use Laravel\Lumen\Auth\Authorizable;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

 

class IndexInt extends Model 

{

    protected $table = 'indexint';  

    protected $primaryKey = 'indexint_id';  

      

    protected $hidden = [



        "index_indexint",

        "num_pclass"

            ];



                     

}

