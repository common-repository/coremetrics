
<div class="wrap">
    <?php  if (!current_user_can('manage_options'))
        {
          wp_die( __('You do not have sufficient permissions to access this page.') );
        }
    ?>
    <div id="icon-coremetrics" class="icon32"></div>
    <h2>User defined attributes</h2>
   

</div>


<?php

/*
 * custom attributes should be in the format <user defined prefix> <blog data> <user defined suffix>
 * e.g. "Adam's test suffix - $post->title - test suffix"
 * Where $post->title is picked from a dropdown of all possible post or page attributes
 * Needs caveat that not every page/post type will present every type of attribute!
 *
 *
 */

  // form submit check
    $hidden_field_name = 'coremetrics_attributes_submit_hidden';
// let's set up a test multi-dimensional array for the attributes

$cm_attributesTactical = get_option('cm_tactical_attributes');
$cm_attributesStrategic = get_option('cm_strategic_attributes');
$cm_attribute_override_val = get_option('cm_attribute_override');



// now create the option list for the drop-down...

function attributeValueSelect($cm_attributeSelect, $cm_attributeName) {
    // $cm_infoTypes array:
// key = short name
// value = description
// This needs to be properly documented!
$cm_infoTypes = array (
    "" => "Please select a page attribute",
    "title" => "Post or page title",
    "time" => "Time post or page added",
    "date" => "Date post or page added",
    "permalink" => "URL of post or page",
    "category" => "Categories of post",
    "author" => "Author of post",
    "ID" => "ID of current post",
    "SearchQuery" => "Value of search query (search pages only)",
    "bloginfoName" => "Blog name",
    "bloginfoChar" => "Blog character set",
    "bloginfoVers" => "Wordpress version number",
    "bloginfoHTML" => "Blog HTML type used",
    "isSticky" => "Post is sticky",
    "isPage" => "Page is displayed",
    "getcustomkeys" => "Custom field keys (comma separated) - WP 3.0 required",
    "authorNum" => "Numerical ID of post/page author",
    "postStatus" => "Status of post (published, draft etc)",
    "commentStatus" => "Status of comments (open/closed)",
    "modifiedDate" => "Date and time last modified",
    "commentCount" => "Number of comments",
    "menuOrder" => "Menu hierarchy value",
    "postType" => "Post or page"
);
// in phase II, we should add custom fields using get_post_meta()
    echo '<select name="cm_infoType_field_' . $cm_attributeName . '" title="Select info type">';
    foreach ($cm_infoTypes as $cm_shortName => $cm_longDesc) {
        echo '<option value="' . $cm_shortName . '"';
        if ($cm_attributeSelect == $cm_shortName) { echo ' selected="selected" '; };
        echo '>' . $cm_longDesc . '</option>';
    }
    echo '</select>';

}


// here we create the form action

