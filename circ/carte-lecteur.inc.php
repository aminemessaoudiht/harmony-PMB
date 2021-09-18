<?php
// +-------------------------------------------------+
// © 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: carte-lecteur.inc.php,v 1.14 2021/06/09 07:42:46 dgoron Exp $

if (stristr($_SERVER['REQUEST_URI'], ".inc.php")) die("no access");

global $class_path, $idemprcaddie, $id_empr;

require_once($class_path."/pdf/reader/lettre_reader_card_PDF.class.php");
require_once($class_path."/caddie/empr_caddie_controller.class.php");

// PARAMETRES
// ----------
//   cb_first : code barre de début
//   nbr_cb : nombre de codes-barres à produire
$cb_first="100000";
$nbr_cb=1;

if(!empty($idemprcaddie)) {
	empr_caddie_controller::proceed_pdf_carte($idemprcaddie);
} else {
	$lettre_reader_card_PDF = lettre_reader_card_PDF::get_instance('reader');
	$lettre_reader_card_PDF->doLettre($id_empr);
	$ourPDF = $lettre_reader_card_PDF->PDF;
	$ourPDF->OutPut();
}

?>