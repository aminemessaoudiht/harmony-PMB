<?php
// +-------------------------------------------------+
// | 2002-2007 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: list_subtabs_account_ui.class.php,v 1.1 2021/04/21 12:30:07 dgoron Exp $

if (stristr($_SERVER['REQUEST_URI'], ".class.php")) die("no access");

class list_subtabs_account_ui extends list_subtabs_ui {
	
	public function get_title() {
		global $msg;
		
		$title = "";
		switch (static::$categ) {
			case 'lists':
				$title .= $msg['lists'];
				break;
			case 'tabs':
				$title .= $msg['tabs'];
				break;
			case 'modules':
				$title .= $msg['admin_menu_modules'];
				break;
			case 'pdf':
				$title .= $msg['letters'];
				break;
			case 'mail':
				$title .= $msg['mails'];
				break;
			case 'translations':
				$title .= $msg['translations'];
				break;
			case 'favorites':
			default:
				$title .= $msg['934']." ".SESSlogin;
				break;
		}
		return $title;
	}
	
	public function get_sub_title() {
		global $sub;
		switch (static::$categ) {
			case 'tabs':
				if(empty($sub)) $sub ='admin';
				$list_modules_ui = new list_modules_ui();
				$objects = $list_modules_ui->get_objects();
				foreach ($objects as $object) {
					if($sub == $object->name) {
						return $object->label;
					}
				}
				break;
			default:
				return '';
		}
	}
	
	protected function _init_subtabs() {
		switch (static::$categ) {
			case 'tabs':
				$list_modules_ui = new list_modules_ui();
				$objects = $list_modules_ui->get_objects();
				foreach ($objects as $object) {
					$this->add_subtab($object->name, $object->label);
				}
				break;
		}
	}
}