<?php
// +-------------------------------------------------+
// © 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: netbase_records.class.php,v 1.2 2021/06/03 09:41:43 dgoron Exp $

if (stristr($_SERVER['REQUEST_URI'], ".class.php")) die("no access");

class netbase_records {
	
	protected static $cleaned_records = array();
	
	protected static $cleaned_authorities = array();
	
	public function __construct() {
		
	}
	
	protected static function clean_field_data($field='') {
		global $charset;
		
		if(empty($field)) {
			return false;
		}
		$query = "SELECT notice_id, ".$field." FROM notices";
		$result = pmb_mysql_query($query);
		if($result && pmb_mysql_num_rows($result)) {
			while($row = pmb_mysql_fetch_object($result)) {
				$decoded_field = html_entity_decode($row->{$field}, ENT_QUOTES, $charset);
				if($row->{$field} != $decoded_field) {
					$query = "UPDATE notices SET ".$field." = '".addslashes($decoded_field)."', update_date=update_date WHERE notice_id =".$row->notice_id;
					pmb_mysql_query($query);
					if(!in_array($row->notice_id, static::$cleaned_records)) {
						static::$cleaned_records[] = $row->notice_id;
					}
				}
			}
		}
	}
	
	public static function clean_data() {
		//Nettoyons les résumés
		static::clean_field_data('n_resume');
		//Nettoyons les notes de contenu
		static::clean_field_data('n_contenu');
		//Nettoyons les notes générales
		static::clean_field_data('n_gen');
		return true;
	}
	
	public static function get_cleaned_records() {
		return static::$cleaned_records;
	}
	
	public static function get_cleaned_authorities() {
		return static::$cleaned_authorities;
	}
} // fin de déclaration de la classe netbase_records