// See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
        // Update individual options if set
        
        
    if (isset($_POST['cm_attribute_override_field'])) {
        $cm_attribute_override_val = $_POST['cm_attribute_override_field'];
    }




        foreach ($_POST as $postKey => $postValue) {
            switch ($postKey) {
                case 'tacticalAttribute1prefix' : $cm_attributesTactical['tacticalAttribute1']['prefix'] = $postValue;
                    break;
                case 'cm_infoType_field_tacticalAttribute1' : $cm_attributesTactical['tacticalAttribute1']['value'] = $postValue;
                    break;
                case 'tacticalAttribute1suffix' : $cm_attributesTactical['tacticalAttribute1']['suffix'] = $postValue;
                    break;
                
                case 'tacticalAttribute2prefix' : $cm_attributesTactical['tacticalAttribute2']['prefix'] = $postValue;
                    break;
                case 'cm_infoType_field_tacticalAttribute2' : $cm_attributesTactical['tacticalAttribute2']['value'] = $postValue;
                    break;
                case 'tacticalAttribute2suffix' : $cm_attributesTactical['tacticalAttribute2']['suffix'] = $postValue;
                    break;
                
                case 'tacticalAttribute3prefix' : $cm_attributesTactical['tacticalAttribute3']['prefix'] = $postValue;
                    break;
                case 'cm_infoType_field_tacticalAttribute3' : $cm_attributesTactical['tacticalAttribute3']['value'] = $postValue;
                    break;
                case 'tacticalAttribute3suffix' : $cm_attributesTactical['tacticalAttribute3']['suffix'] = $postValue;
                    break;
                
                case 'tacticalAttribute4prefix' : $cm_attributesTactical['tacticalAttribute4']['prefix'] = $postValue;
                    break;
                case 'cm_infoType_field_tacticalAttribute4' : $cm_attributesTactical['tacticalAttribute4']['value'] = $postValue;
                    break;
                case 'tacticalAttribute4suffix' : $cm_attributesTactical['tacticalAttribute4']['suffix'] = $postValue;
                    break;
                
                case 'tacticalAttribute5prefix' : $cm_attributesTactical['tacticalAttribute5']['prefix'] = $postValue;
                    break;
                case 'cm_infoType_field_tacticalAttribute5' : $cm_attributesTactical['tacticalAttribute5']['value'] = $postValue;
                    break;
                case 'tacticalAttribute5suffix' : $cm_attributesTactical['tacticalAttribute5']['suffix'] = $postValue;
                    break;
                
                
                case 'strategicAttribute1prefix' : $cm_attributesStrategic['strategicAttribute1']['prefix'] = $postValue;
                    break;
                case 'cm_infoType_field_strategicAttribute1' : $cm_attributesStrategic['strategicAttribute1']['value'] = $postValue;
                    break;
                case 'strategicAttribute1suffix' : $cm_attributesStrategic['strategicAttribute1']['suffix'] = $postValue;
                    break;
                
                case 'strategicAttribute2prefix' : $cm_attributesStrategic['strategicAttribute2']['prefix'] = $postValue;
                    break;
                case 'cm_infoType_field_strategicAttribute2' : $cm_attributesStrategic['strategicAttribute2']['value'] = $postValue;
                    break;
                case 'strategicAttribute2suffix' : $cm_attributesStrategic['strategicAttribute2']['suffix'] = $postValue;
                    break;
                
                case 'strategicAttribute3prefix' : $cm_attributesStrategic['strategicAttribute3']['prefix'] = $postValue;
                    break;
                case 'cm_infoType_field_strategicAttribute3' : $cm_attributesStrategic['strategicAttribute3']['value'] = $postValue;
                    break;
                case 'strategicAttribute3suffix' : $cm_attributesStrategic['strategicAttribute3']['suffix'] = $postValue;
                    break;
                
                case 'strategicAttribute4prefix' : $cm_attributesStrategic['strategicAttribute4']['prefix'] = $postValue;
                    break;
                case 'cm_infoType_field_strategicAttribute4' : $cm_attributesStrategic['strategicAttribute4']['value'] = $postValue;
                    break;
                case 'strategicAttribute4suffix' : $cm_attributesStrategic['strategicAttribute4']['suffix'] = $postValue;
                    break;
                
                case 'strategicAttribute5prefix' : $cm_attributesStrategic['strategicAttribute5']['prefix'] = $postValue;
                    break;
                case 'cm_infoType_field_strategicAttribute5' : $cm_attributesStrategic['strategicAttribute5']['value'] = $postValue;
                    break;
                case 'strategicAttribute5suffix' : $cm_attributesStrategic['strategicAttribute5']['suffix'] = $postValue;
                    break;
                
                case 'strategicAttribute6prefix' : $cm_attributesStrategic['strategicAttribute6']['prefix'] = $postValue;
                    break;
                case 'cm_infoType_field_strategicAttribute6' : $cm_attributesStrategic['strategicAttribute6']['value'] = $postValue;
                    break;
                case 'strategicAttribute6suffix' : $cm_attributesStrategic['strategicAttribute6']['suffix'] = $postValue;
                    break;
                
                case 'strategicAttribute7prefix' : $cm_attributesStrategic['strategicAttribute7']['prefix'] = $postValue;
                    break;
                case 'cm_infoType_field_strategicAttribute7' : $cm_attributesStrategic['strategicAttribute7']['value'] = $postValue;
                    break;
                case 'strategicAttribute7suffix' : $cm_attributesStrategic['strategicAttribute7']['suffix'] = $postValue;
                    break;
                
                case 'strategicAttribute8prefix' : $cm_attributesStrategic['strategicAttribute8']['prefix'] = $postValue;
                    break;
                case 'cm_infoType_field_strategicAttribute8' : $cm_attributesStrategic['strategicAttribute8']['value'] = $postValue;
                    break;
                case 'strategicAttribute8suffix' : $cm_attributesStrategic['strategicAttribute8']['suffix'] = $postValue;
                    break;
                
                case 'strategicAttribute9prefix' : $cm_attributesStrategic['strategicAttribute9']['prefix'] = $postValue;
                    break;
                case 'cm_infoType_field_strategicAttribute9' : $cm_attributesStrategic['strategicAttribute9']['value'] = $postValue;
                    break;
                case 'strategicAttribute9suffix' : $cm_attributesStrategic['strategicAttribute9']['suffix'] = $postValue;
                    break;
                
                case 'strategicAttribute10prefix' : $cm_attributesStrategic['strategicAttribute10']['prefix'] = $postValue;
                    break;
                case 'cm_infoType_field_strategicAttribute10' : $cm_attributesStrategic['strategicAttribute10']['value'] = $postValue;
                    break;
                case 'strategicAttribute10suffix' : $cm_attributesStrategic['strategicAttribute10']['suffix'] = $postValue;
                    break;
                
            }
        }
        


    update_option('cm_tactical_attributes',$cm_attributesTactical);
    update_option('cm_strategic_attributes',$cm_attributesStrategic);
    update_option('cm_attribute_override',$cm_attribute_override_val);
    
    // Put an settings updated message on the screen
    ?>
    <div class="updated"><p><strong>Settings saved</strong></p></div>
    <?php
    }


