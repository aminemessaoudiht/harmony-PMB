<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class  Doc extends  Model {
    protected $table = 'documentation';
    protected $primaryKey = 'doc_id';
//    protected $appends = array(
//        'titre', 'isbn', 'format',
//        'Thumbnail',
//        'key_words',
//        'partie',
//        'dispo',
//        //   'mentionedition'
//    );
    public $timestamps = false;



}
