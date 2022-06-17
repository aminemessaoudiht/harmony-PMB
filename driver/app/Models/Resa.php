<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class Resa extends Model
{

    protected $table = 'resa';
    public  $timestamps = false;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_resa';


    public function notice()
    {
        return $this->hasOne(Notice::class, 'notice_id', 'resa_idnotice');
    }
}
