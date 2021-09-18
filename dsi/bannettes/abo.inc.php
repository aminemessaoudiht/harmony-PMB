<?php
// +-------------------------------------------------+
// © 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: abo.inc.php,v 1.37 2021/04/21 18:40:28 dgoron Exp $

if (stristr($_SERVER['REQUEST_URI'], ".inc.php")) die("no access");

global $class_path, $id_bannette, $id_empr, $id;

require_once($class_path."/dsi/bannettes_abo_controller.class.php");

bannettes_abo_controller::set_id_empr($id_empr);
bannettes_abo_controller::proceed((!empty($id_bannette) ? $id_bannette : $id));

