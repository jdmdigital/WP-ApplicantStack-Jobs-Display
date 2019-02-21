<?php
// Handy Functions, kept over here
// @since 1.0.0

// Returns TRUE if debug mode is on; else  FALSE
// @since 0.2
if(!function_exists('asj_debug')) {
	function asj_debug() {
		if (defined('APPLICANTSTACK_JOBS_DEBUG') && true === APPLICANTSTACK_JOBS_DEBUG) {
			return true;
		} else {
			return false;
		}
	}
}

// Returns version number from defined var
// @since 0.2.1
if(!function_exists('asj_ver')) {
	function asj_ver() {
		if (defined('APPLICANTSTACK_JOBS_VERSION')) {
			return APPLICANTSTACK_JOBS_VERSION;
		} else {
			$plugin_data = get_plugin_data( __FILE__ );
			$plugin_version = $plugin_data['Version'];
			return $plugin_version;
		}
	}
}

// Validate api input
if(!function_exists('asj_api_validate')) {
	function asj_api_validate($value) {
		$applicantstack_api = $value;
		if( isset($applicantstack_api) && $applicantstack_api != '') {
			$applicantstack_api = esc_attr(get_option('asj_api'));
		} 
		return $applicantstack_api;
	}	
}

// Validate domain callback
if(!function_exists('asj_domain_validate')) {
	function asj_domain_validate($value) {
		$applicantstack_domain = $value;
		if(isset($applicantstack_domain) && $applicantstack_domain != '') {
			$applicantstack_domain = esc_attr(get_option('asj_domain'));
		}
		// Append trailing slash if it's not there.
		if(strpos($applicantstack_domain, '.com/') === false) {
				$applicantstack_domain .= '/';
		} 
		return $applicantstack_domain;
	}
}

// returns the value of var_dump instead of outputting it.
// Used in debug mode only
if(!function_exists('get_var_dump')) {
	function get_var_dump($mixed = null) {
		ob_start();
		var_dump($mixed);
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}
}
