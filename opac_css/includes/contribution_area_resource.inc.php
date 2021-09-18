<?php
// +-------------------------------------------------+
// © 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: contribution_area_resource.inc.php,v 1.5.2.1 2021/06/11 10:32:28 qvarin Exp $

if (stristr($_SERVER['REQUEST_URI'], ".inc.php")) die("no access");

global $opac_contribution_area_activate, $allow_contribution, $class_path, $id, $type, $area_id;

if (!$opac_contribution_area_activate || !$allow_contribution) {
    die();
}

require_once($class_path.'/notice_affichage.class.php');
require_once($class_path.'/authority.class.php');
require_once($class_path.'/entities.class.php');
require_once($class_path.'/contribution_area/contribution_area_store.class.php');
require_once "$class_path/contribution_area/contribution_area.class.php";

$template = "";
if (!is_numeric($id)) {
    $contribution_area_store = new contribution_area_store();
    $id = $contribution_area_store->get_pmb_identifier_from_uri($id);
}
if (!empty($type) && !empty($id) && is_numeric($id)) {
    $contribution_area = new contribution_area($area_id);
    
    $repo_template =  $contribution_area->get_repo_template_records();
    if ($type != 'notice') {
        $repo_template = $contribution_area->get_repo_template_authorities();
    }
    
    $template = entities::get_entity_template($id, $type, $repo_template);
}

print $template;