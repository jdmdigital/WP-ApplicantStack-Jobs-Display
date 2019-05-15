=== WP ApplicantStack Jobs Display ===
Contributors: jdm-labs
Plugin Name: WP ApplicantStack Jobs Display
Plugin URI: https://github.com/jdmdigital/wp-applicantstack-jobs-display
Tags: ApplicantStack, ATS, Jobs Display
Author URI: https://jdmdigital.co
Author: JDM Digital
Requires at least: 4.5
Tested up to: 5.2
Stable tag: 1.1
Requires PHP: 5.2
Version: 1.1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A simple plugin which displays a responsive, filterable list of jobs from ApplicantStack using their JSON API.

== Description ==

Using the [ApplicantStack API](https://help.applicantstack.com/hc/en-us/articles/115000786273-API-Integration-Guide "API Integration Guide"), this plugin will display up to 100 of the ApplicantStack jobs you have listed on your website wherever you place the magic shortcode, `[applicantstack-jobs]`.  

There's a little demo in the post announcing the plugin if you want to see it in action.  Check that out at: https://jdmdigital.co/labs/code-projects/wp-applicantstack-jobs-display/

== Installation ==

1. Upload `applicantstack-jobs` to the `/wp-content/plugins/` directory or add it from the WordPress repo
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Go to ApplicantStack and get your API Token and Domain name
1. Back in WordPress, enter your ApplicantStack API Token and Domain Name in Settings->ApplicantStack Jobs
1. Place the shortcode, `[applicantstack-jobs]` wherever you want the jobs list displayed.

== Frequently Asked Questions ==

= How do I get my ApplicantStack API token? =
You will need an access token and username to access the ApplicantStack API. The access token is specific to each ApplicantStack customer. It can be found on inside ApplicantStack at Settings >> Edit Settings.

You will also need your Applicant Stack domain.  Domain information is also available on that settings page. It will look something like:

https://**MYDOMAIN**.applicantstack.com/

Where MYDOMAIN is your ApplicantStack domain name.

= Are there any attributes to add to the shortcode? =
Yes.  The shortcode  includes two optional attributes: `id` and `class`.  These can be handy to change if you want to use your own CSS rather than the CSS bundled with it. 

For example:

`[applicantstack-jobs id="jobs-custom" class="row jobs-row"]`

= Something's not working. Is there a debug mode? =
Yes, but it's a little technical to enable. In the root file, applicantstacck-jobs.php on or around line 19, you'll find:

`define( 'APPLICANTSTACK_JOBS_DEBUG', false );`

Change **false** to **true** to enable debug mode. 

Debug mode doesn't do a heck of a lot except output the raw API return in decoded JSON in the event fields are mapping correctly in the named array or whatever.

Don't forget to change it back to false once you've got it working.

== Screenshots ==

1. How the jobs will appear on the frontend
2. The (very simple) plugin settings page

== Changelog ==

= 1.1 =
* Filter for special characters

= 1.0 =
* Stable Release
* Add Filter by Department

= 0.2 =
* Add API Integration
* Add Update Warning

= 0.1 =
* Initial release

== Upgrade Notice ==

= 0.2 =
Update the plugin for the latest features.
