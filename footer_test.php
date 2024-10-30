<?php
/*


	Copyright (c) 2010 Matt Martz (http://sivel.net/)
	Test Head Footer is released under the GNU General Public License (GPL)

http://www.gnu.org/licenses/gpl-2.0.txt

*/

// Lets not do anything until init
add_action( 'init', 'test_head_footer_init' );
function test_head_footer_init() {
	// Hook in at admin_init to perform the check for wp_head and wp_footer
	add_action( 'admin_init', 'check_head_footer' );

	// If test-head query var exists hook into wp_head
	if ( isset( $_GET['test-head'] ) )
		add_action( 'wp_head', 'test_head', 99999 ); // Some obscene priority, make sure we run last

	// If test-footer query var exists hook into wp_footer
	if ( isset( $_GET['test-footer'] ) )
		add_action( 'wp_footer', 'test_footer', 99999 ); // Some obscene priority, make sure we run last
}

// Echo a string that we can search for later into the head of the document
// This should end up appearing directly before </head>
function test_head() {
	echo '<!--wp_head-->';
}

// Echo a string that we can search for later into the footer of the document
// This should end up appearing directly before </body>
function test_footer() {
	echo '<!--wp_footer-->';
}


// Add dismiss form handling to admin pages IF not dismissed

function cm_dismiss_footererror () {
    $cm_error_dismissed = '';
    if (isset($_POST['dismiss_error']) && $_POST['dismiss_error'] != '') {
            $cm_error_dismissed = $_POST['dismiss_error'];
            update_option('cm_dismiss_option', $cm_error_dismissed);
        }
}
if (get_option('cm_dismiss_option') != 'true') {
    add_action('admin_init', 'cm_dismiss_footererror');
}

// Check for the existence of the strings where wp_head and wp_footer should have been called from
function check_head_footer() {
	// Build the url to call, NOTE: uses home_url and thus requires WordPress 3.0
	$url = add_query_arg( array( 'test-head' => '', 'test-footer' => '' ), home_url() );
	// Perform the HTTP GET ignoring SSL errors
	$response = wp_remote_get( $url, array( 'sslverify' => false ) );
	// Grab the response code and make sure the request was sucessful
	$code = (int) wp_remote_retrieve_response_code( $response );
	if ( $code == 200 ) {
		global $head_footer_errors;
		$head_footer_errors = array();

		// Strip all tabs, line feeds, carriage returns and spaces
		$html = preg_replace( '/[\t\r\n\s]/', '', wp_remote_retrieve_body( $response ) );

		// Check to see if we found the existence of wp_footer
		if ( ! strstr( $html, '<!--wp_footer-->' ) )
			$head_footer_errors['nofooter'] = 'might be missing the call to <?php wp_footer(); ?> which should appear directly before </body> - your Coremetrics plugin might not work. There are lots of reasons you might see this. If your Coremetrics code is appearing on your site, you can dismiss this message. If not, check your footer.php file for the <?php wp_footer(); ?> function.';



		// If we found errors with the existence of wp_head or wp_footer hook into admin_notices to complain about it
		if ( ! empty( $head_footer_errors ) )
			add_action ( 'admin_notices', 'test_head_footer_notices' );
	}
}

// Output the notices
function test_head_footer_notices() {
	global $head_footer_errors;

        // let's test to see if this has been dismissed
        if (get_option('cm_dismiss_option') != 'true' && $head_footer_errors) {
            // If we made it here it is because there were errors, lets loop through and state them all
            echo '<div class="error"><p><strong>Your active theme:</strong></p><ul>';
            foreach ( $head_footer_errors as $error )
                    echo '<li>' . esc_html( $error ) . '</li>';
                    ?>
<form id="cm-dismiss-updates" action="" method="post" style="padding: 10px;">
    <input type="hidden" name="dismiss_error" value="true" />
    <input type="submit" value="Ignore message" />
</form>

                    <?php
            echo '</ul></div>';
        } elseif (!$head_footer_errors && isset($_POST['dismiss_error']) && $_POST['dismiss_error'] == 'false') {
            echo '<div class="updated"><p><strong>Your active theme contains wp_footer();</strong></p>';
            echo '</div>';
        }
}
?>