<?php
// +-------------------------------------------------+
// © 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: classements.inc.php,v 1.12 2021/04/21 18:40:29 dgoron Exp $

if (stristr($_SERVER['REQUEST_URI'], ".inc.php")) die("no access");

global $class_path, $id_classement;

require_once($class_path."/dsi/classements_controller.class.php") ;

classements_controller::proceed($id_classement);
