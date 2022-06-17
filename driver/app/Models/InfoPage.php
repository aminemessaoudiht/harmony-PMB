<?php



namespace App\Models;



use Illuminate\Auth\Authenticatable;

use Laravel\Lumen\Auth\Authorizable;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;



//this is new

use Tymon\JWTAuth\Contracts\JWTSubject;



class InfoPage extends Model 

{

    protected $table = 'infopages';  

    protected $primaryKey = 'id_infopage';  

    protected $appends = array('ContentInfopages');



    protected $hidden = [

        "content_infopage",

    ];

    public function getContentInfopagesAttribute()

    {

        

        return  str_replace("\r\n","", mb_convert_encoding($this->content_infopage, 'UTF-8', 'UTF-8')); 

    }





}