?>

<form name="cm_attributeSettings" method="post" action="" id="cm_mainSettings_ID">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
<p>This page allows you to create your own attributes for page view tags. If set to "default", the values you store below will still be saved, but the default attributes will be sent
 to your tracking. Default values are <pre>"[Language]-_-[country]-_-[tag/date identifier]-PageType-_-[post tags]-_-[post or page author]-_-[month]-_-[year]"</pre></p>
<p><strong>Please note:</strong> not all attributes will be available for all page types! Some will be post or page only.</p>

<p><strong>Attribute override? </strong>
<select name='cm_attribute_override_field' title="Attribute override">
    <option value='default' <?php if ($cm_attribute_override_val == 'default') {echo 'selected="selected"'; } ?>>Use default attributes</option>
    <option value='user-defined' <?php if ($cm_attribute_override_val == 'user-defined') {echo 'selected="selected"'; } ?>>User defined attributes</option>
</select></p>

<p><strong>Tactical attributes</strong></p>
<?php
// the five tactical attributes

foreach ($cm_attributesTactical as $attributeID => $secondaryArrays) {
    echo '<p><strong>' . $attributeID . '</strong> ';
    foreach ($secondaryArrays as $key => $value) {
         switch ($key) {
             case 'prefix' : echo 'Prefix: <input type="text" size="10" name="' . $attributeID . $key . '" value="' . $value . '" title="' . $key . '" /> | ';
             break;
             case 'value' : echo attributeValueSelect($value, $attributeID) . ' | ';
             break;
             case 'suffix' : echo 'Suffix: <input type="text" size="10" name="' . $attributeID . $key . '" value="' . $value . '" title="' . $key . '" /></p>';
             break;
         }
    }
}
?>
<p><strong>Strategic attributes</strong></p>
<?php
// ten strategic attributes

foreach ($cm_attributesStrategic as $attributeID => $secondaryArrays) {
    echo '<p><strong>' . $attributeID . '</strong> ';
    foreach ($secondaryArrays as $key => $value) {
         switch ($key) {
             case 'prefix' : echo 'Prefix: <input type="text" size="10" name="' . $attributeID . $key . '" value="' . $value . '" title="' . $key . '" /> | ';
             break;
             case 'value' : echo attributeValueSelect($value, $attributeID) . ' | ';
             break;
             case 'suffix' : echo 'Suffix: <input type="text" size="10" name="' . $attributeID . $key . '" value="' . $value . '" title="' . $key . '" /></p>';
             break;
         }
    }
}
?>
<input type="submit" value="submit" />
</form>