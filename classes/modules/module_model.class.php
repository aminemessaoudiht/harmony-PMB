<?php
// +-------------------------------------------------+
// | 2002-2007 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: module_model.class.php,v 1.3 2021/06/09 06:34:44 dgoron Exp $

if (stristr($_SERVER['REQUEST_URI'], ".class.php")) die("no access");

global $include_path;
require_once($include_path."/templates/modules/module_model.tpl.php");

/**
 * class module_model
 * Un module
 */
class module_model {
	
	protected $name;
	
	protected $destination_link;
		
	public function __construct($name='') {
		$this->name = $name;
		$this->fetch_data();
	}
	
	protected function _init_destination_link() {
		if(empty($this->destination_link)) {
			$this->destination_link = '';
			$list_modules_ui = list_modules_ui::get_instance();
			$objects = $list_modules_ui->get_objects();
			foreach ($objects as $object) {
				if($object->name == $this->name) {
					$this->destination_link = $object->destination_link;
				}
			}
		}
	}
	
	protected function fetch_data(){
		$this->destination_link = '';
		if(!$this->table_exists()) {
			return false;
		}
		$query = 'SELECT * FROM modules WHERE module_name = "'.addslashes($this->name).'"';
		$result = pmb_mysql_query($query);
		if(!pmb_mysql_num_rows($result)) {
			pmb_error::get_instance(static::class)->add_message("not_found", "not_found_object");
			return;
		}
		$data = pmb_mysql_fetch_object($result);
		$this->destination_link = $data->module_destination_link;
	}
	
	public function get_form() {
		global $msg, $charset;
		global $module_content_form;
		
		$this->_init_destination_link();
		
		$content_form = $module_content_form;
		$content_form = str_replace('!!name!!', $this->name, $content_form);
		
		$interface_form = new interface_form('module_form');
		$interface_form->set_label($msg['module_form_edit']." : ".$this->name);
		
		$content_form = str_replace('!!destination_link!!', htmlentities($this->destination_link, ENT_QUOTES, $charset), $content_form);
		
		$interface_form->set_object_id(0)
		->set_content_form($content_form)
		->set_table_name('modules');
		return $interface_form->get_display();
	}
	
	public function set_properties_from_form() {
		global $module_name;
		global $module_destination_link;
		
		$this->name = stripslashes($module_name);
		$this->destination_link = stripslashes($module_destination_link);
	}
	
	public function save() {
		if($this->is_in_database()) {
			$query = 'update modules set ';
			$where = 'where module_name= "'.addslashes($this->name).'"';
		} else {
			$query = 'insert into modules set ';
			$query .= 'module_name= "'.addslashes($this->name).'", ';
			$where = '';
		}
		$query .= '
				module_destination_link = "'.addslashes($this->destination_link).'"
				'.$where;
		$result = pmb_mysql_query($query);
		if($result) {
			return true;
		} else {
			return false;
		}
	}
	
	public static function delete($name) {
		$query = 'DELETE FROM modules WHERE module_name = "'.addslashes($name).'"';
		pmb_mysql_query($query);
		return true;
	}
	
	public function get_name() {
		return $this->name;
	}
	
	public function get_destination_link() {
		return $this->destination_link;
	}
	
	public function set_destination_link($destination_link) {
		$this->destination_link = $destination_link;
		return $this;
	}
	
	public function is_in_database() {
		$query = 'SELECT * FROM modules
			WHERE module_name = "'.addslashes($this->name).'"';
		$result = pmb_mysql_query($query);
		if(pmb_mysql_num_rows($result)) {
			return true;
		}
		return false;
	}
	
	protected function table_exists() {
		$query = "SHOW TABLES LIKE 'modules'";
		$result = pmb_mysql_query($query);
		if(pmb_mysql_num_rows($result)) {
			return true;
		}
		return false;
	}
} // end of module