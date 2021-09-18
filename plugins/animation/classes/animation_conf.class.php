<?php
// +-------------------------------------------------+
// © 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: animation_conf.class.php,v 1.1 2021/03/01 10:02:15 qvarin Exp $
if (stristr($_SERVER['REQUEST_URI'], '.class.php')) {
    die('no access');
}

require_once ($base_path . '/plugins/animation/includes/templates/animation_conf.tpl.php');

class animation_conf
{

    public const OPTION_AUTOMATIQUE = 1;

    public const OPTION_MANUELLE = 0;

    private $state_anim_update = self::OPTION_MANUELLE;

    private $state_anim_create = self::OPTION_MANUELLE;

    private $id_publication_state = 3;

    private $id_section_parent = 0;

    private $id_calendar = "";
    
    private $calendar_data = array();
    
    private $errors = array();

    public function __construct()
    {
        $this->unserialize();
    }

    private function unserialize()
    {
        $query = 'select valeur_param from parametres where type_param = "pmb" and sstype_param = "plugin_animation"';
        $result = pmb_mysql_query($query);
        if (pmb_mysql_num_rows($result)) {
            $json = pmb_mysql_result($result, 0, 0);
            $params = json_decode($json);
            foreach ($params as $param => $value) {
                if (isset($this->{$param})) {
                    $this->{$param} = $value;
                }
            }
        }
    }

    public function get_form($updated = false)
    {
        global $animation_conf_form;

        $form = $animation_conf_form;
        $search = [
            "!!animation_conf_calendar_options!!",
            "!!animation_conf_state_publication!!",
            "!!animation_conf_anim_create!!",
            "!!animation_conf_anim_update!!",
            "!!animation_conf_section_parent!!"
        ];
        $replace = [
            $this->get_conf_calendar_options(),
            $this->get_conf_state_publication(),
            $this->get_conf_anim_create(),
            $this->get_conf_anim_update(),
            $this->get_conf_section_parent()
        ];
        $form = str_replace($search, $replace, $form);
        if ($updated) {
            $form .= display_notification(plugins::get_message('animation', "animation_conf_successfully_saved"));
        }
        
        return $form;
    }

    public function get_conf_calendar_options()
    {
        global $animation_conf_calendar_options, $charset;

        $selected = "";
        $html = $animation_conf_calendar_options;
        $search = [
            "!!animation_conf_calendar_option_value!!",
            "!!animation_conf_calendar_option_label!!",
            "!!selected!!"
        ];
        $replace = [
            0,
            htmlentities(plugins::get_message('animation', "animation_conf_select_calendar"), ENT_QUOTES, $charset),
            $selected
        ];
        $html = str_replace($search, $replace, $html);

        $query = "SELECT managed_module_box FROM cms_managed_modules WHERE managed_module_name = 'cms_module_agenda'";
        $result = pmb_mysql_query($query);
        if (pmb_mysql_num_rows($result)) {
            $data = pmb_mysql_fetch_assoc($result);
            $data = unserialize($data['managed_module_box']);
            $data = $data['module']['calendars'];
            foreach ($data as $key => $calendar) {
                if ($key == $this->id_calendar) {
                    $selected = "selected";
                }
                $replace = [
                    $key,
                    htmlentities($calendar['name'], ENT_QUOTES, $charset),
                    $selected
                ];
                $html .= str_replace($search, $replace, $animation_conf_calendar_options);

                $selected = "";
            }
        }
        return $html;
    }

    public function get_conf_state_publication()
    {
        global $animation_conf_state_publication, $charset;

        $selected = "";
        $html = $animation_conf_state_publication;
        $search = [
            "!!animation_conf_section_parent_option_value!!",
            "!!animation_conf_section_parent_option_label!!",
            "!!selected!!"
        ];
        $replace = [
            0,
            htmlentities(plugins::get_message('animation', "animation_conf_select_state"), ENT_QUOTES, $charset),
            $selected
        ];
        $html = str_replace($search, $replace, $html);

        $query = "SELECT id_publication_state, editorial_publication_state_label FROM cms_editorial_publications_states";
        $result = pmb_mysql_query($query);
        if (pmb_mysql_num_rows($result)) {
            while ($row = pmb_mysql_fetch_assoc($result)) {
                if ($row['id_publication_state'] == $this->id_publication_state) {
                    $selected = "selected";
                }
                $replace = [
                    $row['id_publication_state'],
                    htmlentities($row['editorial_publication_state_label'], ENT_QUOTES, $charset),
                    $selected
                ];
                $html .= str_replace($search, $replace, $animation_conf_state_publication);

                $selected = "";
            }
        }
        return $html;
    }

