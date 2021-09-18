<?php
use Pmb\Animations\Controller\PriceController;
use Pmb\Animations\Controller\StatusController;
use Pmb\Animations\Controller\MailingController;

// +-------------------------------------------------+
// � 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: main.inc.php,v 1.12 2021/03/03 13:16:54 jlaurent Exp $

if (stristr($_SERVER['REQUEST_URI'], ".inc.php"))
    die("no access");

global $id;
global $data;
global $action;
global $sub;

switch ($sub) {
    case 'priceTypes':
        $data = json_decode(stripslashes($data));
        $priceController = new PriceController();
        $priceController->proceed($action, $data);
        break;
    case 'status':
        $data = json_decode(stripslashes($data));
        $priceController = new StatusController();
        $priceController->proceed($action, $data);
        break;
    case 'priceTypesPerso':
        include("./admin/animations/perso.inc.php");
        break;
    case 'perso':
        include("./admin/animations/perso.inc.php");
        break;
    case 'mailing':
        $data = json_decode(stripslashes($data));
        if (empty($data)) {
            $data = new stdClass();
        }
        if (!empty($id)) {
            $data->id = $id;
        }
        $mailingController = new MailingController($data);
        $mailingController->proceed($action, $data);
        break;
    default:
        break;
}
