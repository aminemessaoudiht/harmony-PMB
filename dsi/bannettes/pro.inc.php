<?php
// +-------------------------------------------------+
// © 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: pro.inc.php,v 1.66 2021/04/21 18:40:28 dgoron Exp $

if (stristr($_SERVER['REQUEST_URI'], ".inc.php")) die("no access");

global $class_path, $id_bannette;

require_once($class_path."/dsi/bannettes_controller.class.php");

bannettes_controller::proceed($id_bannette);
