<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'cms_articles';
    protected $primaryKey = 'id_article';
    protected $hidden = [
        "article_logo",
        "article_publication_state",
        "article_start_date",
        "article_end_date",
        "num_section",
        "article_num_type",
        "article_creation_date",
        "article_order",
        "article_update_timestamp"
    ];
    protected $appends = array('logo');

    public function  getLogoAttribute()
    {

        $myfile = fopen("tmp/" . $this->id_article . ".jpg", "w") or die("Unable to open file!");

        fwrite($myfile, $this->article_logo);

        fclose($myfile);
        return  env('TMP_PHOTOS', "test") . $this->id_article . ".jpg";
    }
}
