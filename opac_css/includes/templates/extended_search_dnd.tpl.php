<?php
// +-------------------------------------------------+
// © 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: extended_search_dnd.tpl.php,v 1.4 2020/12/24 14:26:49 qvarin Exp $

global $extended_search_dnd_tpl, $javascript_path;

$extended_search_dnd_link = '
<link rel="stylesheet" type="text/css" href="'.$javascript_path.'/dojo/dojox/grid/resources/Grid.css">
<link rel="stylesheet" type="text/css" href="'.$javascript_path.'/dojo/dojox/grid/resources/claroGrid.css">
';

$extended_search_dnd_tpl = '
<link rel="stylesheet" type="text/css" href="'.$javascript_path.'/dojo/dojox/grid/resources/Grid.css">
<link rel="stylesheet" type="text/css" href="'.$javascript_path.'/dojo/dojox/grid/resources/claroGrid.css">
<div id="extended_search_dnd_container" data-dojo-type="dijit/layout/BorderContainer" data-dojo-props="splitter:true" style="height:800px;width:100%;">
</div>
<script type="text/javascript">
	require(["apps/search/SearchController", "dojo/domReady!"], function(SearchController){
		var searchController = new SearchController();
	});
</script>';

$extended_search_dnd_script = '<script type="text/javascript">
	require(["apps/search/SearchController", "dojo/domReady!"], function(SearchController){
		var searchController = new SearchController();
	});
</script>';

$extended_search_dnd_tab_tpl = $extended_search_dnd_link.'<div data-dojo-type="apps/pmb/tab/tabController" style="height:800px;width:100%;margin-top:2%;">
    <div id="extended_search_dnd_container" data-dojo-type="dijit/layout/BorderContainer" data-dojo-props="title: \''.$msg['search_extended'].'\', splitter:true" style="height:800px;width:100%;">
    </div>
</div>'.$extended_search_dnd_script;

$extended_search_dnd_tpl = $extended_search_dnd_link.'
<div id="extended_search_dnd_container" data-dojo-type="dijit/layout/BorderContainer" data-dojo-props="splitter:true" style="height:800px;width:100%;">
</div>'.$extended_search_dnd_script;