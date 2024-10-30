<?php
// this file contains most of the generic functionality for the plugin. Footer functions are in footer_functions.php
/* declare some variables */
    $coremetricsUserID = get_option('coremetrics_userID');
    $coremetricsBlogID = get_option('coremetrics_blogID');
    $coremetricsEluminate = get_option('cm_eluminate_location');
    $coremetricsCustomScript = get_option('cm_custom_script');
    $cm_cookieDomain_val = get_option('cm_cookie_domain');
    $cm_clientManaged_val = get_option('cm_client_managed');
    $cm_dataCollection_val = get_option('cm_data_collection_domain');
    $cm_testOverride_val = get_option('cm_test_override');
    $cm_languageAttribute = get_option('cm_language_attribute');
    $cm_countryAttribute = get_option('cm_country_attribute');

/* Let's start off with the back-end bits and pieces... */
// add the menu...
function coremetrics_add_menu() {
    add_menu_page('Coremetrics tracking plugin admin', 'Coremetrics', 'manage_options', 'coremetrics-menu', 'show_admin_menu',  plugins_url('coremetrics/images/diagram_16.png'));
    add_submenu_page('coremetrics-menu', 'Coremetrics tracking plugin admin &raquo; event priorities', 'Event priorities', 'manage_options', 'coremetrics-event-priorities', 'show_event_priorities');
    add_submenu_page('coremetrics-menu', 'Coremetrics tracking plugin admin &raquo; user defined attributes', 'User defined attributes', 'manage_options', 'coremetrics-user-attributes', 'show_user_attributes');
    add_submenu_page('coremetrics-menu', 'Coremetrics tracking plugin admin &raquo; custom events', 'Custom event setup', 'manage_options', 'coremetrics-custom-events', 'show_custom_events');
}
// admin page CSS and scripts
function add_head_css() {
    echo '<link rel="stylesheet" href="' . plugins_url('coremetrics/styles/coremetrics_css.css') . '" media="screen,projection" type="text/css" />';
}
// this is the code the menu page uses...
function show_admin_menu() {
    include('core_admin.php');
}

function show_event_priorities () {
    include('event_priorities_admin.php');
}

function show_user_attributes() {
    include('user_attributes_admin.php');
}

function show_custom_events() {
    include('custom_events_admin.php');
}

/* Now the front-end bits and pieces */
function add_coremetrics_scripts() {

    add_action('wp_footer','footer_code','12');
    add_action('wp_footer','createPageViewTags','12');
    add_action('login_form','footer_code','12');
      add_action('register_form','footer_code','12');

    // add functions to footer
    function footer_code() {
        global $cm_testOverride_val;
         global $coremetricsUserID;
         global $coremetricsBlogID;
         global $coremetricsEluminate;
         global $coremetricsCustomScript;
         global $cm_cookieDomain_val;
         global $cm_clientManaged_val;
         global $cm_dataCollection_val;
         ## over-write the output if it's set to test
         ## in 1.1 add multiple user IDs
         if($cm_testOverride_val == 'test') {
             // set the user ID value with 6 as first digit
            // is the user ID a long string with semicolon delimeters?

            if (ereg(';', $coremetricsUserID)) {
            // it's a long string, so let's split it into an array first by semicolon:
                $cm_userID_array = split(';',$coremetricsUserID);

                //now pop it all back together into a single string:
                $finalIDarray = '';
                foreach ($cm_userID_array as $userID) {
                    $finalIDarray .= substr_replace($userID, '6', 0, 1) . ';';
                }

                $coremetricsUserID = rtrim($finalIDarray, ';');

            }
            else
            // it's a single value, so replace the first digit with 6
            {
                $coremetricsUserID = substr_replace($coremetricsUserID, '6', 0, 1);
            }



            $cm_clientManaged_val = 'false';
            $cm_dataCollection_val = 'testdata.coremetrics.com';
         }



    // carry out the check - are we tracking drafts? Is this page a draft?

    global $post;
    $cm_draftTracking = get_option('cm_track_drafts');
    if (isset($post->post_status)) { // added 3 June - check if we're in the admin system
    $cm_pageIsDraft = $post->post_status;
    } else {
        $cm_pageIsDraft = 'admin';
    }
    if($cm_draftTracking == 'false' && $cm_pageIsDraft == 'draft') {
        echo '<!-- no Coremetrics scripts here - draft page -->';
    }
    else {
        echo "<script src='" . $coremetricsEluminate . "'></script>" . "<script>cmSetClientID('" . $coremetricsUserID . "'," . $cm_clientManaged_val . ",'" . $cm_dataCollection_val . "','" . $cm_cookieDomain_val . "');</script>";
    }
    }
        
    // add functions linked to particular events
    add_action('comment_form','cmDisplayComment','11');
    add_action('comment_post','cmSubmitComment','11');
    add_action('wp_footer','cmCommentCode','11');
    add_action('register_form','cmDisplayRegistration','11');
   
    add_action('register_post','cmSubmitRegistration','11');
    add_action('wp_footer','cmRegistrationCode','11');
    add_action('admin_footer','cmRegistrationCode','11');
    add_action('login_form','cmRegistrationCode','11');
    add_action('login_form','cmUserLoginFormIn','11');
    add_action('wp_login','cmUserLoggedIn','11');
    add_action('wp_footer','cmUserLoggedInCode','11');
    add_action('wp_logout','cmUserLoggedOut','11');
    add_action('login_form','cmUserLoggedOutCode','11');
    add_action('admin_footer','cmUserLoggedOutCode','11');
    add_action('lostpassword_form','cmLostPasswordForm','11');
    add_action('lostpassword_post','cmLostPasswordSent','11');
    add_action('show_user_profile','cmUpdateProfileForm','11');
    add_action('profile_update','cmUpdateProfileSent','11');
    add_action('show_user_profile','cmProfileUpdated','11');

    add_action('register_form','footer_code','11');
    add_action('register_form','createPageViewTags','11');
    add_action('profile_update','footer_code','11');
    add_action('profile_update','createPageViewTags','11');

} ?>