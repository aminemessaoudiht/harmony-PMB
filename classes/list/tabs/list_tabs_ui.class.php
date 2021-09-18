<?php
// +-------------------------------------------------+
// | 2002-2011 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: list_tabs_ui.class.php,v 1.10 2021/06/08 07:17:35 dgoron Exp $

if (stristr($_SERVER['REQUEST_URI'], ".class.php")) die("no access");

global $class_path;
require_once($class_path."/tabs/tab.class.php");

class list_tabs_ui extends list_ui {
	
	protected static $module_name;
	
	protected function fetch_data() {
		$this->objects = array();
		$this->_init_tabs();
		$this->messages = "";
	}
	
	public function add_tab($section, $categ, $label_code, $sub='', $url_extra='', $number=0) {
		global $msg;
		global $base_path;
		
		$tab = new tab();
		$tab->set_module(static::$module_name)
			->set_section($section)
			->set_label_code($label_code)
			->set_categ($categ)
			->set_label(isset($msg[$label_code]) ? $msg[$label_code] : $label_code)
			->set_sub($sub)
			->set_url_extra($url_extra)
			->set_number($number)
			->set_destination_link($base_path."/".static::$module_name.".php".($categ ? "?categ=".$categ : "").($sub ? "&sub=".$sub : '').$url_extra);
		$this->add_object($tab);
	}
	
	protected function is_equal_var_get($variable, $value="") {
		if(!empty($value) && is_array($value)) {
			if(isset($_GET[$variable])) {
				if(in_array($_GET[$variable], $value)) {
					return true;
				}
			}
		} else {
			if(!empty($value) && isset($_GET[$variable]) && $_GET[$variable] == $value) {
				return true;
			}
			if(empty($value) && empty($_GET[$variable])) {
				return true;
			}
		}
		return false;
	}
	
	protected function is_active_tab($label_code, $categ, $sub='') {
		if((isset($_GET['categ']) && $categ == $_GET['categ']) && (empty($sub) || (isset($_GET['sub']) && $sub == $_GET['sub']))) {
			return true;
		} else {
			return false;
		}
	}
	
	public function get_display_tab($object) {
		return "<li id='".static::$module_name."_menu_".$object->get_label_code()."' ".($this->is_active_tab($object->get_label_code(), $object->get_categ(), $object->get_sub()) ? "class='active'" : "" ).">
			<a href='".$object->get_destination_link()."'>
				".$object->get_label()."
			</a>
		</li>";
	}
	
	public function get_display() {
		$display = '';
		$grouped_objects = $this->get_grouped_objects();
		foreach($grouped_objects as $group_label=>$objects) {
			$display .= "
			<h3 onclick='menuHide(this,event)'>".$group_label."</h3>
			<ul>";
			foreach ($objects as $object) {
				$display .= $this->get_display_tab($object);
			}
			$display .= "</ul>";
		}
		return $display;
	}
	
	/**
	 * Initialisation des filtres disponibles
	 */
	protected function init_available_filters() {
		$this->available_filters['main_fields'] = array();
		$this->available_filters['custom_fields'] = array();
	}
	
	/**
	 * Initialisation des colonnes disponibles
	 */
	protected function init_available_columns() {
		$this->available_columns =
		array('main_fields' =>
				array(
						'label' => '103',
						'visible' => 'tab_visible',
						'autorisations' => '25',
						'autorisations_all' => 'tab_autorisations_all',
						'shortcut' => '95',
				)
		);
		$this->available_columns['custom_fields'] = array();
	}
	
	public function init_applied_group($applied_group=array()) {
		$this->applied_group = array(0 => 'section');
	}
	
	protected function init_no_sortable_columns() {
		$this->no_sortable_columns = array(
				'label', 'visible', 'autorisations', 'autorisations_all', 'shortcut',
		);
	}
	
	protected function init_default_pager() {
		parent::init_default_pager();
		$this->pager['all_on_page'] = true;
	}
	
	protected function init_default_columns() {
		
		$this->add_column('label');
		$this->add_column('visible');
		$this->add_column('autorisations_all');
		$this->add_column('shortcut');
	}
	
	protected function init_default_settings() {
		parent::init_default_settings();
		$this->set_setting_display('search_form', 'visible', false);
		$this->set_setting_display('search_form', 'export_icons', false);
		$this->set_setting_display('query', 'human', false);
		$this->set_setting_display('grouped_objects', 'sort', false);
		$this->set_setting_column('default', 'align', 'left');
		$this->set_setting_column('visible', 'datatype', 'boolean');
		$this->set_setting_column('autorisations_all', 'datatype', 'boolean');
	}
	
	protected function _get_object_property_section($object) {
		global $msg;
		
		$section = $object->get_section();
		if(isset($msg[$section])) {
			return $msg[$section];
		} else {
			return $section;
		}
	}
	
	protected function _get_object_property_shortcut($object) {
		$shortcut = $object->get_shortcut();
		if($shortcut) {
			return "<kbd>Esc</kbd>+<kbd>".$shortcut."</kbd>";
		}
		return '';
	}
	
	protected function get_display_cell($object, $property) {
		$attributes = array();
		if($object->is_in_database()) {
			$attributes['onclick'] = "window.location=\"".static::get_controller_url_base()."&action=edit&id=".$object->get_id()."\"";
		} else {
			$attributes['onclick'] = "window.location=\"".static::get_controller_url_base()."&action=edit&tab_module=".$object->get_module()."&tab_categ=".$object->get_categ()."&tab_sub=".$object->get_sub()."\"";
		}
		$content = $this->get_cell_content($object, $property);
		$display = $this->get_display_format_cell($content, $property, $attributes);
		return $display;
	}
	
	public static function set_module_name($module_name) {
		static::$module_name = $module_name;
	}
}