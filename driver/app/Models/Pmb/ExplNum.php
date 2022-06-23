<?php

namespace App\Models\Pmb;


use Illuminate\Database\Eloquent\Model;

function public_path($path = null)
{
    return rtrim(app()->basePath('public\\' . $path), '\\');
}


class ExplNum extends Model
{
    protected $table = 'explnum';
    protected $primaryKey = 'explnum_id';

protected $hidden = [

"explnum_vignette"];

    protected $appends = array('vignette', 'pdf');


    public function getVignetteAttribute()
    {



        $myfile = fopen("tmp/" . $this->explnum_id . ".jpg", "w") or die("Unable to open file!");
        fwrite($myfile, $this->explnum_vignette);
        fclose($myfile);

        return "http://biblio.ma/um6p/pmb-api/public/tmp/" . $this->explnum_id . ".jpg";
    }
    public function getPdfAttribute()
    {




        return  "http://biblio.ma/um6p/uploads/" . $this->explnum_nomfichier ;
    }
}
