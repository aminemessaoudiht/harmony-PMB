<?php
// +-------------------------------------------------+
// © 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: animation_hooks.class.php,v 1.3 2021/03/18 14:17:32 gneveu Exp $
if (stristr($_SERVER['REQUEST_URI'], ".class.php")) {
    die("no access");
}

global $base_path, $class_path;

require_once ("$class_path/event/hook.class.php");
require_once ("$base_path/plugins/animation/classes/animation.class.php");
require_once ("$base_path/plugins/animation/includes/templates/animation.tpl.php");

class animation_hooks implements hook_interface
{

    public static function get_subcriptions()
    {
        return array(
            'animations' => array(
                'save' => array(
                    array(
                        "animation_hooks",
                        "save_animation"
                    )
                ),
                'delete' => array(
                    array(
                        "animation_hooks",
                        "delete_animation"
                    )
                ),
                'template' => array(
                    array(
                        "animation_hooks",
                        "get_templates"
                    )
                )
            )
        );
    }

    /**
     * Créer/Modifie l'article lié à l'animation
     */
    public  static function save_animation($event)
    {
        $animation = new animation($event->get_animation_id());
        
        // Peut-on faire une mise à jour automatiquement
        if ($event->get_action() == $event::AUTOMATIC_UPDATE && !$animation->can_automatic_update()) {
            return false;
        }

        // Si pas id d'article pas de mise à jour automatique sauf si on peut faire une création automatique
        if ($event->get_action() == $event::AUTOMATIC_UPDATE && !$animation->animation_has_article() && !$animation->can_automatic_create()) {
            return false;
        }
        
        // Peut-on faire une création automatiquement
        if ($event->get_action() == $event::AUTOMATIC_CREATE && !$animation->can_automatic_create()) {
            return false;
        }
        
        if ($animation->has_errors()) {
            $event->set_errors($animation->get_errors());
        } else {
            $animation->save_animation_to_article();
            $event->set_article_id($animation->get_id_article());
            if ($animation->has_errors()) {
                $event->set_errors($animation->get_errors());
            }
        }
        
    }

    /**
     * Supprime l'article liés à l'animation
     */
    public  static function delete_animation($event)
    {
        $animation = new animation($event->get_animation_id());
        
        if ($animation->has_errors()) {
            $event->set_errors($animation->get_errors());
        } else {
            $animation->delete_animation_to_article();
            if ($animation->has_errors()) {
                $event->set_errors($animation->get_errors());
            }
        }
    }

    /**
     * Retourne le template pour une animation
     */
    public static function  get_templates($event)
    {
        $animation = new animation($event->get_animation_id());
        $template = $animation->get_template();
        $event->set_inputs_template($template['inputs']);
        $event->set_info_editorial_template($template['info_editorial']);
        if ($animation->has_errors()) {
            $event->set_errors($animation->get_errors());
        }
    }

    public static function requires()
    {
        global $base_path;
        return array(
            $base_path . '/plugins/animation/classes/animation.class.php',
            $base_path . '/plugins/animation/classes/animation_conf.class.php'
        );
    }
}