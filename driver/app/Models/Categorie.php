<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Categorie extends Model 
{
    protected $table = 'categories';  
    protected $primaryKey = 'num_noeud';
 
    public function categnotice()
    {
        return $this->hasOne(CategorieNotice::class, 'num_noeud', 'num_noeud');
    }

}
