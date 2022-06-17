<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $table = 'notices';
    protected $primaryKey = 'notice_id';
    protected $appends = array(
        'titre', 'isbn', 'format',
        'Thumbnail',
        'key_words',
        'partie',
        'dispo'
    );
    public $timestamps = false;




    public function exemplaires()
    {
        return $this->hasMany(Exemplaire::class, 'expl_notice', 'notice_id');
    }

    public function bulletins()
    {
        return $this->hasMany(Bulletin::class, 'bulletin_notice', 'notice_id');
    }

    public function responsabilityAuthor()
    {
        return $this->hasMany(Responsability::class, "responsability_notice", 'notice_id');
    }

    public function languages()
    {
        return $this->hasMany(NoticeLangue::class, "num_notice");
    }
    public function explNum()
    {
        return $this->hasMany(ExplNum::class, "explnum_notice");
    }
    public function indexdec()
    {
        return $this->hasOne(IndexInt::class, 'indexint_id', 'indexint');
    }

    public function arcpret()
    {
        return $this->hasMany(PretArchive::class, 'arc_expl_notice', 'notice_id');
    }



    public function publisher1()
    {
        return $this->hasOne(Publisher::class, 'ed_id', 'ed1_id');
    }
    public function publisher2()
    {
        return $this->hasOne(Publisher::class, 'ed_id', 'ed2_id');
    }


    public function getTitreAttribute()
    {
        return $this->tit1 . " " . $this->tit4;
    }
    public function getPartieAttribute()
    {
        return $this->tnvol;
    }

    public function getIsbnAttribute()
    {
        return $this->code;
    }


    public function getDispoAttribute()
    {
        $exemplaires = $this->exemplaires;
        $count_pret = 0 ;
        for($x = 0; $x < count($exemplaires); $x++){
            $pret = $exemplaires[$x]->pret;
            if(count($pret) == 0 && ($exemplaires[$x]->expl_statut == 1 || $exemplaires[$x]->expl_statut == 13 )){
                return 1;
            }
            else if(count($pret) > 0){
                $count_pret++;
            }
        }
        if(count($exemplaires) == $count_pret){
            return 2;
        }
        return 0;

    }





    public function getFormatAttribute()
    {
        return $this->npages;
    }

    public function getKeyWordsAttribute()
    {
        return explode(",", $this->index_l);;
    }
    public function getThumbnailAttribute()
    {

        if ($this->code != "") {
            $isbn =  ISBN13toISBN10(str_replace("-", "", $this->code));
            $regex = "/^[0-9X]{0,10}$/";
            if(preg_match($regex, $isbn, $match)){
                list($width, $height, $type, $attr) =  getimagesize("http://images-eu.amazon.com/images/P/" . $isbn . ".MZZZZZZZ.jpg");
                if ($width > 1 && $height > 1)
                    return  "http://images-eu.amazon.com/images/P/" . $isbn . ".MZZZZZZZ.jpg";
                else return "http://biblio.ma/um6p/opac_css/no_image.jpg";
            }


            else return "http://biblio.ma/um6p/opac_css/no_image.jpg";
        } else return "http://biblio.ma/um6p/opac_css/no_image.jpg";
    }

    public function getMentioneditionAttribute()
    {
        return $this->mention_edition;
    }
}




function ISBN13toISBN10($isbn)
{
    if (preg_match('/^\d{3}(\d{9})\d$/', $isbn, $m)) {
        $sequence = $m[1];
        $sum = 0;
        $mul = 10;
        for ($i = 0; $i < 9; $i++) {
            $sum = $sum + ($mul * (int) $sequence[$i]);
            $mul--;
        }
        $mod = 11 - ($sum % 11);
        if ($mod == 10) {
            $mod = "X";
        } else if ($mod == 11) {
            $mod = 0;
        }
        $isbn = $sequence . $mod;
    }
    return $isbn;
}
