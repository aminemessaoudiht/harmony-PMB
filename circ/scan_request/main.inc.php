<?php
// +-------------------------------------------------+
// © 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: main.inc.php,v 1.5 2021/04/15 10:04:19 dgoron Exp $

if (stristr($_SERVER['REQUEST_URI'], ".inc.php")) die("no access");

switch($sub){	
	case 'request':
		 require_once('./circ/scan_request/scan_request.inc.php');		
		break;
	case 'list':
		require_once('./circ/scan_request/scan_requests.inc.php');	
		break;
	default:
		break;
}
