<div class="wrap">
    <?php  if (!current_user_can('manage_options'))
        {
          wp_die( __('You do not have sufficient permissions to access this page.') );
        }
    ?>
    <div id="icon-coremetrics" class="icon32"></div>
    <h2>Custom events</h2>
    <script>
jQuery(document).ready(function()
{
    jQuery("form").submit(function()
    {
        if (!isCheckedById("selector"))
        {
            alert ("You can only edit or delete one item at a time");
            return false;
        }
        else if (!isCheckedById("event"))
        {
            alert ("You can only edit or delete one item at a time");
            return false;
        }
        else
        {
            return true; //submit the form
        }
    });

    function isCheckedById(id)
    {
        var checked = jQuery("input[@id="+id+"]:checked").length;
        if (checked >= 2)
        {
            return false;
        }
        else
        {
            return true;
        }
    }
});
    </script>



</div>


<?php

/*
 * Added in 1.1
 * For this we need to create a database table in WPDB (see core functions file for installation action); then we populate it with each function
 * Each event can have any number of stages; three should be created by default (two will cover most events, the third is to make sure!)
 * Remember to include a check for duplicate event names
 */

 // For testing - turn on WPDB show errors
global $wpdb;
global $cm_event_tablename;
global $cm_editID;
$cm_editID = $_POST['edit'];
$cm_event_tablename = $wpdb->prefix . "cmCustomEvents";
global $hidden_field_name;
    $hidden_field_name = 'coremetrics_customevent_submit_hidden';
    
include_once("custom_event_functions.php");

    // form submit check

    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
        // Update individual options if set
        // delete row from DB
       global $cm_event_tablename;
       global $wpdb;
       $wpdb->show_errors();
       $to_delete = $_POST['delete'];
       $wpdb->query("DELETE FROM $cm_event_tablename WHERE functionID = '$to_delete'");
       // for editing an event
       // get values from $_POST
       $idArray = $_POST['id'];
       if (isset($_POST['is_editing']) && $_POST['is_editing'] == 'Y') {
           foreach ($idArray as $idkey => $idvalue) {
               $id = $idvalue;
               $eventPoints = $_POST['eventPoint'][$idkey];
               $eventOrder = $_POST['eventOrder'][$idkey];
               $eventIdentifier = $_POST['eventIdentifier'];
               $wpdb->query("REPLACE INTO $cm_event_tablename (id, functionID, eventIdentifier, eventOrder, eventPoints)
                             VALUES
                             ('$id', '$cm_editID', '$eventIdentifier', '$eventOrder', '$eventPoints')");
               $arrayDifferences = $_POST['differenceArray'];
               if (isset ($_POST['differenceArray'])) {
                       foreach ($arrayDifferences as $rowsDeleted) {
                            $wpdb->query("DELETE FROM $cm_event_tablename WHERE id = '$rowsDeleted'");
                   }
               }
           }
           ?><div class="updated"><p><strong>Settings saved</strong></p></div><?php

       }

        // for adding an event

        if (isset($_POST['is_adding']) && $_POST['is_adding'] == 'Y') {
            $addedEventIdentifier = str_replace(' ', '_', $_POST['cm_eventIdentifier_add']);
            $addedEventName = $_POST['cm_eventname_add'];
            $addedEventPointOne = $_POST['cm_eventOnePoints_add'];
            $addedEventPointTwo = $_POST['cm_eventTwoPoints_add'];

            $wpdb->insert($cm_event_tablename,array('functionID' => $addedEventIdentifier, 'eventIdentifier' => $addedEventName, 'eventOrder' => '1', 'eventPoints' => $addedEventPointOne ));
            $wpdb->insert($cm_event_tablename,array('functionID' => $addedEventIdentifier, 'eventIdentifier' => $addedEventName, 'eventOrder' => '2', 'eventPoints' => $addedEventPointTwo ));
            ?><div class="updated"><p><strong>Settings saved</strong></p></div><?php
        }
        // Put an settings updated message on the screen
        if (!isset($_POST['reset'])) {
        ?>
        
        <?php
        }
    }

// make this conditional. If id to edit not set, then:
if ($cm_editID == '' || $resetFunc == 'reset') {
    // call the current event table function
    cm_retrieve_Events();
    $resetFunc = '';
    cm_add_Events();

}
// if id to edit is set, then:
else {
    cm_edit_Events($cm_editID);
}

// You're very persistent, Tron
?>