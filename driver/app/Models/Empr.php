<?php



namespace App\Models;



use Illuminate\Auth\Authenticatable;

use Laravel\Lumen\Auth\Authorizable;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;



//this is new

use Tymon\JWTAuth\Contracts\JWTSubject;



class Empr extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject 

{

    protected $table = 'empr';

    protected $primaryKey = 'id_empr';

    use Authenticatable, Authorizable;



    /**

     * The attributes that are mass assignable.

     *

     * @var array

     */

    protected $fillable = [

        'name', 'email'

    ];



    /**

     * The attributes excluded from the model's JSON form.

     *

     * @var array

     */

    protected $hidden = [

        'password',

    ];


    public function arcpret()
    {
        return $this->hasMany(PretArchive::class, 'arc_id_empr', 'id_empr');
    }


    //this is new



    /**

     * Get the identifier that will be stored in the subject claim of the JWT.

     *

     * @return mixed

     */

    public function getJWTIdentifier()

    {

        return $this->getKey();

    }



    /**

     * Return a key value array, containing any custom claims to be added to the JWT.

     *

     * @return array

     */

    public function getJWTCustomClaims()

    {

        return [];

    }



    // public function setPasswordAttribute($value)

    // { 

    //     $this->attributes['password'] =crypt($value."05718e96fefeb25b595a3d310dc5bedf"."0",substr("05718e96fefeb25b595a3d310dc5bedf", 0, 2))  ;

    // }

    // public function getPasswordAttribute($value)

    // { 

    //     $this->attributes['password'] =crypt($value."05718e96fefeb25b595a3d310dc5bedf"."0",substr("05718e96fefeb25b595a3d310dc5bedf", 0, 2))  ;

    // }

    

    public function getAuthPassword()

    { 

        return $this->empr_password ;

    }

    

    // public function getAuthIdentifierName()

    // {

    //     return 'memberid';

    // }





}

