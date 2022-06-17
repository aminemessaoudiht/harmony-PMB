<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class CaddieContent extends Model 
{
    
    protected $table = 'caddie_content';   
    
    public function notice()
    {
        return $this->hasOne(Notice::class, 'notice_id', 'object_id');
    }
    public function caddie()
    {
        return $this->hasOne(Panier::class, 'idcaddie', 'caddie_id');
    }
    
}
