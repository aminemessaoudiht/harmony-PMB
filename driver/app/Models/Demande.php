<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Demande extends Model 
{
    protected $table = 'demandes';  
    protected $primaryKey = 'id_demande'; 
    public $timestamps = false;

}
