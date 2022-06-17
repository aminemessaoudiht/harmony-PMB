<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class NoticeLangue extends Model 
{
    protected $table = 'notices_langues';   

    protected $hidden = [
        "num_notice",
        "type_langue", 
        "ordre_langue"
    ];

}
