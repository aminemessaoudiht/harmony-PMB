<?php
// +-------------------------------------------------+
// � 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: youtube_api.class.php,v 1.5 2019/07/15 10:39:07 arenou Exp $

if (stristr($_SERVER['REQUEST_URI'], ".class.php")) die("no access");


class youtube_api {
	public $max_results = 10;
	
	public function search_videos($vars) {
		
		if(empty($vars['max-results'])){
			$vars['max-results'] = $this->max_results;
		}		
		$client = new Google_Client();
		$client->setDeveloperKey($vars['developer_key']);
		$youtube = new Google_Service_YouTube($client);
		$searchResponse = $youtube->search->listSearch('id,snippet', array(
				'q' => $vars['q'],
				'maxResults' => $vars['max-results'],
		));		
		return $searchResponse;
	}
	
}