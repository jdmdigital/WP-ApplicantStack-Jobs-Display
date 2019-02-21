<?php
// Build Settings Page and Declare Options
// @since 0.8

/*
 * Add Admin Menu for Settings
 */
function asj_plugin_setup_menu(){
	add_options_page( 'ApplicantStack Jobs Display', 'ApplicantStack Jobs', 'manage_options', 'applicantstack-jobs', 'asj_settings' );
}
add_action('admin_menu', 'asj_plugin_setup_menu');

// Register our Two settings (Domain and API)
function asj_register_settings() {
	$domain_args = array(
		'type' => 'string', 
		//'sanitize_callback' => 'asj_domain_callback',
		'default' => NULL,
	);
	$api_args = array(
		'type' => 'string', 
		//'sanitize_callback' => 'asj_api_callback',
		'default' => NULL,
	);
	register_setting( 'asj_options_group', 'asj_domain', $domain_args );
	register_setting( 'asj_options_group', 'asj_api', $api_args );
}
add_action( 'admin_init', 'asj_register_settings' );



// Returns plugin name from defined var
// @since 0.5
if(!function_exists('asj_name')) {
	function asj_name() {	
		if (defined('APPLICANTSTACK_JOBS_NAME')) {
			return APPLICANTSTACK_JOBS_NAME;
		} else {
			$plugin_data = get_plugin_data( __FILE__ );
			$plugin_name = $plugin_data['Name'];
			return $plugin_name;
		}
	}
}

// Function for Creating Settings Page; last arg in add_options_page()
function asj_settings() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
?>
<div class="wrap">
	<img src="<?php echo plugins_url( '/img/ApplicantStack_300.png', __FILE__ ); ?>" alt="ApplicantStack" style="max-width:100%; height: auto; margin: 10px 0;" />
	<h1>API Settings <small style="font-size:16px; opacity: 0.7;">v<?php echo asj_ver(); ?></small></h1>
	<form method="post" action="options.php">
		<?php settings_fields( 'asj_options_group' ); ?>
		<?php do_settings_sections( 'asj_options_group' ); ?>
		<p>You just need two pieces of information to configure this ApplicantStack Jobs API plugin: your domain name and your API token. The access token is specific to each ApplicantStack customer. You'll find it in <b>Settings</b> >> <b>Edit Settings</b> inside your <a href="https://help.applicantstack.com/hc/en-us/articles/115000786273-API-Integration-Guide" target="_blank">ApplicantStack</a> account.</p>
		<p>Need help?  Check out the <a href="http://demos.jdmdigital.co/plugins/applicant-stack-jobs/" target="_blank" rel="noopener">plugin documentation</a>.</p>
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><label for="asj_domain">ApplicantStack Domain</label></th>
					<td>
						<input type="url" id="asj_domain" name="asj_domain" value="<?php echo esc_attr(get_option('asj_domain')); ?>" placeholder="https://yoursite.applicantstack.com/" class="regular-text" />
						<p class="description">The full URL, as in: <b>https://you.applicantstack.com/</b> (WITH the trailing slash).</p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="asj_api">API Token</label></th>
					<td>
						<input type="text" id="asj_api" name="asj_api" value="<?php echo esc_attr(get_option('asj_api')); ?>" placeholder="Your API Token" class="regular-text code" />
						<p class="description">Found in <b>Settings</b> >> <b>Edit Settings</b> inside your ApplicantStack account.</p>
					</td>
				</tr>
			</tbody>
  		</table>
  		<?php submit_button('Save Settings'); ?>
	</form>
	<p><small class="cya"><strong>NOTE</strong>: <a href="https://jdmdigital.co" target="_blank" rel="noopener">The author</a> of this plugin has no affiliation with ApplicantStack or SwipeClock .</small></p>
</div>
	
<?php 
}


// Add Settings link under plugin description on WP Plugins Page
function asj_add_plugin_page_settings_link( $links ) {
	$links[] = '<a href="' .admin_url( 'options-general.php?page=applicantstack-jobs' ) .'">' . __('Settings') . '</a>';
	return $links;
}
add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'asj_add_plugin_page_settings_link');
