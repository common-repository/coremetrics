=== Coremetrics Tracking ===
Contributors: maltpress
Tags: tracking, statistics
Requires at least: 2.7
Tested up to: 3.4.2
Stable tag: trunk

Statistics tracking plugin for Coremetrics. Requires a Coremetrics account.

== Description ==

This plugin provides users of Coremetrics tracking to create the appropriate page and event tags for their blogs.

As well as setting core data such as user ID, you can assign common Wordpress events with event points or create your own custom page view tags using common Wordpress page and post attributes.

For full documentation, contact your Coremetrics account manager.


== Installation ==

1. Upload the 'coremetrics' directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Complete the core settings in the Coremetrics menu

== Frequently Asked Questions ==

= I don't use Coremetrics but want to track my site. What should I do? =

Coremetrics is a powerful enterprise-level statistics package. You can find out more at http://www.coremetrics.com/.

= How can I find my user ID/script locations/other setting? =

The core settings page offers a script preview. Compare this to your other sites using Coremetrics (as it's likely that you'll be using it across more than just your blog) to make sure the settings are correct. Alternatively, submit a Coremetrics support ticket and paste your preview code into the ticket to check it's OK.

= I've put all my settings in but for some reason my user ID always starts with a 6 =

You've probably set your code to test - in the core settings menu, select "Live" in the test override drop-down.

= Not all the attributes I want to see are showing. Why not? =

Certain attributes won't be available on all page or post types. In particular, listing pages (archives, the home page, and so on) won't show many attributes - because Wordpress would, if these attributes were included, take the value from the last added post. Check if the attribute is showing "Listing page or search". If that's the case, check it on a different page type (post or page) and you should see the attribute appear. Alternatively, you may see "This attribute not available in this WP version". If this is the case, you should consider upgrading to the most recent version of Wordpress.

= How do I add my own events? =

You need to set an event ID (which has spaces removed, and is used only to call the event with the short code or PHP), an event name (which shows up in the tracking) and points for the initial 2 steps created. Click "add event" and you'll see it listed. Click the "edit" box next to the event you wish to edit and click the "edit/delete" button to make changes to it. You'll then be able to edit the points for each stage as well as add new stages if you want more than 2. Finally, you'll also get your short code and PHP code for each of the event stages.

To use the short code, simply copy it and paste it into a post.

= Only the first stage of my custom event is being tracked. What's wrong? =

You need to add the short code (or PHP function) for each step of the event. Some plugins with forms will allow you to redirect to a custom "thank you" page... you should add the second stage tracking to this page.

= It works in the admin system, but not on the live site =

Check you've got wp_footer() in your footer.php file (you should always have this!). There's a function to check that it's there, but double check.

= There's a big red box telling me I don't have wp_footer(); in my theme, but I do! =

Sorry! It's entirely possible that there's something about your server setup which means you get false negatives. You can dismiss this message if you're happy that everything is working as expected - you can always test again by going to the Coremetrics settings page and clicking the button at the bottom of the page. You'll be told if wp_footer(); is found or not.

= It's not working on Multisite. Why not? =

This version of the plugin is not compatible with Multisite. A new version is coming soon.

== Changelog ==

= 1.2.2 =
* Updated Javascript tags to remove language attribute - now validates in HTML5

= 1.2.1 =
* You can now dismiss the wp_footer() warning - certain themes and server setups might give false positives.

= 1.2 =
* Plugin now warns if wp_footer() is missing (which will stop the plugin working)
* General code tidy-up, now runs clean with WP_DEBUG on, deprecated bits removed

= 1.1 =
* Fixed bug to allow multiple user IDs in test mode (semi-colon separated)
* Added custom events

= 1.0 =
* Plugin launched

== Upgrade Notice ==

= 1.2.1 =
Now dismiss false negative wp_footer(); checks

= 1.1 =
Adds extra functionality and fixed important bug on multiple user IDs

