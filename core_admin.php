
<div class="wrap">

<?php  if (!current_user_can('manage_options'))
    {
      wp_die( __('You do not have sufficient permissions to access this page.') );
    }
?>
    <div id="icon-coremetrics" class="icon32"></div>
    <h2>Coremetrics core settings</h2>
    <?php
    // form submit check
    $hidden_field_name = 'coremetrics_submit_hidden';
    $errorMessage = '';

    // Read in existing option value from database
    $cm_userID_val = get_option('coremetrics_userID');
    $cm_blogID_val = get_option('coremetrics_blogID');
    $cm_cookieDomain_val = get_option('cm_cookie_domain');
    $cm_clientManaged_val = get_option('cm_client_managed');
    $cm_dataCollection_val = get_option('cm_data_collection_domain');
    $cm_eluminateLoc_val = get_option('cm_eluminate_location');
    $cm_customScript_val = get_option('cm_custom_script');
    $cm_customPageID_val = get_option('cm_custom_pageID');
    $cm_testOverride_val = get_option('cm_test_override');
    $cm_countryAttribute = get_option('cm_country_attribute');
    $cm_languageAttribute = get_option('cm_language_attribute');
    $cm_trackDraft_val = get_option('cm_track_drafts');

    $cm_error_dismissed = '';
    if (isset($_POST['dismiss_error']) && $_POST['dismiss_error'] != '') {
            $cm_error_dismissed = $_POST['dismiss_error'];
            update_option('cm_dismiss_option', $cm_error_dismissed);
            test_head_footer_notices();
        }

    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
        // Update individual options if set
        $cm_userID_val = $_POST[ 'coremetrics_userID_field' ];
        $cm_blogID_val = $_POST['coremetrics_blogID_field'];
        $cm_cookieDomain_val = $_POST['coremetrics_cookieDomain_field'];
        $cm_clientManaged_val = $_POST['coremetrics_clientManaged_field'];
        $cm_dataCollection_val = $_POST['coremetrics_dataCollection_field'];
        $cm_eluminateLoc_val = $_POST['coremetrics_eluminateLoc_field'];
        $cm_customScript_val = $_POST['coremetrics_customScript_field'];
        $cm_customPageID_val = $_POST['coremetrics_customPageID_field'];
        $cm_testOverride_val = $_POST['cm_testOverride_field'];
        $cm_languageAttribute = $_POST['coremetrics_blogLanguage_field'];
        $cm_countryAttribute = $_POST['coremetrics_blogCountry_field'];
        $cm_trackDraft_val = $_POST['coremetrics_trackDraft_field'];
        // Save the posted value in the database
        if(isset($cm_userID_val)) {
           update_option( 'coremetrics_userID', $cm_userID_val ); // need to check it's a proper user ID
        }

        // now update the options
        if(isset($cm_blogID_val)) {
            update_option( 'coremetrics_blogID', $cm_blogID_val );
        }

        if(isset($cm_cookieDomain_val)) {
            update_option('cm_cookie_domain',$cm_cookieDomain_val);
        }

          if(isset($cm_clientManaged_val)) {
            update_option('cm_client_managed',$cm_clientManaged_val);
        }
          if(isset($cm_dataCollection_val)) {
            update_option('cm_data_collection_domain',$cm_dataCollection_val);
        }
          if(isset($cm_eluminateLoc_val)) {
            update_option('cm_eluminate_location',$cm_eluminateLoc_val);
        }

         if(isset($cm_customScript_val)) {
            update_option('cm_custom_script',$cm_customScript_val);
        }

         if(isset($cm_customPageID_val)) {
            update_option('cm_custom_pageID',$cm_customPageID_val);
        }

        if(isset($cm_testOverride_val)) {
            update_option('cm_test_override',$cm_testOverride_val);
        }

        if(isset($cm_countryAttribute)) {
          update_option('cm_country_attribute',$cm_countryAttribute);
        }

        if(isset($cm_languageAttribute)) {
          update_option('cm_language_attribute',$cm_languageAttribute);
        }
        if(isset($cm_trackDraft_val)) {
            update_option('cm_track_drafts',$cm_trackDraft_val);
        }
        // Put an settings updated message on the screen
        if (!isset($errorMessage) || $errorMessage == '') { ?>
            <div class="updated"><p><strong>Settings saved</strong></p></div>
        <?php }
        else { ?>
            <div class="error"><p><strong><?php echo $errorMessage; ?></strong></p></div>
        <?php }
    } ?>


<form name="cm_mainSettings" method="post" action="" id="cm_mainSettings_ID">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
<p><strong>Core settings</strong></p>
<p>Coremetrics Blog ID:
<input type="text" name="coremetrics_blogID_field" value="<?php echo $cm_blogID_val; ?>" size="20" title="Blog ID field. Use something simple and short." />
</p>
<p>Country:
    <input type="text" name="coremetrics_blogCountry_field" value="<?php echo $cm_countryAttribute; ?>" size="20" title="Your blog country field. Used in page tag attributes." />
</p>
<p>Language:
    <input type="text" name="coremetrics_blogLanguage_field" value="<?php echo $cm_languageAttribute; ?>" size="20" title="Your blog's main language field. Used in page tag attributes." />
</p>
<p>Track draft pages?
    <select name="coremetrics_trackDraft_field" title="Set to true to track draft pages, false to not">
        <option value="true" <?php if ($cm_trackDraft_val == 'true') {echo "selected"; } ?>>True</option>
        <option value="false" <?php if ($cm_trackDraft_val == 'false') {echo "selected"; } ?>>False</option>
    </select>
