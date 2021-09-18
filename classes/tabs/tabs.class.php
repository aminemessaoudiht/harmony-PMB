<?php
// +-------------------------------------------------+
// | 2002-2011 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: tabs.class.php,v 1.1 2021/06/08 16:15:42 dgoron Exp $

if (stristr($_SERVER['REQUEST_URI'], ".class.php")) die("no access");

class tabs {
	
	public static function get_shortcuts() {
		$shortcuts = array();
		$query = "SELECT * FROM tabs WHERE tab_shortcut <> ''";
		$result = pmb_mysql_query($query);
		if(pmb_mysql_num_rows($result)) {
			while($row = pmb_mysql_fetch_object($result)) {
				$shortcuts[] = array(
						$row->tab_shortcut,
						"./".$row->tab_module.".php?categ=".$row->tab_categ.($row->tab_sub ? "&sub=".$row->tab_sub : "")
				);
			}
		}
		return $shortcuts;
	}
}