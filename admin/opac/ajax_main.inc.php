<?php
// +-------------------------------------------------+
// © 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: ajax_main.inc.php,v 1.12 2021/04/15 09:01:06 dgoron Exp $

if (stristr($_SERVER['REQUEST_URI'], ".inc.php")) die("no access");

global $class_path, $sub, $action, $categ, $object_type, $filters;

require_once($class_path."/facettes_controller.class.php");

switch ($sub) {
	case 'search_persopac':
		switch($action) {
			case "list":
				lists_controller::proceed_ajax($object_type, 'configuration/'.$categ);
				break;
		}
		break;
	default:
	    $is_external = false;
	    $temporary_variable_filters = (!empty($filters) ? encoding_normalize::json_decode(stripslashes($filters), true) : array());
	    if(!isset($temporary_variable_filters['type'])) $temporary_variable_filters['type'] = 'notices';
	    if('notices_externes' == $temporary_variable_filters['type']) $is_external = true;
		facettes_controller::set_object_id(0);
		facettes_controller::set_type($temporary_variable_filters['type']);
		facettes_controller::set_is_external($is_external);
		facettes_controller::proceed_ajax($object_type, 'configuration/'.$categ);
		break;
}	