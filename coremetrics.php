<?php
/*
Plugin Name: Coremetrics tracking BETA
Plugin URI: http://
Description: Stats tracking plugin for Coremetrics
Version: 1.2.2
Author: Adam Maltpress
Author URI: http://www.maltpress.co.uk
License: GPL2
*/

/*  Copyright 2010  ADAM MALTPRESS  (email : adam@maltpress.co.uk)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// define the plugin path so we can reuse it for includes

define('COREMETRICS_PATH', WP_CONTENT_DIR.'/plugins/'.plugin_basename(dirname(__FILE__)) );

// Now let's include the functions file
// Contains functions called by action hooks

include(COREMETRICS_PATH.'/coremetrics_functions.php');
include(COREMETRICS_PATH.'/footer_functions.php');
include(COREMETRICS_PATH.'/event_functions.php');
include(COREMETRICS_PATH.'/footer_test.php');

/* Now the action hooks themselves */

// create database for settings, and other activation jobs
register_activation_hook ( __FILE__, 'coremetrics_activate');
register_activation_hook ( __FILE__, 'cm_customEventDB_install');

// create menu items
add_action('admin_menu', 'coremetrics_add_menu');

// add admin actions
add_action('admin_head', 'add_head_css');
add_action('admin_footer','footer_code');
add_action('login_form','footer_code');
add_action('admin_footer','cmUserLoggedInCode');
add_action('edit_user_profile','cmUpdateProfileForm');


// add jQuery and other scripts to front end <head> - use WP's jQuery!
add_action('init', 'add_coremetrics_scripts');
add_action('init','setSession');
add_action('admin_init','setSession');

/* activation hook functions must be defined in root plugin file */

    // create DB for custom events
global $cm_customEventDB_version;
$cm_customEventDB_version = "1.0";
global $wpdb;

    function cm_customEventDB_install () {
   global $wpdb;
   global $cm_customEventDB_version;
   $table_name = $wpdb->prefix . "cmCustomEvents";
   if($wpdb->get_var("show tables like '$table_name'") != $table_name) {

      $sql = "CREATE TABLE " . $table_name . " (
	  id mediumint(9) NOT NULL AUTO_INCREMENT,
	  functionID text NOT NULL,
          eventIdentifier text NOT NULL,
          eventOrder mediumint(9) NOT NULL,
          eventPoints mediumint(9) NOT NULL,
	  UNIQUE KEY id (id)
	);";

      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);



      add_option("cm_customEventDB_version", $cm_customEventDB_version);

   }
}

