<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class OpacPage extends Model
{
    protected $table = 'opac_page';
    protected $primaryKey = 'id_page';



    protected $appends = array('fr','en');
    protected $hidden = [
        "content",
        "content_en"
    ];


    public function getFrAttribute()
    {
        $content = $this->content;
        preg_match_all('/{#[0-9]*#}/', $content, $matches);
        // preg_match('/(Tiny)/', $this->content, $matches, PREG_OFFSET_CAPTURE);

        if (count($matches) > 0) {

            $matches = $matches[0];
  
            for ($i = 0; $i < count($matches); $i++) {
                $panierHtml = '<div class="caddie">';
                $panierId = str_replace(array("{#", "#}"), "", $matches[$i]);


                $caddie =  Panier::with("caddiecontents", "caddiecontents.notice", "caddiecontents.notice.explNum", "caddiecontents.notice.exemplaires")
                    ->where("idcaddie", $panierId)
                    ->get();

 
                $notices = $caddie[0]->caddiecontents;
               
                // die(var_dump($notices = $caddie[0]->caddiecontents));
                for ($j = 0; $j < count($notices); $j++) {
                    $notice = $notices[$j];
                    $expl_nums = $notice->notice->explNum;

                    for ($k = 0; $k < count($expl_nums); $k++) {
                        $expl_num = $expl_nums[$k];
                        $panierHtml .= "<div class='caddie-item'> <a href='$expl_num->pdf' target='_blank'> <img src='$expl_num->vignette'><div class='caddie-item-title'>$expl_num->explnum_nom</div></a></div>";
                    }
                }

                $panierHtml .= '</div>';

                $content = str_replace($matches[$i], $panierHtml,$content);
            }
        }


        preg_match_all('/{#pdf url=.*#}/', $content, $matches);

        if (count($matches) > 0) {

            $matches = $matches[0];

            for ($i = 0; $i < count($matches); $i++) {
                $link = str_replace(array("{#pdf url=", "#}"), "", $matches[$i]);
                $pdfHtml = ' <iframe src="' . $link . '" width="100%" height="500px"></iframe>';
                $content = str_replace($matches[$i], $pdfHtml, $content);
            }
        }
        return $content;
    }


    public function getEnAttribute()
    {
        $content = $this->content_en;
        preg_match_all('/{#[0-9]*#}/', $content, $matches);
        // preg_match('/(Tiny)/', $this->content, $matches, PREG_OFFSET_CAPTURE);

        if (count($matches) > 0) {

            $matches = $matches[0];
  
            for ($i = 0; $i < count($matches); $i++) {
                $panierHtml = '<div class="caddie">';
                $panierId = str_replace(array("{#", "#}"), "", $matches[$i]);


                $caddie =  Panier::with("caddiecontents", "caddiecontents.notice", "caddiecontents.notice.explNum", "caddiecontents.notice.exemplaires")
                    ->where("idcaddie", $panierId)
                    ->get();

 
                $notices = $caddie[0]->caddiecontents;
               
                // die(var_dump($notices = $caddie[0]->caddiecontents));
                for ($j = 0; $j < count($notices); $j++) {
                    $notice = $notices[$j];
                    $expl_nums = $notice->notice->explNum;

                    for ($k = 0; $k < count($expl_nums); $k++) {
                        $expl_num = $expl_nums[$k];
                        $panierHtml .= "<div class='caddie-item'> <a href='$expl_num->pdf' target='_blank'> <img src='$expl_num->vignette'><div class='caddie-item-title'>$expl_num->explnum_nom</div></a></div>";
                    }
                }

                $panierHtml .= '</div>';

                $content= str_replace($matches[$i], $panierHtml,$content);
            }
        }


        preg_match_all('/{#pdf url=.*#}/', $content, $matches);

        if (count($matches) > 0) {

            $matches = $matches[0];

            for ($i = 0; $i < count($matches); $i++) {
                $link = str_replace(array("{#pdf url=", "#}"), "", $matches[$i]);
                $pdfHtml = ' <iframe src="' . $link . '" width="100%" height="500px"></iframe>';
                $content = str_replace($matches[$i], $pdfHtml, $content);
            }
        }
        return $content;
    }


}
