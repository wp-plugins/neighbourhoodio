<?php
/*
Plugin Name: neighbourhood.io
Plugin URI: http://neighbourhood.io
Description: neighbourhood.io
Version: 1.0.0.0
Author: Sanskript Solution, Inc.
Author URI: http://www.sanskript.com
*/
	define('NEIGHBOURHOODIO_CUSTOM_ID', 'WORDPRESS-NEIGHBOURHOODIO');
	define('NEIGHBOURHOODIO_CUSTOM_DIR', dirname(__FILE__));	

	require_once("shortcode.php");	
	
	add_action( 'admin_menu', 'neighbourhoodio_add_menu' );
	
	function neighbourhoodio_add_menu() {
		$settings_page = add_menu_page('neighbourhood.io', 'neighbourhood.io', 'administrator', 'neighbourhoodio', 'neighbourhoodio_general_admin_page_callback',plugins_url( '/images/ni-logo-16i.png' , __FILE__ ));
		add_action( 'admin_init', 'neighbourhoodio_register_settings' );
	}

	function neighbourhoodio_register_settings() {
		register_setting( 'neighbourhoodio-settings', 'neighbourhoodio-key' );
	}
	
	function neighbourhoodio_general_admin_page_callback()
	{
		if (!current_user_can('manage_options')) {
			wp_die(__('You do not have sufficient permissions to access this page.'));
		}

		?>
		<div class="wrap">
			<div class="icon32"><img alt="" src="<?php echo plugins_url( '/images/ni-logo-32.png' , __FILE__ )  ?>" width="32px" height="32px"><br /></div>
			<h2>
				API Settings
			</h2>
			<form method="post" action="options.php">
				<?php settings_fields('neighbourhoodio-settings'); ?>
				<h3 class="title">Credentials</h3>
				<table class="form-table">
					<tr valign="top">
						<th scope="row">Key <span class="description">(required)</span></th>
						<td><input type="text" class="regular-text" name="neighbourhoodio-key"
								   value="<?php echo get_option('neighbourhoodio-key'); ?>"/>

                            <a href="http://neighbourhood.io">Sign up for a Key</a>
						</td>
					</tr>        
				</table>           
				<?php submit_button(); ?>
			</form>
		</div>
	<?php
	}	
?>
