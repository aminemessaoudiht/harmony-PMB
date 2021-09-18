<?php
// +-------------------------------------------------+
// | 2002-2011 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: list_abts_pointage_ui.class.php,v 1.2 2021/06/02 07:51:19 dgoron Exp $

if (stristr($_SERVER['REQUEST_URI'], ".class.php")) die("no access");

global $class_path;
require_once($class_path.'/abts_pointage.class.php');

class list_abts_pointage_ui extends list_ui {
	
	protected function fetch_data() {
		$this->objects = array();
		$abts_pointage = new abts_pointage();
		$liste_bulletin = $abts_pointage->get_bulletinage();
		
		if($liste_bulletin){
			//Tri par type de retard
			asort($liste_bulletin);
			foreach($liste_bulletin as $retard => $bulletin_retard){
				foreach($bulletin_retard as $id_bull => $fiche){
					$fiche['retard'] = $retard;
					$fiche['id_bull'] = $id_bull;
					$this->add_object((object) $fiche);
				}
			}
			$this->pager['nb_results'] = count($this->objects);
		}
		$this->messages = "";
	}
	
	/**
	 * Initialisation des filtres disponibles
	 */
	protected function init_available_filters() {
		$this->available_filters =
		array('main_fields' =>
				array(
						'location' => 'pointage_label_localisation',
						'abts_statut' => 'abts_statut',
				)
		);
		$this->available_filters['custom_fields'] = array();
	}
	
	/**
	 * Initialisation des filtres de recherche
	 */
	public function init_filters($filters=array()) {
		global $deflt_bulletinage_location;
		
		$this->filters = array(
				'location' => $deflt_bulletinage_location,
				'abts_statut' => 0
		);
		parent::init_filters($filters);
	}
	
	protected function init_default_selected_filters() {
		$this->add_selected_filter('location');
		$this->add_selected_filter('abts_statut');
	}
	
	/**
	 * Initialisation des colonnes disponibles
	 */
	protected function init_available_columns() {
		$this->available_columns = 
		array('main_fields' =>
			array(
					'date_parution' => 'pointage_label_date',
					'periodique' => 'pointage_label_notice',
					'libelle_numero' => 'pointage_label_numero',
					'libelle_abonnement' => 'pointage_label_abonnement',
					'a_recevoir' => 'pointage_label_a_recevoir',
					'recu' => 'pointage_label_recu',
					'supprimer_et_conserver' => 'pointage_label_supprimer_et_conserver',
					'bulletin_mention_periode' => 'bulletin_mention_periode'
			)
		);
	}
	
	public function init_applied_group($applied_group=array()) {
		$this->applied_group = array(0 => 'retard');
	}
	
	/**
	 * Initialisation du tri par défaut appliqué
	 */
	protected function init_default_applied_sort() {
	    $this->add_applied_sort('date_parution');
	}
	
	/**
	 * Tri SQL
	 */
	protected function _get_query_order() {
		
	    if($this->applied_sort[0]['by']) {
			$order = '';
			$sort_by = $this->applied_sort[0]['by'];
			switch($sort_by) {
				default :
					$order .= parent::_get_query_order();
					break;
			}
			if($order) {
				return $this->_get_query_order_sql_build($order); 
			} else {
				return "";
			}
		}	
	}
	
	/**
	 * Filtres provenant du formulaire
	 */
	public function set_filters_from_form() {
		$this->set_filter_from_form('location', 'integer');
		$this->set_filter_from_form('abts_statut', 'integer');
		parent::set_filters_from_form();
	}
	
	protected function init_default_columns() {
		$this->add_column('date_parution');
		$this->add_column('periodique');
		$this->add_column('libelle_numero');
		$this->add_column('libelle_abonnement');
		$this->add_column('a_recevoir');
		$this->add_column('recu');
		$this->add_column('supprimer_et_conserver');
	}
	
