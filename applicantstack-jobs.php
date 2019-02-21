<?php 
/*
Plugin Name: 	ApplicantStack Jobs Display
Plugin URI:		http://demos.jdmdigital.co/plugins/applicant-stack-jobs/
Description: 	A custom plugin which displays a responsive list of jobs from ApplicantStack using their JSON API. 
Author: 		JDM Digital
Author URI:		https://jdmdigital.co
Version: 		1.0.0
*/

// If this file is called directly, abandon ship.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Set Globals
define( 'APPLICANTSTACK_JOBS_VERSION', '1.0.0' );
define( 'APPLICANTSTACK_JOBS_NAME', 'ApplicantStack Jobs Plugin' );
define( 'APPLICANTSTACK_JOBS_DEBUG', false );
define( 'APPLICANTSTACK_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'APPLICANTSTACK_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Handy Functions Include
require_once(APPLICANTSTACK_PLUGIN_PATH . 'handy-functions.php');

// Enqueue Plugin JS and CSS
function applicantstack_jobs_enqueues() {
	wp_enqueue_style( 'applicantstack-jobs', plugins_url( '/css/asj.css', __FILE__ ), array(), asj_ver(), 'screen');
	wp_enqueue_script( 'isotope', plugins_url( '/js/isotope.pkgd.min.js', __FILE__ ), array('jquery'), asj_ver(), true );
	wp_enqueue_script( 'applicantstack-jobs', plugins_url( '/js/asj.js', __FILE__ ), array('jquery', 'isotope'), asj_ver(), true );
}
add_action( 'wp_enqueue_scripts', 'applicantstack_jobs_enqueues' );

// Build Settings Page and Declare Options
require_once(APPLICANTSTACK_PLUGIN_PATH . 'settings.php');

/* ===
 * Function to return json decoded data
 * @since 0.1
 * Details: https://help.applicantstack.com/hc/en-us/articles/115000786273-API-Integration-Guide
 * ===
 */
function asj_get_data(){
    $accesstoken = asj_api_validate(esc_attr(get_option('asj_api')));
    $publisher = asj_name(); // Plugin Name (top of this file)

    $headers = array(
        "charset=\"utf-8\"",
        "Token: $accesstoken",
        "Publisher: $publisher "
    );
    $mydomain = asj_domain_validate(esc_attr(get_option('asj_domain'))); 
    $action = 'GET';
    $operation = 'jobs';
    $pagenumber = '1';
    if($pagenumber){$operation .= '/'.$pagenumber;}

    $operationurl = $mydomain."/api/".$operation;

    $curl = curl_init($operationurl);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

    $res = curl_exec($curl);

    if (curl_errno($curl)) {
        return "ERROR: " . curl_error($curl);
    }
    curl_close($curl);
    $result = json_decode($res, true);
	
	return $result;
}

/*
 * ===
 * Output the Jobs using the Applicant Stack Jobs API
 * Example: [applicantstack-jobs id="" class=""]
 * @since 0.2
 * ===
 */
function applicantstack_jobs_shortcode( $atts ) {
	extract( shortcode_atts( array(
		'id' 	=> 'applicantstack-jobs-display',
		'class'	=> 'applicantstack-jobs',
	), $atts ) );

	$html  = '<div id="'.$id.'" class="'.$class.'">';
	
	// Make the call; return the result; assign it to a new array named `$data`
	$data = asj_get_data();

	if(isset($data) && $data["Method Result"] == 'Success'){
		// No CURL Error, let's proceed
		$locations = array();
		$departments = array();
		
		
		// Starter Job Details link, appends /x/detail/
		$details_link = asj_domain_validate(esc_attr(get_option('asj_domain'))).'x/detail/';
		
		
		// Build the Jobs Markup using isotope .grid
		$jobs_html = '<div id="jobs-html" class="grid">';
		foreach($data["Jobs"] as $job){
			if($job["Stage"] == "Open") {
				// Build/Assign variables for use in markup ($jobs_html)
				$job_name 			= $job["Job Name"];
				$job_department 	= $job["Department"];
				$departmentclass 	= strtolower(str_replace('&','-', $job_department));
				$departmentclass 	= strtolower(str_replace(' ','', $departmentclass));
				$job_location 		= $job["Location"];
				$locationclass 		= strtolower(str_replace(', TX','', $job_location));
				$job_details_link 	= $details_link.$job["Job Serial"];

				// Build Departments Array
				if (!in_array($departmentclass, $departments)) {
					array_push($departments, $departmentclass);
				}
				// Build Locations Array
				if (!in_array($locationclass, $locations)) {
					array_push($locations, $locationclass);
				}

				// Jobs Grid Markup
				$jobs_html .= '
				<div class="grid-item '.$locationclass.' '.$departmentclass.'">
					<div class="grid-item-wrapper">
						<h3><a href="'.$job_details_link.'" target="_blank" rel="noopener">'.$job_name.'</a></h3>
						<p class="department">'.$job_department.'</p>
						<p class="location">'.$job_location.'</p>
						<p><a href="'.$job_details_link.'"  target="_blank" rel="noopener" class="asj-btn">Apply</a></p>
					</div>
				</div>';

			} // END if(stage == open)
		} // END foreach
		$jobs_html .= '</div>';

		
		// Build Location Filter Buttons
		$arrlength = count($locations);
		$locations_html = '
		<p class="filter-title">Filter by Location:</p>
		<div id="location-filters" class="button-group"> 
			<button class="button default is-checked" data-filter="*">All Locations</button>';
		for($i = 0; $i < $arrlength; $i++) {
			$location_pretty 	= ucwords(str_replace('-',' & ', $locations[$i]));
			$locations_html .= '<button class="button" data-filter=".'.strtolower($locations[$i]).'">'.$location_pretty.'</button>';
		}
		$locations_html .= '</div>';

		
		// Build Department Filter Buttons
		$arrlength = count($departments);
		$departments_html = '
		<p class="filter-title">Filter by Department:</p>
		<div id="department-filters" class="button-group"> 
			<button class="button default is-checked" data-filter="*">All Departments</button>';
		for($i = 0; $i < $arrlength; $i++) {
			$department_pretty 	= ucwords(str_replace('-',' & ', $departments[$i]));
			$departments_html .= '<button class="button" data-filter=".'.strtolower($departments[$i]).'">'.$department_pretty.'</button>';
		}
		$departments_html .= '</div>';
		
		
		// Re-order all this markup.
		$html .= $locations_html;
		$html .= $departments_html;
		$html .= $jobs_html;

		if(asj_debug()) {
			$html .= '<pre id="asj-debug">'.get_var_dump($data).'</pre>';
		}
			
	} else {
		// There was an error... $data["Method Result"] != 'Success'
		$html .= '	<h2>Dang it!</h2>';
		$html .= '	<p>There was some sort of an error.  Here\'s what happened:</p>';
		$html .= '	<p class="error">'.$data.'</p>';
	}
	
	$html .= '</div><!-- END #'.$id.' -->';
	
	return $html;
}
add_shortcode( 'applicantstack-jobs', 'applicantstack_jobs_shortcode' );

?>