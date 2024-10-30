<?php

/* these functions are linked to particular events */

// need to get all the event points from array

$cm_EventPoints = get_option('cm_eventpoints_option');

$cm_DisplayCommentEP = $cm_EventPoints['Display comment form'];
$cm_PostCommentEP = $cm_EventPoints['Comment form submitted'];
$cm_DisplayRegistrationEP = $cm_EventPoints['Display registration form'];
$cm_PostRegistrationEP = $cm_EventPoints['Registration form posted'];
$cm_LoginFormEP = $cm_EventPoints['Display login form'];
$cm_LoginCompleteEP = $cm_EventPoints['Login completed'];
$cm_LogoutCompleteEP = $cm_EventPoints['Logout completed'];
$cm_UpdateProfileFormEP = $cm_EventPoints['Display profile update form'];
$cm_ProfileUpdatedEP = $cm_EventPoints['Profile update form posted'];
$cm_LostPasswordEP = $cm_EventPoints['Diplay lost password form'];
$cm_LostPasswordCompleteEP = $cm_EventPoints['Lost password form completed'];
$cm_passwordResetEP = $cm_EventPoints['Password reset complete'];

// now we get all the event point on or off values

$cm_EventPointOn = get_option('cm_eventpoints_onoff');

$cm_DisplayCommentOn = $cm_EventPointOn['Display comment form'];
$cm_PostCommentOn = $cm_EventPointOn['Comment form submitted'];
$cm_DisplayRegistrationOn = $cm_EventPointOn['Display registration form'];
$cm_PostRegistrationOn = $cm_EventPointOn['Registration form posted'];
$cm_LoginFormOn = $cm_EventPointOn['Display login form'];
$cm_LoginCompleteOn = $cm_EventPointOn['Login completed'];
$cm_LogoutCompleteOn = $cm_EventPointOn['Logout completed'];
$cm_UpdateProfileFormOn = $cm_EventPointOn['Display profile update form'];
$cm_ProfileUpdatedOn = $cm_EventPointOn['Profile update form posted'];
$cm_LostPasswordOn = $cm_EventPointOn['Diplay lost password form'];
$cm_LostPasswordCompleteOn = $cm_EventPointOn['Lost password form completed'];
$cm_passwordResetOn = $cm_EventPointOn['Password reset complete'];

function setSession() {
   
    if (!isset($_SESSION)) { // added 3 June: check if session already exists
        session_start();
    }
}

function addScriptTags ($input) {
    $output = '<script type="text/javascript">' . $input . '</script>';
    return $output;
}

// function for event tag when comment form displayed or if comment has been added
function cmDisplayComment() {
    add_action('wp_footer','cmDisplayCommentFinal');
    function cmDisplayCommentFinal(){
        global $cm_DisplayCommentOn;
    if (!isset($_SESSION['commentAdded'])) {
            // carry out the check - are we tracking drafts? Is this page a draft?
                global $post;
                $cm_draftTracking = get_option('cm_track_drafts');
                $cm_pageIsDraft = $post->post_status;

                if($cm_draftTracking == 'false' && $cm_pageIsDraft == 'draft') {
                    echo '<!-- no Coremetrics tracking - draft page -->';
                }

                else if ($cm_DisplayCommentOn == 'false') {
                    echo '<!-- event tracking for this event is off -->';
                }

                else {
                        //declare variables
                    global $coremetricsBlogID;
                    // $cm_DisplayCommentEP is event point value for displaying comments
                    global $cm_DisplayCommentEP;
                    $displayCommentTag = 'cmCreateConversionEventTag("' . $coremetricsBlogID . ' Comment","1","' . $coremetricsBlogID . ' Events","' . $cm_DisplayCommentEP . '","' . wp_title('',false) . '");';
                    echo addScriptTags($displayCommentTag);
                }
        }
    }
}

function cmSubmitComment() {
    // this function sets a session to say that a comment has been added. Whatever page the user is directed to, this info will be available
    if (!isset($_SESSION)) {
        session_start();
    }
    $_SESSION['commentAdded'] = 'true';        
}

function cmCommentCode() {
    // this goes in the footer. We need to check that a comment has been added...
global $cm_PostCommentOn;
        if (isset($_SESSION['commentAdded'])) {
        // carry out the check - are we tracking drafts? Is this page a draft?
            global $post;
            $cm_draftTracking = get_option('cm_track_drafts');
            $cm_pageIsDraft = $post->post_status;
            if($cm_draftTracking == 'false' && $cm_pageIsDraft == 'draft') {
                echo '<!-- no Coremetrics tracking - draft page -->';
            }

            else if ($cm_PostCommentOn == 'false') {
                    echo '<!-- event tracking for this event is off -->';
                }

            else {
            //    declare variables
            global $coremetricsBlogID;
            //$cm_PostommentEP is event point value for posting comments
            global $cm_PostCommentEP;
            $displayCommentTag = 'cmCreateConversionEventTag("' . $coremetricsBlogID . ' Comment","2","' . $coremetricsBlogID . ' Events","' . $cm_PostCommentEP . '","' . wp_title('',false) . '");';
            echo addScriptTags($displayCommentTag);
            // now that's done, we can kill the session variable
            unset($_SESSION['commentAdded']);
            }
    }
}

