
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
 use GuzzleHttp\Promise;
 use GuzzleHttp\Middleware;
 use GuzzleHttp\Psr7\Response;
 use GuzzleHttp\Psr7\Request;
 use GuzzleHttp\Exception\BadResponseException;
 use GuzzleHttp\Exception\RequestException;
 use GuzzleHttp\Exception\ClientException; 
 
 $s_marvel_obj = new S_Marvel();
 $client = $s_marvel_obj->get_client();

 $s_marvel_settings 	= array(
	's-marvel-api-public'  => '',
    's-marvel-api-private' => '',
);
add_option('s_marvel_settings', $s_marvel_settings, null, 'true');
 

if( isset($_POST['s-marvel-api-public']) && ($_POST['s-marvel-api-public'] !='')) {
	$public_key 	= trim($_POST['s-marvel-api-public']);
 	$private_key 	= trim($_POST['s-marvel-api-private']);

    $auth = new Marvel_Auth();
    $status_code = $auth->x_auth($public_key, $private_key );

    // echo $status_code;

    if ($status_code == 200) {

        $s_marvel_settings = get_option('s_marvel_settings');
        $deprecated = null;
        $autoload = 'true';

        if(is_array($s_marvel_settings) && count($s_marvel_settings) > 0) {
            $s_marvel_settings = array(
                's-marvel-api-public'  => $public_key,
                's-marvel-api-private' => $private_key,
            );
            update_option('s_marvel_settings', $s_marvel_settings);

        } else {
            $s_marvel_settings = array(
                's-marvel-api-public'  => $public_key,
                's-marvel-api-private' => $private_key,
            );
            add_option( 's_marvel_settings', $s_marvel_settings, $deprecated, $autoload );
        } 
        echo $s_marvel_obj->admin_notice__success(ucfirst('Successfully saved your Marvel settings.'));
        // End save ----------------------------------------------------------
    }  else {
            echo $s_marvel_obj->admin_notice__error(ucfirst("Invalid Marvel Keys<br/>"));
 }
}


 $s_marvel_settings = get_option('s_marvel_settings');

// Debug
// echo '<pre>';
// print_r($s_marvel_settings);
// echo '</pre>';

$public_key = $s_marvel_settings['s-marvel-api-public'];
$private_key = $s_marvel_settings['s-marvel-api-private'];
?>

<div id="s-marvel-settings" class="group s-marvel-admin-settings">

    <!-- =================================================================================== API Section ============================================================================== -->
    <div class="wpx-action-wrap">
        <div class="wpx-ui-sidebar-wrapper">

            <div class="wpx-inside">

                <div class="wpx-panel">

                    <div class="wpx-panel-header">
                        <h3><?php _e('Marvel API Configuration', 's-marvel'); ?></h3>
                    </div>

                    <div class="wpx-panel-content">

                        <form method="post" action="">

                            <table class="form-table" role="presentation">
                                <tbody>
                                    <tr class="s-marvel-settings-row">
                                        <th scope="row">
                                            <label for="s-marvel-api-public"><?php _e('Public Key', 's-marvel'); ?></label>
                                        </th>
                                        <td>
                                            <input type="text" id="s-marvel-api-public" name="s-marvel-api-public" value="<?php echo ($public_key ? $public_key : ''); ?>" />
                                            <p class="description"><?php _e('Enter your Marvel Public Key', 's-marvel'); ?></p>
                                        </td>
                                    </tr>

                                    <tr class="s-marvel-settings-row">
                                        <th scope="row">
                                            <label for="s-marvel-api-private"><?php _e('Private Key', 's-marvel'); ?></label>
                                        </th>
                                        <td>
                                            <input type="text" id="s-marvel-api-private" name="s-marvel-api-private" value="<?php echo ($private_key ? $private_key : ''); ?>" />
                                            <p class="description"><?php _e('Enter your Private Key ', 's-marvel'); ?></p>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                            <div>
                                <input type="hidden" id="s-marvel-api-status" name="s-marvel-api-status" value="1" />
                                <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary wpx-button-sm" value="<?php _e('Save Changes', 's-marvel'); ?>"></p>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

