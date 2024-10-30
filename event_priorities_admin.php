
<div class="wrap">
    <div id="icon-coremetrics" class="icon32"></div>
    <h2>Event points</h2>
     <?php
    // form submit check
    $hidden_field_name = 'coremetrics_events_submit_hidden';
    // read in existing values from database
    $cm_EventPoints = get_option('cm_eventpoints_option');
    $cm_EventPointOn = get_option('cm_eventpoints_onoff');
    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
        // Update individual options if set
        $cm_DisplayCommentEP_val = $_POST['Displaycommentform'];
        $cm_PostCommentEP_val = $_POST['Commentformsubmitted'];
        $cm_DisplayRegistrationEP_val = $_POST['Displayregistrationform'];
        $cm_PostRegistrationEP_val = $_POST['Registrationformposted'];
        $cm_LoginFormEP_val = $_POST['Displayloginform'];
        $cm_LoginCompleteEP_val = $_POST['Logincompleted'];
        $cm_LogoutCompleteEP_val = $_POST['Logoutcompleted'];
        $cm_UpdateProfileFormEP_val = $_POST['Displayprofileupdateform'];
        $cm_ProfileUpdatedEP_val = $_POST['Profileupdateformposted'];
        $cm_LostPasswordEP_val = $_POST['Diplaylostpasswordform'];
        $cm_LostPasswordCompleteEP_val = $_POST['Lostpasswordformcompleted'];
        $cm_passwordResetEP_val = $_POST['Passwordresetcomplete'];

        // Update on/off for each event

        $cm_DisplayCommentOn_val = $_POST['Displaycommentform_on'];
        $cm_PostCommentOn_val = $_POST['Commentformsubmitted_on'];
        $cm_DisplayRegistrationOn_val = $_POST['Displayregistrationform_on'];
        $cm_PostRegistrationOn_val = $_POST['Registrationformposted_on'];
        $cm_LoginFormOn_val = $_POST['Displayloginform_on'];
        $cm_LoginCompleteOn_val = $_POST['Logincompleted_on'];
        $cm_LogoutCompleteOn_val = $_POST['Logoutcompleted_on'];
        $cm_UpdateProfileFormOn_val = $_POST['Displayprofileupdateform_on'];
        $cm_ProfileUpdatedOn_val = $_POST['Profileupdateformposted_on'];
        $cm_LostPasswordOn_val = $_POST['Diplaylostpasswordform_on'];
        $cm_LostPasswordCompleteOn_val = $_POST['Lostpasswordformcompleted_on'];
        $cm_passwordResetOn_val = $_POST['Passwordresetcomplete_on'];


        // Save the posted value in the database
        if(isset($cm_DisplayCommentEP_val)) {
            if (is_numeric($cm_DisplayCommentEP_val)) {
                $cm_EventPoints['Display comment form'] = $cm_DisplayCommentEP_val;
            }
            else {
                $errorMessage = '1';
            }
        }
        if(isset($cm_PostCommentEP_val)) {
            if (is_numeric($cm_PostCommentEP_val)) {
            $cm_EventPoints['Comment form submitted'] = $cm_PostCommentEP_val;
            }
            else {
                $errorMessage = '2';
            }
        }
        if(isset($cm_DisplayRegistrationEP_val)) {
            if (is_numeric($cm_DisplayRegistrationEP_val)) {
            $cm_EventPoints['Display registration form'] = $cm_DisplayRegistrationEP_val;
            }
            else {
                $errorMessage = '3';
            }
        }
        if(isset($cm_PostRegistrationEP_val)) {
            if (is_numeric($cm_PostRegistrationEP_val)) {
            $cm_EventPoints['Registration form posted'] = $cm_PostRegistrationEP_val;
            }
            else {
                $errorMessage = '4';
            }
        }
        if(isset($cm_LoginFormEP_val)) {
            if (is_numeric($cm_LoginFormEP_val)) {
            $cm_EventPoints['Display login form'] = $cm_LoginFormEP_val;
            }
            else {
                $errorMessage = '5';
            }
        }
        if(isset($cm_LoginCompleteEP_val)) {
            if (is_numeric($cm_LoginCompleteEP_val)) {
            $cm_EventPoints['Login completed'] = $cm_LoginCompleteEP_val;
            }
            else {
                $errorMessage = '6';
            }
        }
        if(isset($cm_LogoutCompleteEP_val)) {
            if (is_numeric($cm_LogoutCompleteEP_val)) {
            $cm_EventPoints['Logout completed'] = $cm_LogoutCompleteEP_val;
            }
            else {
                $errorMessage = '7';
            }
        }
        if(isset($cm_UpdateProfileFormEP_val)) {
            if (is_numeric($cm_UpdateProfileFormEP_val)) {
            $cm_EventPoints['Display profile update form'] = $cm_UpdateProfileFormEP_val;
            }
            else {
                $errorMessage = '8';
            }
        }
        if(isset($cm_ProfileUpdatedEP_val)) {
            if (is_numeric($cm_ProfileUpdatedEP_val)) {
            $cm_EventPoints['Profile update form posted'] = $cm_ProfileUpdatedEP_val;
            }
            else {
                $errorMessage = '9';
            }
        }
        if(isset($cm_LostPasswordEP_val)) {
            if (is_numeric($cm_LostPasswordEP_val)) {
            $cm_EventPoints['Diplay lost password form'] = $cm_LostPasswordEP_val;
            }
            else {
                $errorMessage = '10';
            }
        }
        if(isset($cm_LostPasswordCompleteEP_val)) {
            if (is_numeric($cm_LostPasswordCompleteEP_val)) {
            $cm_EventPoints['Lost password form completed'] = $cm_LostPasswordCompleteEP_val;
            }
            else {
                $errorMessage = '11';
            }
        }
        if(isset($cm_passwordResetEP_val)) {
            if (is_numeric($cm_passwordResetEP_val)) {
            $cm_EventPoints['Password reset complete'] = $cm_passwordResetEP_val;
            }
            else {
                $errorMessage = '12';
            }
        }

        if(isset($cm_DisplayCommentOn_val)) {
                $cm_EventPointOn['Display comment form'] = $cm_DisplayCommentOn_val;
        }

        if(isset($cm_PostCommentOn_val)) {
                $cm_EventPointOn['Comment form submitted'] = $cm_PostCommentOn_val;
        }

        if(isset($cm_DisplayRegistrationOn_val)) {
                $cm_EventPointOn['Display registration form'] = $cm_DisplayRegistrationOn_val;
        }

        if(isset($cm_PostRegistrationOn_val)) {
                $cm_EventPointOn['Registration form posted'] = $cm_PostRegistrationOn_val;
        }

        if(isset($cm_LoginFormOn_val)) {
                $cm_EventPointOn['Display login form'] = $cm_LoginFormOn_val;
        }

        if(isset($cm_LoginCompleteOn_val)) {
                $cm_EventPointOn['Login completed'] = $cm_LoginCompleteOn_val;
        }

        if(isset($cm_LogoutCompleteOn_val)) {
                $cm_EventPointOn['Logout completed'] = $cm_LogoutCompleteOn_val;
        }

        if(isset($cm_UpdateProfileFormOn_val)) {
                $cm_EventPointOn['Display profile update form'] = $cm_UpdateProfileFormOn_val;
        }

        if(isset($cm_ProfileUpdatedOn_val)) {
                $cm_EventPointOn['Profile update form posted'] = $cm_ProfileUpdatedOn_val;
        }

        if(isset($cm_LostPasswordOn_val)) {
                $cm_EventPointOn['Diplay lost password form'] = $cm_LostPasswordOn_val;
        }

        if(isset($cm_LostPasswordCompleteOn_val)) {
                $cm_EventPointOn['Lost password form completed'] = $cm_LostPasswordCompleteOn_val;
        }

        if(isset($cm_passwordResetOn_val)) {
                $cm_EventPointOn['Password reset complete'] = $cm_passwordResetOn_val;
        }


     update_option('cm_eventpoints_option',$cm_EventPoints);
     update_option('cm_eventpoints_onoff',$cm_EventPointOn);
        // Put an settings updated message on the screen
        if (isset($errorMessage)) {
                switch ($errorMessage) {
                    case '1' : echo '<div class="error"><p><strong>Please enter a numerical value for "Display comment form"</strong></p></div>';
                    case '2' : echo '<div class="error"><p><strong>Please enter a numerical value for "Comment form submitted"</strong></p></div>';
                    case '3' : echo '<div class="error"><p><strong>Please enter a numerical value for "Display registration form"</strong></p></div>';
                    case '4' : echo '<div class="error"><p><strong>Please enter a numerical value for "Registration form posted"</strong></p></div>';
                    case '5' : echo '<div class="error"><p><strong>Please enter a numerical value for "Display login form"</strong></p></div>';
                    case '6' : echo '<div class="error"><p><strong>Please enter a numerical value for "Login completed"</strong></p></div>';
                    case '7' : echo '<div class="error"><p><strong>Please enter a numerical value for "Logout completed"</strong></p></div>';
                    case '8' : echo '<div class="error"><p><strong>Please enter a numerical value for "Display profile update form"</strong></p></div>';
                    case '9' : echo '<div class="error"><p><strong>Please enter a numerical value for "Profile update form posted"</strong></p></div>';
                    case '10' : echo '<div class="error"><p><strong>Please enter a numerical value for "Display lost password form"</strong></p></div>';
                    case '11' : echo '<div class="error"><p><strong>Please enter a numerical value for "Lost password form completed"</strong></p></div>';
                    case '12' : echo '<div class="error"><p><strong>Please enter a numerical value for "Password reset complete"</strong></p></div>';
                }
             }
        else { ?>
            <div class="updated"><p><strong>Settings saved</strong></p></div>
        <?php }
    }
    ?>
