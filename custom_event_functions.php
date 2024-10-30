<?php

/*
 * cm_retrieve_Events function
 * Lists custom events and allows editing/deletion
 *
 */

function cm_retrieve_Events () {
    // this function prints a table of the events configured and the form to edit them
    // define globals:
    global $cm_event_tablename;
    global $hidden_field_name;
    global $wpdb;
    // let's get what's in the database already - we'll get only DISTINCT values:
    $cm_currentEvents = $wpdb->get_results("SELECT functionID, eventIdentifier, id FROM $cm_event_tablename GROUP BY functionID ORDER BY id", ARRAY_A);
    // first the form: ?>
    <form name="cm_listtoedit" method="post" action="" id="cm_mainSettings_ID">
    <input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
    <p>This page allows you to create your own event tags. Event tags take the following form:</p>
    <p><pre>cmCreateConversionEventTag("[blogID]-[event identifier]","[event order]","[blogID] Events","[event points]","[post title]");</pre></p>
    <p>When creating your own event tags you can define the event identifier (i.e. "contact form") and the event points (a numerical value). Other values are taken from your master values or automatically generated.
    You will be given both a short code to use on blog posts/pages and a PHP function to place in plugin files as required. Edit an event to see the appropriate short codes for each event stage.</p>
    <p><strong>Please note:</strong> if you place a function in your plugin files you will need to put it back in when you update your plugins!</p>
    <?php
    // now create the table layout - this is tabular data, so a table is appropriate markup!
        echo "<table class=\"customEventTable\">";
        echo "<tr><th>Event identifier (unique ID)</th><th>Event name</th><th colspan=\"2\">Actions</th></tr>";
        foreach ($cm_currentEvents as $cm_nondupe_events) {
            echo "<tr>";
                $output = "<td>" . $cm_nondupe_events[functionID] . "</td>";
                $output .= "<td>" . $cm_nondupe_events[eventIdentifier] . "</td>";
                $output .= "<td class=\"cm_delete\">Delete: <input type=\"checkbox\" id=\"deleteCheck\" name=\"delete\" value=\"" . $cm_nondupe_events[functionID] . "\"/>";
                $output .= "<td class=\"cm_edit\" >Edit: <input type=\"checkbox\" id=\"editCheck\" name=\"edit\" value=\"" . $cm_nondupe_events[functionID] . "\"/>";
                echo $output;
            echo "</tr>";
        }
    echo "</table><br />";
    echo "<input type=\"submit\" value=\"Edit/delete\" />";
    echo "</form>";
}

/*
 * cm_add_Events function
 * add new custom events
 * creates event and two event points
 *
 */

function cm_add_Events() {
    // set up the globals
    global $cm_event_tablename;
    global $hidden_field_name;
    ?>
    <h3>Add custom event</h3>
    <form name="cm_addEvent" method="post" action="" id="cm_addEvent_ID">
    <input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
    <input type="hidden" name="is_adding" value="Y">
    <p>Add events here. Spaces will be removed from the unique event identifier: </p>
    <label for="cm_eventIdentifier_add">Event identifier (unique):</label><input type="text" id="eventIdentifier_id" name="cm_eventIdentifier_add" /><br />
    <label for="cm_eventName_add">Event name:</label><input type="text" id="eventName_id" name="cm_eventname_add" /><br />
    <label for="cm_eventOne_points">Points for event 1:</label><input type="text" id="eventOnePoints_id" name="cm_eventOnePoints_add" size="3" /><br />
    <label for="cm_eventTwo_points">Points for event 2:</label><input type="text" id="eventTwoPoints_id" name="cm_eventTwoPoints_add" size="3" />
    <br /><input type="submit" value="Add event" />
    </form>
    <?php
}

/*
 * cm_edit_Events function
 * Allows editing of individual events -
 * Add/remove steps in an event
 * Edit event identifier
  */

