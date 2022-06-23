<?php

namespace App\Models\Pmb;


use Illuminate\Database\Eloquent\Model;


class Panier extends Model
{

    protected $table = 'caddie';
    public  $timestamps = false;
    // protected $appends = ['caddiecontents'];


    protected $hidden = [
        "name",
        "type",
        "comment",
        "autorisations",
        "autorisations_all",
        "caddie_classement",
        "acces_rapide",
        "favorite_color",
        "creation_user_name",
        "creation_date"
    ];


    // public function getCaddiecontents()
    // {
    //     return "test";
    //     die("test");
    // }


    // public function getCaddiecontentsAttribute()
    // {
    //     return "test";
    //     die("test");
    // }




    public function caddiecontents()
    {
        return $this->hasMany(CaddieContent::class, 'caddie_id', 'idcaddie');
    }
}
