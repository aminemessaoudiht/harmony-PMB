<?php
// +-------------------------------------------------+
// � 2002-2012 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: cms_module_item_datasource_item.class.php,v 1.3 2015/03/10 15:01:09 dgoron Exp $

if (stristr($_SERVER['REQUEST_URI'], ".class.php")) die("no access");

require_once($class_path."/docwatch/docwatch_item.class.php");

class cms_module_item_datasource_item extends cms_module_common_datasource{
	
	public function __construct($id=0){
		parent::__construct($id);
	}
	
	/*
	 * On d�fini les s�lecteurs utilisable pour cette source de donn�e
	*/
	public function get_available_selectors(){
		return array(
				"cms_module_item_selector_item_generic"
		);
	}
			
	/*
	 * R�cup�ration des donn�es de la source...
	 */
	public function get_datas(){
		global $dbh;
		//on commence par r�cup�rer l'identifiant retourn� par le s�lecteur...
		$selector = $this->get_selected_selector();
		if($selector){
			$item_id = $selector->get_value();
			if ($item_id) {
				$docwatch_item = new docwatch_item($item_id);
				return $docwatch_item->get_normalized_item();
			}
		}
		return false;
	}
	
	public function get_format_data_structure(){
		return $this->prefix_var_tree(docwatch_item::get_format_data_structure(),"item");
	}
}