<form name="cm_mainSettings" method="post" action="" id="cm_mainSettings_ID">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
<p>Use the following form to set event points for each of the events listed below. You can enter any numerical value; make sure that your event points on this blog tie up with event points on related sites!</p>
<?php
foreach ($cm_EventPoints as $cm_event_key => $cm_event_value) {
    $cm_eventTrueOutput = '';
    $cm_eventFalseOutput = '';
    if ($cm_EventPointOn[$cm_event_key] == 'true'){ $cm_eventTrueOutput = 'checked'; }
   else if ($cm_EventPointOn[$cm_event_key] == 'false'){ $cm_eventFalseOutput = 'checked'; }
    $cm_eventOnOffString = ' <input type="radio" name="' . str_replace (" ", "", $cm_event_key) .  '_on" value="true" ' . $cm_eventTrueOutput . ' />On <input type="radio" name="' . str_replace (" ", "", $cm_event_key) .  '_on" value="false" ' . $cm_eventFalseOutput . '> Off';
    echo '<p><input type="text" size="5" name="' . str_replace (" ", "", $cm_event_key) . '" value="' . $cm_event_value . '" title="' . $cm_event_key . '" /> ' .$cm_event_key . $cm_eventOnOffString . '</p>';
}
?>
<input type="submit" value="submit" />
</form>
</div>