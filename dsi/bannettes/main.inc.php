<?php
// +-------------------------------------------------+
// © 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: main.inc.php,v 1.9 2021/04/21 18:40:28 dgoron Exp $

if (stristr($_SERVER['REQUEST_URI'], ".inc.php")) die("no access");

global $sub;
switch($sub) {
    case 'abo':
		include_once("./dsi/bannettes/abo.inc.php");
		break;
    case 'infos':
		include_once("./dsi/bannettes/infos.inc.php");
		break;
    case 'pro':
		include_once("./dsi/bannettes/pro.inc.php");
		break;
    case 'facettes':
		include_once("./dsi/bannettes/bannette_facettes.inc.php");
		break;
    default:
        // include("$include_path/messages/help/$lang/dsi.txt");
        break;
}