</p>
<p><strong>Global parameters:</strong></p>
<p>cmSetClientID("<input type="text" name="coremetrics_userID_field" value="<?php echo $cm_userID_val; ?>" size="20" <?php if ($errorMessage == 'This isn\'t a valid Coremetrics user ID' ) {echo 'class="error_input"';} ?> title="Client ID - a unique 8-digit number you'll have been assigned.">",
    <select name="coremetrics_clientManaged_field" title="Set to true if you manage your data collection, false if Coremetrics manage it.">
        <option value="true" <?php if ($cm_clientManaged_val == 'true') {echo "selected"; } ?>>True</option>
        <option value="false" <?php if ($cm_clientManaged_val == 'false') {echo "selected"; } ?>>False</option>
    </select>,
    "<input type="text" name="coremetrics_dataCollection_field" value="<?php echo $cm_dataCollection_val; ?>" size="20" title="Data collection domain. This should be something like &quot;data.yoursite.com&quot;" />",
    "<input type="text" name="coremetrics_cookieDomain_field" value="<?php echo $cm_cookieDomain_val; ?>" size="20" title="Cookie domain. This is something like &quot;yoursite.com&quot; and needs to match the domain your blog is hosted on." />");
</p>
<p><strong>Eluminate script:</strong></p>
<p>&lt;script type="text/javascript" src="<input type="text" name="coremetrics_eluminateLoc_field" value="<?php echo $cm_eluminateLoc_val; ?>" size="40" title="Path to the Eluminate tracking script on your server." />"&gt;&lt;/script&gt;
</p>
<p><strong>Custom script:</strong></p>
<p>&lt;script type="text/javascript" src="<input type="text" name="coremetrics_customScript_field" value="<?php echo $cm_customScript_val; ?>" size="40" title="If you have a custom tracking script, add the path to it here. You can leave this blank if you wish." />"&gt;&lt;/script&gt;
<!-- 1.1: add custom page IDs -->


    <p><strong>Custom page ID:</strong></p>
    <p>You can create a custom page ID here. Leave this value blank to use the default value.</p>
    <p>This is intended to be javascript which dynamically creates a page ID. If you wish to hard code a single, site-wide value, enclose your value in single quotes.</p>
    <p>Custom page ID:<br />
        <textarea name="coremetrics_customPageID_field" rows="5" cols="40" title="You can create a custom page ID setup here. To hardcode a single value, make sure you enclose your ID in single quotes."><?php echo stripslashes($cm_customPageID_val); ?></textarea></p>




    <!-- test override section -->
<p><strong>Test override</strong></p>
<p></p>
<!-- if we set this value and then check it in the function we can override the values on the fly, not in the options table -->
<p><select name="cm_testOverride_field" title="Setting this value to <em>test</em> will change your code to the test settings but won't over-write the values you add above.">
        <option value="test" <?php if ($cm_testOverride_val == 'test') {echo "selected"; }?>>Test  </option>
        <option value="live" <?php if ($cm_testOverride_val == 'live') {echo "selected"; }?>>Live  </option>
   </select>
</p>
<p class="submit">
<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" title="Save your changes and update preview code" />
</p>



<!-- test output section -->
<p>Need help? Compare the code below to what's on your other sites, or copy and paste it into a Coremetrics support ticket to check you've got it right.</p>
<p class="previewCode">
    <?php if($cm_testOverride_val == 'test') {
            // set the user ID value with 6 as first digit
            // is the user ID a long string with semicolon delimeters?

            if (ereg(';', $cm_userID_val)) {
            // it's a long string, so let's split it into an array first by semicolon:
                $cm_userID_array = split(';',$cm_userID_val);

                //now pop it all back together into a single string:
                $finalIDarray = '';
                foreach ($cm_userID_array as $userID) {
                    $finalIDarray .= substr_replace($userID, '6', 0, 1) . ';';
                }

                $cm_userID_val = rtrim($finalIDarray, ';');

            }
            else
            // it's a single value, so replace the first digit with 6
            {
                $cm_userID_val = substr_replace($cm_userID_val, '6', 0, 1);
            }



            $cm_clientManaged_val = 'false';
            $cm_dataCollection_val = 'testdata.coremetrics.com';
         }
    ?>
    &lt;script type="text/javascript" src="<?php echo $cm_eluminateLoc_val;?>"&gt;&lt;/script&gt;<br />
    <?php if (strlen($cm_customScript_val) >= 1) { ?>
    &lt;script type="text/javascript" src="<?php echo $cm_customScript_val;?>"&gt;&lt;/script&gt;<br />
    <?php } ?>
    <br />
    &lt;script type="text/javascript"&gt;<br />
    cmSetClientID("<?php echo $cm_userID_val; ?>",<?php echo $cm_clientManaged_val; ?>,"<?php echo $cm_dataCollection_val; ?>","<?php echo $cm_cookieDomain_val; ?>");<br />
    &lt;/script&gt;<br />
</p>
</form>

            <!-- override footer test -->
<p><strong>Test for wp_footer();</strong></p>
<p>If you've ever reset a "wp_footer(); not found" message and want to test again, click the button below. If you don't know what this means, ignore it! Your theme is great.</p>
<p>You may want to do this if you add a new theme and suddenly Coremetrics isn't working. It will look for the vital wp_footer(); function for you, but might give you false results... it depends on your server settings. It can be a useful first check if you're having issues, and you can always dismiss the error.</p>
<form id="cm-reinstate-updates" action="" method="post" style="">
    <input type="hidden" name="dismiss_error" value="false" />
    <input type="submit" value="Reset footer test" />
</form>


</div>