// registration functions

function cmDisplayRegistration () {
    // this goes immediately after the registration form
    global $cm_DisplayRegistrationOn;
    if ($cm_DisplayRegistrationOn == 'false') {
        echo '<!-- event tracking for this event is off -->';
    }
    else {
    //declare variables
    global $coremetricsBlogID;
    // $cm_DisplayCommentEP is event point value for displaying comments
    global $cm_DisplayRegistrationEP;
    $displayRegistrationTag = 'cmCreateConversionEventTag("' . $coremetricsBlogID . ' Register","1","' . $coremetricsBlogID . ' Events","' . $cm_DisplayRegistrationEP . '","' . wp_title('',false) . '");';
    echo addScriptTags($displayRegistrationTag);
    }
    
}

function cmSubmitRegistration () {
        if (!isset($_SESSION)) {
            session_start();
        }
    $_SESSION['registrationComplete'] = 'true'; 
}

function cmRegistrationCode() {
    global $cm_PostRegistrationOn;
    // only need to do this if turned on... the plugin, I mean.
    if ($cm_PostRegistrationOn == 'false') {
        echo '<!-- event tracking for this event is off -->';
    }
    else {
    // this goes in the footer. We need to check that the registration is complete...
    if (isset($_SESSION['registrationComplete'])) {
    //    declare variables
    global $coremetricsBlogID;
    //$cm_PostRegistrationEP is event point value for posting the registration form
    global $cm_PostRegistrationEP;
    $displayRegistrationTag = 'cmCreateConversionEventTag("' . $coremetricsBlogID . ' Register","2","' . $coremetricsBlogID . ' Events","' . $cm_PostRegistrationEP . '","' . wp_title('',false) . '");';
    echo addScriptTags($displayRegistrationTag);
    // now that's done, we can kill the session variable
    unset($_SESSION['registrationComplete']);
    }
    }
}

// login functions

function cmUserLoginFormIn() {
    // this event can carry several codes depending on the state
    
   
     
    //declare variables
    global $coremetricsBlogID;
    global $cm_LoginFormOn;
    global $cm_LostPasswordCompleteOn;
    global $cm_LoginCompleteOn;
    // $cm_LoginFormEP is event point value for displaying the login form
    
    if ($cm_LoginFormOn == 'false') { echo '<!-- event tracking for this event is off -->'; }
    else {
    global $cm_LoginFormEP;
    $displayLoginTag = 'cmCreateConversionEventTag("' . $coremetricsBlogID . ' Login","1","' . $coremetricsBlogID . ' Events","' . $cm_LoginFormEP . '","' . wp_title('',false) . '");';
    echo addScriptTags($displayLoginTag);
    }

     // Lost password complete...
    if (isset($_SESSION['lostpasswordComplete'])) {
        if ($cm_LostPasswordCompleteOn == 'false') { echo '<!-- event tracking for this event is off -->'; }
    else {
        //    declare variables
        global $coremetricsBlogID;
        //$cm_LoginCompleteEP is event point value for posting the registration form
        global $cm_LostPasswordCompleteEP;
        $displayLostPasswordTag = 'cmCreateConversionEventTag("' . $coremetricsBlogID . ' Lost Password","2","' . $coremetricsBlogID . ' Events","' . $cm_LostPasswordCompleteEP . '","' . wp_title('',false) . '");';
        echo addScriptTags($displayLostPasswordTag);
        // now that's done, we can kill the session variable. Kill it with fire!
        unset($_SESSION['lostpasswordComplete']);
        }
    }

     if ((isset($_GET['action']) && $_GET['action'] == 'rp') || (isset($_GET['action']) && $_GET['action'] == 'lostpassword') || (isset($_GET['checkemail']) && $_GET['checkemail'] == 'newpass')) {
        //    declare variables
        global $coremetricsBlogID;
        //$cm_LoginCompleteEP is event point value for posting the registration form
        if ($cm_LoginCompleteOn == 'false') {echo '<!-- event tracking for this event is off -->'; }
        else {
        global $cm_passwordResetEP;
        $displaypasswordResetTag = 'cmCreateConversionEventTag("' . $coremetricsBlogID . ' Password Reset","2","' . $coremetricsBlogID . ' Events","' . $cm_passwordResetEP . '","' . wp_title('',false) . '");';
        echo addScriptTags($displaypasswordResetTag);
        }
     }
    
}

function cmUserLoggedIn () {
    if (!isset($_SESSION)) {
        session_start();
    }
    $_SESSION['loginComplete'] = 'true';
}

