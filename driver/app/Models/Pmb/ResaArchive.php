<?php

namespace App\Models\Pmb;


use Illuminate\Database\Eloquent\Model;

class ResaArchive extends Model
{

    protected $table = 'resa_archive';
    public  $timestamps = false;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'resarc_id';

    function notices()
    {
        return $this->hasMany(Notice::class, 'notice_id', 'resarc_idnotice');
    }
}
