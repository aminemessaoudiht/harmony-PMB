<?php
// +-------------------------------------------------+
// © 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: animation_conf.tpl.php,v 1.1 2021/03/01 10:02:15 qvarin Exp $

if (stristr($_SERVER['REQUEST_URI'], ".tpl.php")) {
    die("no access");
}

global $current_module, $base_path, $msg;
global $animation_conf_form, $animation_conf_calendar_options, $animation_conf_section_parent, $animation_conf_state_publication, $animation_conf_anim_create, $animation_conf_anim_update;

$animation_conf_form = "
    <h1>".plugins::get_message('animation', "animation_menu_title")." > " .plugins::get_message('animation', "animation_conf_sub_menu_title") ."</h1>
    <form class='form-".$current_module."' id='animation_conf_form' name='animation_conf_form'  method='post' action='".$base_path."/admin.php?categ=plugin&plugin=animation&sub=animation_conf&what=save' >
    	<div class='form-contenu'>

    		<div class='row'>
    			<label class='etiquette' for='animation_choose_calendar'>".plugins::get_message('animation', "animation_choose_calendar")."</label>
    		</div>
    		<div class='row'>
                <select name='animation_choose_calendar' id='animation_choose_calendar'>
                    !!animation_conf_calendar_options!!
                </select>
    		</div>

    		<div class='row'>
    			<label class='etiquette' for='animation_state_publication'>".plugins::get_message('animation', "animation_state_publication")."</label>
    		</div>
    		<div class='row'>
                <select name='animation_state_publication' id='animation_state_publication'>
                    !!animation_conf_state_publication!!
                </select>
    		</div>

    		<div class='row'>
    			<label class='etiquette' for='animation_section_parent'>".plugins::get_message('animation', "animation_section_parent")."</label>
    		</div>    		
            <div class='row'>
                <select name='animation_section_parent' id='animation_section_parent'>
                    !!animation_conf_section_parent!!
                </select>
    		</div>

    		<div class='row'>
    			<label class='etiquette' for='animation_create'>".plugins::get_message('animation', "animation_create")."</label>
    		</div>
    		<div class='row'>
               !!animation_conf_anim_create!!
    		</div>

    		<div class='row'>
    			<label class='etiquette' for='animation_update'>".plugins::get_message('animation', "animation_update")."</label>
    		</div>
    		<div class='row'>
               !!animation_conf_anim_update!!
    		</div>

        	<div class='row'>
        		<div class='left'>
        			<input type='submit' class='bouton' value='".$msg['77']."'/>
        		</div>
        	</div>
        </div>
    	<div class='row'></div>
    </form>
";

$animation_conf_calendar_options = "
    <option value='!!animation_conf_calendar_option_value!!' !!selected!!>!!animation_conf_calendar_option_label!!</option>
";

$animation_conf_section_parent = "
    <option value='!!animation_conf_section_parent_option_value!!' !!selected!!>!!animation_conf_section_parent_option_label!!</option>
";

$animation_conf_state_publication = "
    <option value='!!animation_conf_section_parent_option_value!!' !!selected!!>!!animation_conf_section_parent_option_label!!</option>
";

$animation_conf_anim_create = "
    <input type='radio' name='animation_conf_create' value='1' id='animation_conf_create_1' !!checked_1!!/>
    <label for='animation_conf_create_1'>".plugins::get_message('animation', "animation_conf_state_auto_1")."</label>
    <input type='radio' name='animation_conf_create' value='0' id='animation_conf_create_0' !!checked_0!!/>
    <label for='animation_conf_create_0'>".plugins::get_message('animation', "animation_conf_state_manuel_0")."</label>
";

$animation_conf_anim_update = "
    <input type='radio' name='animation_conf_update' value='1' id='animation_conf_update_1' !!checked_1!!/>
    <label for='animation_conf_update_1'>".plugins::get_message('animation', "animation_conf_state_auto_1")."</label>
    <input type='radio' name='animation_conf_update' value='0' id='animation_conf_update_0' !!checked_0!!/>
    <label for='animation_conf_update_0'>".plugins::get_message('animation', "animation_conf_state_manuel_0")."</label>
";





























