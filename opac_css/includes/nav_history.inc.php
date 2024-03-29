<?php
// +-------------------------------------------------+
// � 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: nav_history.inc.php,v 1.1.2.2 2021/06/11 10:32:28 qvarin Exp $

use Pmb\Common\Opac\Views\VueJsView;

if (stristr($_SERVER['REQUEST_URI'], ".inc.php")) die("no access");

global $opac_nav_history_activated;

if ($opac_nav_history_activated) {

    if (strpos($_SERVER["REQUEST_URI"], "ajax.php") === false) {
        global $base_path;
        
        //nav_history
        require_once "$base_path/cms/modules/common/datasources/cms_module_common_datasource_typepage_opac.class.php";
        $_SESSION["current_nav_page"] = cms_module_common_datasource_typepage_opac::get_label(cms_module_common_datasource_typepage_opac::get_type_page());
        $_SESSION["current_nav_sub_page"] = cms_module_common_datasource_typepage_opac::get_label(cms_module_common_datasource_typepage_opac::get_subtype_page());
    }
    
    global $id_empr, $navId;
    
    $opac_view = $_SESSION["opac_view"];
    if (empty($opac_view) || $_SESSION["opac_view"] == "default_opac") {
        $opac_view = 0;
    }
    $VueJsView = new VueJsView("navHistory/navHistory", [
        'navId' => $navId ?? 0,
        'idEmpr' => $id_empr ?? 0,
        'opacView' => $opac_view ?? 0
    ]);
    echo $VueJsView ->render();
    
}