<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
 

class CategorieNotice extends Model 
{
    protected $table = 'notices_categories';  
    

    public function notice()
    {
        return $this->hasOne(Notice::class, 'notice_id', 'notcateg_notice');
    }
    
}