function cmUserLoggedInCode () {
     // this goes in the footer. We need to check that the login is complete...
    if (isset($_SESSION['loginComplete'])) {


        // carry out the check - are we tracking drafts? Is this page a draft?

        global $post;
        global $cm_LoginCompleteOn;
        $cm_draftTracking = get_option('cm_track_drafts');
        $cm_pageIsDraft = $post->post_status;

        if($cm_draftTracking == 'false' && $cm_pageIsDraft == 'draft') {
            echo '<!-- no Coremetrics tracking - draft page -->';
        }

        else if ($cm_LoginCompleteOn == 'false') { echo '<!-- event tracking for this event is off -->'; }

        else {
            //    declare variables
            global $coremetricsBlogID;
            //$cm_LoginCompleteEP is event point value for posting the registration form
            global $cm_LoginCompleteEP;
            $displayLoginTag = 'cmCreateConversionEventTag("' . $coremetricsBlogID . ' Login","2","' . $coremetricsBlogID . ' Events","' . $cm_LoginCompleteEP . '","' . wp_title('',false) . '");';
            echo addScriptTags($displayLoginTag);
            // now that's done, we can kill the session variable
            unset($_SESSION['loginComplete']);
        }


    }
}

// logout functions

function cmUserLoggedOut() {
   if (!isset($_SESSION)) {
     session_start();
   }
    $_SESSION['logoutComplete'] = 'true';
}

function cmUserLoggedOutCode () {
    global $cm_LogoutCompleteOn;
     // this goes in the footer. We need to check that the login is complete...
    if (isset($_SESSION['logoutComplete'])) {
      if ($cm_LogoutCompleteOn == 'false') { echo '<!-- event tracking for this event is off -->'; }
    else {
    //    declare variables
    global $coremetricsBlogID;
    //$cm_LoginCompleteEP is event point value for posting the registration form
    global $cm_LogoutCompleteEP;
    $displayLogoutTag = 'cmCreateConversionEventTag("' . $coremetricsBlogID . ' Logout","2","' . $coremetricsBlogID . ' Events","' . $cm_LogoutCompleteEP . '","' . wp_title('',false) . '");';
    echo addScriptTags($displayLogoutTag);
    // now that's done, we can kill the session variable
    unset($_SESSION['logoutComplete']);
    }
    }
}

// profile functions

function cmUpdateProfileForm () {
    global $cm_UpdateProfileFormOn;
    if (!isset($_SESSION['profileUpdated'])) {
    add_action('wp_footer','cmUpdateProfileFormFinal');
    add_action('admin_footer','cmUpdateProfileFormFinal');
    function cmUpdateProfileFormFinal () {
    if ($cm_UpdateProfileFormOn == 'false') {echo  '<!-- event tracking for this event is off -->'; }
    else {
    // declare variables
    global $coremetricsBlogID;
    // $cm_UpdateProfileFormEP is event point value for displaying the update profile form
    global $cm_UpdateProfileFormEP;
    $displayProfileFormTag = 'cmCreateConversionEventTag("' . $coremetricsBlogID . ' Profile Update","1","' . $coremetricsBlogID . ' Events","' . $cm_UpdateProfileFormEP . '","' . wp_title('',false) . '");';
    echo addScriptTags($displayProfileFormTag);
    return createPageViewTags();
    }
    }
    }
}

function cmUpdateProfileSent () {
    if (!isset($_SESSION)) {
        session_start();
    }
    $_SESSION['profileUpdated'] = 'true';
}

function cmProfileUpdated () {
    add_action('wp_footer','cmProfileUpdatedFinal');
    add_action('admin_footer','cmProfileUpdatedFinal');
    function cmProfileUpdatedFinal () {
    global $cm_ProfileUpdatedOn;
        if (isset($_SESSION['profileUpdated'])) {
        if ($cm_ProfileUpdatedOn == 'false') {echo  '<!-- event tracking for this event is off -->'; }
    else {
        // declare variables
        global $coremetricsBlogID;
        // $cm_UpdateProfileFormEP is event point value for displaying the update profile form
        global $cm_ProfileUpdatedEP;
        $displayProfileFormTag = 'cmCreateConversionEventTag("' . $coremetricsBlogID . ' Profile Update","2","' . $coremetricsBlogID . ' Events","' . $cm_ProfileUpdatedEP . '","' . wp_title('',false) . '");';
        echo addScriptTags($displayProfileFormTag);
        unset ($_SESSION['profileUpdated']);
    }
    }
    }
}

// Lost password function

function cmLostPasswordForm() {

     
    //declare variables
    global $coremetricsBlogID;
    global $cm_LostPasswordOn;
    // $cm_LostPasswordEP is event point value for displaying the lost password form
    if ($cm_LostPasswordOn == 'false') {echo  '<!-- event tracking for this event is off -->'; }
    else {
    global $cm_LostPasswordEP;
    $displayLostPasswordTag = 'cmCreateConversionEventTag("' . $coremetricsBlogID . ' Lost Password","1","' . $coremetricsBlogID . ' Events","' . $cm_LostPasswordEP . '","' . wp_title('',false) . '");';
    echo addScriptTags($displayLostPasswordTag);
    }
    
}

function cmLostPasswordSent () {
    if (!isset($_SESSION)) {
        session_start();
    }
    $_SESSION['lostpasswordComplete'] = 'true';
}

// Password reset function

function cmPasswordRetrieve () {
    if (!isset($_SESSION)) {
        session_start();
    }
    $_SESSION['passwordSent'] = 'true';
}

?>