	protected function init_default_settings() {
		parent::init_default_settings();
		$this->set_setting_display('search_form', 'export_icons', false);
		$this->set_setting_display('search_form', 'unfolded_filters', true);
		$this->set_setting_display('grouped_objects', 'sort', false);
		$this->set_setting_display('grouped_objects', 'display_counter', true);
		$this->set_setting_column('date_parution', 'datatype', 'date');
		$this->settings['objects']['default']['display_mode'] = 'expandable_table';
		$this->settings['grouped_objects']['level_1']['display_mode'] = 'expandable_table';
	}
	
	protected function init_no_sortable_columns() {
		$this->no_sortable_columns = array(
				'date_parution', 'periodique', 'libelle_numero', 'libelle_abonnement', 
				'a_recevoir', 'recu', 'supprimer_et_conserver'
		);
	}
	
	protected function init_default_pager() {
		parent::init_default_pager();
		$this->pager['nb_per_page'] = 10000; //Illimité;
		$this->set_pager_in_session();
	}
	
	protected function get_selector_query($type) {
		$query = '';
		switch ($type) {
			case 'locations':
				$query = 'select idlocation as id, location_libelle as label from docs_location order by label';
				break;
			case 'abts_status':
				$query = 'select abts_status_id as id, abts_status_gestion_libelle as label from abts_status order by label';
				break;
		}
		return $query;
	}
	
	protected function get_search_filter_location() {
		global $msg;
		return $this->get_simple_selector($this->get_selector_query('locations'), 'location', $msg["all_location"]);
	}
	
	protected function get_search_filter_abts_statut() {
		global $msg;
		return $this->get_simple_selector($this->get_selector_query('abts_status'), 'abts_statut', $msg["all"]);
	}
	
	/**
	 * Filtre SQL
	 */
	protected function _get_query_filters() {
		$filter_query = '';
		
		$this->set_filters_from_form();
		
		$filters = array();
		if(!empty($this->filters['location'])) {
			$filters [] = 'location_id = "'.$this->filters['location'].'"';
		}
		if(!empty($this->filters['abts_statut'])) {
			
		}
		if(count($filters)) {
			$filter_query .= ' where '.implode(' and ', $filters);
		}
		return $filter_query;
	}
	
	protected function _get_query_human_location() {
		$docs_location = new docs_location($this->filters['location']);
		return $docs_location->libelle;
	}
	
	protected function _get_query_human_abts_statut() {
		if($this->filters['abts_statut']) {
			$abts_status = new abts_status($this->filters['abts_statut']);
			return $abts_status->gestion_libelle;
		}
		return '';
	}
	
	protected function get_js_sort_script_sort() {
		$display = parent::get_js_sort_script_sort();
		$display = str_replace('!!categ!!', 'serials', $display);
		$display = str_replace('!!sub!!', 'pointage', $display);
		$display = str_replace('!!action!!', 'list', $display);
		return $display;
	}
	
	protected function _get_object_property_retard($object) {
		global $msg;
		
		switch ($object->retard) {
			case 3:
				return $msg["pointage_label_prochain_numero"];
			case 1:
				return $msg["pointage_label_en_retard"];
			case 2:
				return $msg["pointage_label_depasse"];
			case 0:
				return $msg["pointage_label_a_recevoir"];
		}
	}
	
	protected function _get_object_property_bulletin_mention_periode($object) {
		//TODO : libellé de période
	}
	
	protected function get_cell_content($object, $property) {
		global $charset;
		
		$content = '';
		switch($property) {
			case 'a_recevoir':
				$content .= "<input type='radio' name='".$object->id_bull."' id='".$object->id_bull."_1' checked='checked'  value='1' />";
				break;
			case 'recu':
				$content .= "<input name='".$object->id_bull."' id='".$object->id_bull."_2' value='2' nume='".$object->NUM."' vol='".$object->VOL."' tom='".$object->TOM."' num='". htmlentities($object->libelle_numero,ENT_QUOTES, $charset)."'  type='radio' ".$object->link_recu." />";
				break;
			case 'supprimer_et_conserver':
				$content .= "<input name='".$object->id_bull."' id='".$object->id_bull."_3' value='3' type='radio' ".$object->link_non_recevable." />";
				break;
			default :
				$content .= parent::get_cell_content($object, $property);
				break;
		}
		return $content;
	}
}