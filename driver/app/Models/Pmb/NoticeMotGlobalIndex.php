<?php

namespace App\Models\Pmb;

use Illuminate\Database\Eloquent\Model;

class NoticeMotGlobalIndex extends Model
{
    protected $table = 'notices_mots_global_index';


    public function notice()
    {
        return $this->hasOne(Notice::class, 'notice_id', 'id_notice');
    }
    public function word()
    {
        return $this->hasOne(Word::class, 'notice_id', 'id_notice');
    }
    public function author()
    {
        return $this->hasOne(Notice::class, 'notice_id', 'resa_idnotice');
    }
}
