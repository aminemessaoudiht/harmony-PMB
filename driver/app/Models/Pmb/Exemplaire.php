<?php



namespace App\Models\Pmb;





use Illuminate\Database\Eloquent\Model;



class Exemplaire extends Model

{

    protected $table = 'exemplaires';

    protected $primaryKey = 'expl_id';

    protected $appends = array('cote','code_bar');

    protected $hidden = [



"expl_id",

"expl_cb",

"expl_notice",

"expl_bulletin",

"expl_typdoc",

"expl_cote",

"expl_section",

"expl_statut",

"expl_location",

"expl_codestat",

"expl_date_depot",

"expl_date_retour",

"expl_note",

"expl_prix",

"expl_owner",

"expl_lastempr",

"last_loan_date",

"create_date",

"update_date",

"type_antivol",

"transfert_location_origine",

"transfert_statut_origine",

"expl_comment",

"expl_nbparts",

"expl_retloc",

"expl_abt_num",

"transfert_section_origine",

"expl_ref_num",

"expl_pnb_flag"

    ];





    public function getCoteAttribute()

    {

        return $this->expl_cote;

    }

    public function getCodeBarAttribute()

    {

        return $this->expl_cb;

    }



    public function localisation()

    {

        return $this->hasOne(DocsLocation::class, 'idlocation', 'expl_location');

    }

    public function statut()

    {

        return $this->hasOne(DocsStatut::class, 'idstatut', 'expl_statut');

    }

    public function type()

    {

        return $this->hasOne(DocsType::class, 'idtyp_doc', 'expl_typdoc');

    }

    public function section()

    {

        return $this->hasOne(ExplSection::class, 'idsection', 'expl_section');

    }



    public function notice()

    {

        return $this->hasOne(Notice::class, 'notice_id', 'expl_notice');

    }

    public function arcpret()
    {
        return $this->hasMany(PretArchive::class, 'arc_expl_id', 'expl_id');
    }

    public function pret()
    {
        return $this->hasMany(Pret::class, 'pret_idexpl', 'expl_id');
    }


}

