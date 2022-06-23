<?php

namespace App\Models\Koha;


use Illuminate\Database\Eloquent\Model;

class  BiblioItems extends  Model {
    protected $table = 'biblioItems';
    protected $primaryKey = 'biblioitemnumber';
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