function cm_edit_Events ($event_to_edit) {
    // this function takes an event ID and then presents an editing form
     // what we need to do here is create a table of each event stage
    global $cm_event_tablename;
    global $hidden_field_name;
    global $cm_editingEvent;
    global $wpdb;
     // let's get all the results for the approriate event:
    $cm_editingEvent = $wpdb->get_results("SELECT * FROM $cm_event_tablename WHERE functionID='$event_to_edit' ORDER BY id", ARRAY_A);
    // start with the JS to deal with adding a new row then put the form... ?>
    <script type="text/javascript">
    //<![CDATA[
        var count = <?php echo count($cm_editingEvent); ?>;
        jQuery(function(){
                jQuery('span#add_field').click(function(){
                        count += 1;
                        var cell1 = '<input type="hidden" value="" name="id[]" /><td width="10%"><strong>Event order:</strong> ' + count + ' </td><input type="hidden" name="eventOrder[]" value="' + count + '" />';
                        var cell2 = '<td><strong>Event points:</strong> <input type="text" size="3" name="eventPoint[]" /></td>';
                        var cell3 = '<td><strong>Short code: </strong>[cmcustom event="<?php echo $cm_editingEvent[0][functionID]; ?>" order="' + count + '"]</td>';
                        var cell4 = '<td><strong>PHP code: </strong>cmCustomEventManual("<?php echo $cm_editingEvent[0][functionID]; ?>","' + count + '");</td>';
                        jQuery('table#singleEvent').append('<tr>' + cell1 + cell2 + cell3 + cell4 + '</tr>') ;
                });
                jQuery('span#remove_field').click(function() {
                   // if (count >= <?php echo count($cm_editingEvent); ?>+1) {
                   var deletedRow = jQuery('table#singleEvent tr:last input:hidden[name=id[]]').val();
                   jQuery('table#singleEvent tr:last').remove();
                   jQuery('form#cm_editEventTags_ID').append('<input type="hidden" name="differenceArray[]" value="' + deletedRow + '" />');
                   count-=1;
                   return false;
                 //   }
                });
        });
    //]]>
    </script>
    <form name="cm_singleedit" method="post" action="" id="cm_editEventTags_ID">
    <input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
    <input type="hidden" name="is_editing" value="Y">
    <p>Edit events here. You can set event points for each stage in the event and add/remove event stages. Each stage has a different short code.</p>
    <p>Most events have two stages, but more can be added easily using the form below.</p>
    <p>You can edit the event identifier but not the unique event ID. If you wish to do this, delete your event and start again.</p>

    <p><strong>Please note:</strong> if you place a function in your plugin files you will need to put it back in when you update your plugins!</p>

    <?php
    // now create the table layout - this is tabular data, so a table is appropriate markup!
        ?>
        <table class="customEventTable" id="singleEvent">
        <tr><th colspan="3"><label>Event name:&nbsp;</label><input type="text" name="eventIdentifier" value="<?php echo $cm_editingEvent[0][eventIdentifier]; ?>" /> </th></tr>
        <?php foreach ($cm_editingEvent as $cm_single_event) {
            echo "<tr>";
                $output = '<input type="hidden" value="' . $cm_single_event[id] . '" name="id[]" />';
                $output .= "<td width=\"10%\"><strong>Event order:</strong> " . $cm_single_event[eventOrder] . "</td><input type=\"hidden\" name=\"eventOrder[]\" value=\"" . $cm_single_event[eventOrder] . "\" />";
                $output .= "<td><strong>Event points:</strong> <input type=\"text\" size=\"3\" name=\"eventPoint[]\" value=\"" . $cm_single_event[eventPoints]. "\" /></td>";
                $output .= "<td><strong>Short code: </strong>[cmcustom event=\"" . $cm_single_event[functionID] . "\" order=\"" . $cm_single_event[eventOrder] . "\"]</td>";
                $output .= "<td><strong>PHP code: </strong>cmCustomEventManual('" . $cm_single_event[functionID] . "','" . $cm_single_event[eventOrder] . "');</td>";

                echo $output;
            echo "</tr>";
        } ?>
        </table><br />
        <span id="add_field">Add row</span> <span id="remove_field">Remove row</span>

    <input type="hidden" value="<?php echo $event_to_edit ?>" name="edit">
    <br /><input type="submit" value="Submit changes" />
    </form>
    <form name="cm_resetedit" method="post" action="" id="cm_mainSettings_ID">
    <input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
    <input type="hidden" name="reset" value="reset" />
    <input type="submit" value="Back to custom event listing" />
    <?php
} ?>