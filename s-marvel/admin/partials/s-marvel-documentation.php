

<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://dulanjaya@surge.global
 * @since      1.0.0
 *
 * @package    S_Marvel
 * @subpackage S_Marvel/admin/partials
 */

 require S_MARVEL_PATH . '/vendor/autoload.php';

 use GuzzleHttp\Client;
 
 $s_marvel_obj = new S_Marvel();
 $client = $s_marvel_obj->get_client();

 $auth = new Marvel_Auth();
 $status_code = $auth->x_auth();


 echo $status_code;