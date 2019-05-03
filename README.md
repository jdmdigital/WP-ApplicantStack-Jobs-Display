![alt text](https://github.com/jdmdigital/wp-applicantstack-jobs-display/blob/master/img/ApplicantStack-logo.png "ApplicantStack Jobs in WordPress")
# WP ApplicantStack Jobs Display 
A WordPress plugin which displays a responsive, filterable list of jobs from ApplicantStack's Jobs API using a Shortcode.

## Description
Using the [Applicant Stack API](https://help.applicantstack.com/hc/en-us/articles/115000786273-API-Integration-Guide "API Integration Guide"), this plugin will display up to 100 of the Applicant Stack jobs you have listed.  

![alt text](https://github.com/jdmdigital/wp-applicantstack-jobs-display/blob/master/img/applicant-stack-jobs-display-screenshot.jpg "ApplicantStack Jobs Screenshot")

## Demo
We don't have a live demo to show you since we don't have our own ApplicantStack account to use, but there is a little visual demo for your viewing pleasure over on the announcement post here: https://jdmdig.it/2ZShFOi.

## Installation
1. Upload `wp-applicantstack-jobs-display` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Enter your ApplicantStack API Token and Domain Name in **Settings** >> **ApplicantStack Jobs**
1. Place the shortcode, `[applicantstack-jobs]` wherever you want the jobs list displayed.

## Usage
You will need an access token and username to access the Applicant Stack API. The access token is specific to each Applicant Stack customer. It can be found on the **Settings** >> **Edit Settings**.

You will also need your Applicant Stack domain.  Domain information is also available on the settings page. It will look something like:

`https://**MYDOMAIN**.applicantstack.com/`

Where **MYDOMAIN** is your Applicant Stack domain name.

The shortcode also includes two optional attributes: `id` and `class`.  These can be handy to change if you want it to use your own CSS rather than the CSS bundled with it. For example:

`[applicantstack-jobs id="jobs-custom" class="row jobs-row"]`

To remove the CSS the plugin registers, here's some sample code:
(need to write this, for beginners)

### Debug Mode
In the root file, `applicantstacck-jobs.php` on or around line 19, you'll find: 

`define( 'APPLICANTSTACK_JOBS_DEBUG', false );` 

Change `false` to `true` to enable debug mode.  Debug mode doesn't do a heck of a lot except output the raw API return in decoded JSON in the event fields are mapping correctly in the named array or whatever.

### Publisher/Plugin Name
In the root file, `applicantstacck-jobs.php` on or around line 18, you'll find: 

`define( 'APPLICANTSTACK_JOBS_NAME', 'ApplicantStack Jobs Plugin' );`  

That global variable definition is used in the API call in the "Publisher" header.  Presumably, you could change that if you wanted to know which API calls where coming from where.  

## Sorry; Not Sorry
It's not the most feature-rich plugin and the code is a little sloppy.  Consider this a starting place if you Googled "ApplicantStack WordPress Plugin" and found absolutely nothing--just like we did.

In other words, praise, forks, and pull requests are appreciated--more so than support or feature requests.