function coremetrics_activate() {
    // get site domain
    $cmSiteDomain = $_SERVER['SERVER_NAME'];
    // set default option variables
    // client managed? True or false. Default is false.
    update_option('cm_client_managed','false');
    // data collection domain
    update_option('cm_data_collection_domain','analytics.trendmicro.com');
    // Cookie domain
    update_option('cm_cookie_domain',$cmSiteDomain);
    // eluminate code location
    update_option('cm_eluminate_location','//libs.coremetrics.com/eluminate.js');
    // track drafts or not? Default is false.
    update_option('cm_track_drafts','false');

    // create the initial event points
    $cm_initialEventPoints = array(
        'Display comment form' => '0',
        'Comment form submitted'=>'100',
        'Display registration form'=>'0',
        'Registration form posted'=>'300',
        'Display login form'=>'0',
        'Login completed'=>'50',
        'Logout completed'=>'10',
        'Display profile update form'=>'0',
        'Profile update form posted'=>'50',
        'Diplay lost password form'=>'0',
        'Lost password form completed'=>'10',
        'Password reset complete'=>'10'
    );

    update_option('cm_eventpoints_option',$cm_initialEventPoints);

    // create the initial event point on/off settings
    // default is display comment form off, all others on.

    $cm_initialEventPointOn = array(
        'Display comment form' => 'false',
        'Comment form submitted'=>'true',
        'Display registration form'=>'true',
        'Registration form posted'=>'true',
        'Display login form'=>'true',
        'Login completed'=>'true',
        'Logout completed'=>'true',
        'Display profile update form'=>'true',
        'Profile update form posted'=>'true',
        'Diplay lost password form'=>'true',
        'Lost password form completed'=>'true',
        'Password reset complete'=>'true'
    );

    update_option('cm_eventpoints_onoff',$cm_initialEventPointOn);

    
    
    // create the initial user-defined attributes option
    $cm_userAttributesTactical = array (
        "tacticalAttribute1" => array (
        "prefix" => "",
        "value" => "",
        "suffix" => ""
    ),
        "tacticalAttribute2" => array (
        "prefix" => "",
        "value" => "",
        "suffix" => ""
    ),
        "tacticalAttribute3" => array (
        "prefix" => "",
        "value" => "",
        "suffix" => ""
    ),
        "tacticalAttribute4" => array (
        "prefix" => "",
        "value" => "",
        "suffix" => ""
    ),
        "tacticalAttribute5" => array (
        "prefix" => "",
        "value" => "",
        "suffix" => ""
    )
    );
    
    $cm_userAttributesStrategic = array (
        "strategicAttribute1" => array (
        "prefix" => "",
        "value" => "",
        "suffix" => ""
    ),
    "strategicAttribute2" => array (
        "prefix" => "",
        "value" => "",
        "suffix" => ""
    ),"strategicAttribute3" => array (
        "prefix" => "",
        "value" => "",
        "suffix" => ""
    ),"strategicAttribute4" => array (
        "prefix" => "",
        "value" => "",
        "suffix" => ""
    ),"strategicAttribute5" => array (
        "prefix" => "",
        "value" => "",
        "suffix" => ""
    ),"strategicAttribute6" => array (
        "prefix" => "",
        "value" => "",
        "suffix" => ""
    ),"strategicAttribute7" => array (
        "prefix" => "",
        "value" => "",
        "suffix" => ""
    ),"strategicAttribute8" => array (
        "prefix" => "",
        "value" => "",
        "suffix" => ""
    ),"strategicAttribute9" => array (
        "prefix" => "",
        "value" => "",
        "suffix" => ""
    ),"strategicAttribute10" => array (
        "prefix" => "",
        "value" => "",
        "suffix" => ""
    )  
    );
    update_option('cm_tactical_attributes',$cm_userAttributesTactical);
    update_option('cm_strategic_attributes',$cm_userAttributesStrategic);
    update_option('cm_attribute_override','default');
}

    // from 1.1 - custom event function, called by short code or added direct
    // This adds a function to the footer
    // Function added to footer calls event from DB and echoes the JS

    function cmCustomEventTag($atts) {
        global $wpdb;
        global $cm_eventAttr_array;
        
        $cm_event_tablename = $wpdb->prefix . "cmCustomEvents";
        extract(shortcode_atts(array('event' => 'none','order' => '1'),$atts));
        // get the event details from the DB
        $cm_eventsCalled = $wpdb->get_results("SELECT * FROM $cm_event_tablename WHERE functionID='$event' AND eventOrder='$order'", ARRAY_A);
        $cm_eventAttr_order = $order;
        $cm_eventAttr_name = $cm_eventsCalled[0]['eventIdentifier'];
        $cm_eventAttr_eventPoints = $cm_eventsCalled[0]['eventPoints'];
        $cm_eventAttr_array = array('event_name' => $cm_eventAttr_name, 'event_order' => $cm_eventAttr_order, 'event_points' => $cm_eventAttr_eventPoints);
        add_action('wp_footer','createCustomEventTag',10,1);
    }

    function createCustomEventTag() {
        global $cm_eventAttr_array;
        global $coremetricsBlogID;
        $displayCustomEventTag = 'cmCreateConversionEventTag("' . $coremetricsBlogID . ' ' . $cm_eventAttr_array['event_name'] . '","' . $cm_eventAttr_array['event_order'] . '","' . $coremetricsBlogID . ' Events","' . $cm_eventAttr_array['event_points'] . '","' . wp_title('',false) . '");';
        echo addScriptTags($displayCustomEventTag);
    }

    // now we need a version which does everything from attributes passed to it so users can add this to their own functions
    function cmCustomEventManual($eventCalled, $eventOrder) {
        global $wpdb;
        global $cm_eventAttr_manual_array;
        $cm_event_tablename = $wpdb->prefix . "cmCustomEvents";
         // get the event details from the DB
        $cm_eventsCalled = $wpdb->get_results("SELECT * FROM $cm_event_tablename WHERE functionID='$eventCalled' AND eventOrder='$eventOrder'", ARRAY_A);
        $cm_eventAttr_order = $eventOrder;
        $cm_eventAttr_name = $cm_eventsCalled[0]['eventIdentifier'];
        $cm_eventAttr_eventPoints = $cm_eventsCalled[0]['eventPoints'];
        $cm_eventAttr_manual_array = array('event_name' => $cm_eventAttr_name, 'event_order' => $cm_eventAttr_order, 'event_points' => $cm_eventAttr_eventPoints);
        add_action('wp_footer','createManualEventTag');
        function createManualEventTag() {
            global $cm_eventAttr_manual_array;
            global $coremetricsBlogID;
            $displayManualEventTag = 'cmCreateConversionEventTag("' . $coremetricsBlogID . ' ' . $cm_eventAttr_manual_array['event_name'] . '","' . $cm_eventAttr_manual_array['event_order'] . '","' . $coremetricsBlogID . ' Events","' . $cm_eventAttr_manual_array['event_points'] . '","' . wp_title('',false) . '");';
            echo addScriptTags($displayManualEventTag);
        }
    }

    // from 1.1 - register shortcode
    add_shortcode('cmcustom','cmCustomEventTag');

?>