    public function get_conf_section_parent()
    {
        global $animation_conf_section_parent, $charset;

        $selected = "";
        $html = $animation_conf_section_parent;
        $search = [
            "!!animation_conf_section_parent_option_value!!",
            "!!animation_conf_section_parent_option_label!!",
            "!!selected!!"
        ];
        $replace = [
            0,
            htmlentities(plugins::get_message('animation', "animation_conf_select_parent"), ENT_QUOTES, $charset),
            $selected
        ];
        $html = str_replace($search, $replace, $html);

        $query = "SELECT id_section, section_title FROM cms_sections";
        $result = pmb_mysql_query($query);
        if (pmb_mysql_num_rows($result)) {
            while ($row = pmb_mysql_fetch_assoc($result)) {
                if ($row['id_section'] == $this->id_section_parent) {
                    $selected = "selected";
                }
                $replace = [
                    $row['id_section'],
                    htmlentities($row['section_title'], ENT_QUOTES, $charset),
                    $selected
                ];
                $html .= str_replace($search, $replace, $animation_conf_section_parent);

                $selected = "";
            }
        }
        return $html;
    }

    public function get_conf_anim_create()
    {
        global $animation_conf_anim_create;

        if ($this->state_anim_create == self::OPTION_MANUELLE) {
            $html = str_replace('!!checked_0!!', "checked", $animation_conf_anim_create);
            $html = str_replace('!!checked_1!!', "", $html);
        } else {
            $html = str_replace('!!checked_0!!', "", $animation_conf_anim_create);
            $html = str_replace('!!checked_1!!', "checked", $html);
        }

        return $html;
    }

    public function get_conf_anim_update()
    {
        global $animation_conf_anim_update;

        if ($this->state_anim_update == self::OPTION_MANUELLE) {
            $html = str_replace('!!checked_0!!', "checked", $animation_conf_anim_update);
            $html = str_replace('!!checked_1!!', "", $html);
        } else {
            $html = str_replace('!!checked_0!!', "", $animation_conf_anim_update);
            $html = str_replace('!!checked_1!!', "checked", $html);
        }

        return $html;
    }

    /**
     * Methode de sauvegarde
     */
    public function save_form()
    {
        $this->set_values_from_form();
        if (pmb_mysql_num_rows(pmb_mysql_query('select 1 from parametres where type_param = "pmb" and sstype_param = "plugin_animation"')) == 0) {
            $query = 'insert into parametres (type_param, sstype_param, valeur_param, comment_param, section_param, gestion)
					values ("pmb", "plugin_animation", "' . addslashes($this->serialize()) . '", "Plugin animation", "", 1)';
        } else {
            $query = 'update parametres set valeur_param = "' . addslashes($this->serialize()) . '" where type_param = "pmb" and sstype_param = "plugin_animation"';
        }
        pmb_mysql_query($query);
    }

    private function serialize()
    {
        return json_encode([
            'state_anim_update' => $this->state_anim_update,
            'state_anim_create' => $this->state_anim_create,
            'id_publication_state' => $this->id_publication_state,
            'id_section_parent' => $this->id_section_parent,
            'id_calendar' => $this->id_calendar
        ]);
    }

    private function set_values_from_form()
    {
        global $animation_choose_calendar;
        global $animation_state_publication;
        global $animation_section_parent;
        global $animation_conf_update;
        global $animation_conf_create;

        $this->state_anim_update = stripslashes($animation_conf_update);
        $this->state_anim_create = stripslashes($animation_conf_create);
        $this->id_publication_state = stripslashes($animation_state_publication);
        $this->id_section_parent = stripslashes($animation_section_parent);
        $this->id_calendar = stripslashes($animation_choose_calendar);
    }
    
    
    /**
     *
     * @return string
     */
    public function get_state_anim_update()
    {
        return $this->state_anim_update;
    }
    
    /**
     *
     * @return string
     */
    public function get_state_anim_create()
    {
        return $this->state_anim_create;
    }
    
    /**
     * ID statut de publication
     *
     * @return string|integer
     */
    public function get_id_publication_state()
    {
        return $this->id_publication_state;
    }
    
    /**
     * ID section/rubrique parente
     *
     * @return string|integer
     */
    public function get_id_section_parent()
    {
        return $this->id_section_parent;
    }
    
    /**
     * ID du calendrier
     *
     * @return string
     */
    public function get_id_calendar()
    {
        return $this->id_calendar;
    }
    
    /**
     * Données du calendrier
     *
     * @return string
     */
    public function get_calendar_data()
    {
        if (!empty($this->calendar_data)) {
            return $this->calendar_data;
        }
        
        $query = "SELECT managed_module_box FROM cms_managed_modules WHERE managed_module_name = 'cms_module_agenda'";
        $result = pmb_mysql_query($query);
        
        if (pmb_mysql_num_rows($result)) {
            $data = pmb_mysql_fetch_assoc($result);
            $data = unserialize($data['managed_module_box']);
            $data = $data['module']['calendars'];
            foreach ($data as $key => $calendar) {
                if ($key == $this->id_calendar) {
                    $this->calendar_data = $calendar;
                    return $calendar;
                }
            }
        }
        
        return array();
    }
    
    public function check_conf()
    {
        if (empty($this->id_calendar)) {
            $this->errors[] = plugins::get_message('animation', "animation_error_calendar");
        }
        
        if (empty($this->id_publication_state)) {
            $this->errors[] = plugins::get_message('animation', "animation_error_publication_state");
        }
        
        if (empty($this->id_section_parent)) {
            $this->errors[] = plugins::get_message('animation', "animation_error_section_parent");
        }
        
        return $this->errors;
    }
}