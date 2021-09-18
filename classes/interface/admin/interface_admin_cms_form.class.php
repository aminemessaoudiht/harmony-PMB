<?php
// +-------------------------------------------------+
// | 2002-2011 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: interface_admin_cms_form.class.php,v 1.2 2021/05/11 08:18:50 dgoron Exp $

if (stristr($_SERVER['REQUEST_URI'], ".class.php")) die("no access");

global $class_path;
require_once($class_path.'/interface/admin/interface_admin_form.class.php');

class interface_admin_cms_form extends interface_admin_form {
	
	protected $elem;
	
	protected function get_submit_action() {
		return $this->get_url_base()."&elem=".$this->elem."&action=save&id=".$this->object_id;
	}
	
	protected function get_delete_action() {
		return $this->get_url_base()."&elem=".$this->elem."&action=delete&id=".$this->object_id;
	}
	
	protected function get_display_delete_action() {
		if(strpos($this->elem, "generic") !== false){
			return '';
		} else {
			return parent::get_display_delete_action();
		}
	}
	
	public function set_elem($elem) {
		$this->elem = $elem;
		return $this;
	}
}