<?php

/**
 * Register all actions and filters for the plugin
 *
 * @link       https://dulanjaya@surge.global
 * @since      1.0.0
 *
 * @package    S_Marvel
 * @subpackage S_Marvel/includes
 */

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @package    S_Marvel
 * @subpackage S_Marvel/includes
 * @author     Dulanjaya <dulanjaya@surge.global>
 */

 require S_MARVEL_PATH . '/vendor/autoload.php';

 use GuzzleHttp\Client;


    class Marvel_Characters {

        public function get_marvel_characters() { 

            $s_marvel_obj = new S_Marvel();
            $client = $s_marvel_obj->get_client();

            $wpcmxentral_settings = get_option('wpcmxentral-settings');
            $wpcmxentral_settings['s-marvel-api-public'];
            $wpcmxentral_settings['wpcmxentral-api-token'];

        }

       
    
    
    
    
    
    
    }
?>