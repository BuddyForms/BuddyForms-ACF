=== BuddyForms ACF ===
Contributors: svenl77, konradS, themekraft, buddyforms
Tags: acf, advanced custom fields, buddypress, user, members, profiles, custom post types, taxonomy, frontend posting, frontend editing, moderation, revision
Requires at least: 3.9
Tested up to: 4.7
Stable tag: 1.0.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Integrates the popular Plugin "Advanced Custom Fields" (ACF) with BuddyForms. Use all ACF Fields in your form like native BuddyForms form elements.

== Description ==

With the BuddyForms ACF Extension you can use Advanced Custom Fields with BuddyForms.
<br>

<h4>ACF Free and Pro</h4>
This plugins supports the Free and Pro version of ACF out of the box.
The plugin will detect if Free or Pro version is installed, and then loads the correct ACF field groups.
<br>

<h4>ACF for the backend and BuddyForms for the front end.</h4>

ACF is the preferred choice for creating post metaboxes for the edit screen in the WordPress backend (wp-admin).

It comes packed with tons of great form elements and features.

<b>Use all of the ACF features in the front end and combine the best of both worlds. </b>

BuddyForms ACF works with all ACF Extensions and BuddyForms Extensions.
<br>

<h4>Use ACF to create a BuddyPress Component </h4>
Create a BuddyPress Members Component or extend your groups with ACF fields!
<br>

<h4>Use ACF for all your form fields</h4>
With ACF enabled you build your form fields once and use everywhere. Use ACF for all form elements needed and just integrate the ACF field groups or single fields in your BuddyForms forms. You can use any ACF Field or Custom ACF Fields with BuddyForms and combine them with BuddyForms Fields and Extensions.
<br>

<h4>Moderation for your ACF Forms</h4>
With BuddyForms Moderation you get real post submission moderation to your hands.
Let your users create and edit posts without creating the ugly 404 "WordPress is struggling" if a published post is set back to draft. ;)
<br>

<H4>Use everywhere</h4>
With BuddyForms and ACF together you build your field sets once and use them everywhere.
In the backend edit screen or in the front end via shortcodes or integrated with BuddyPress or any other BuddyForms supported plugin.

See the list of BuddyForms Extension:
<a href="https://buddyforms.com/extensions-for-wordpress-forms/">BuddyForms Extensions</a>

See a list of ACF Extensions:
<a href="https://wordpress.org/plugins/search.php?type=term&q=Advanced+Custom+Fields">https://wordpress.org/plugins/search.php?type=term&q=Advanced+Custom+Fields</a>
<a href="https://wordpress.org/plugins/search.php?type=term&q=ACF">https://wordpress.org/plugins/search.php?type=term&q=ACF</a>

Combine the power and get the most out of your post forms in the front and backend, seamlessly.
<br>

<a href="http://buddyforms.com" target="_new">Get BuddyForms Here</a>


== Documentation & Support ==

<h4>Extensive Documentation and Support</h4>

All code is neat, clean and well documented (inline as well as in the documentation).

The BuddyForms Documentation comes with many how-to’s!

If you still get stuck somewhere, our support gets you back on the right track.
You can find all help buttons in your BuddyForms Settings Panel in your WP Dashboard!

== Installation ==

You can download and install the plugin using the built-in WordPress plugin installer.

If you download BuddyForms manually, make sure it is uploaded to "/wp-content/plugins/".

Activate the plugin in the "Plugins" admin panel using the "Activate" link. If you're using WordPress Multisite, you can also activate BuddyForms network wide.

== Frequently Asked Questions ==

You need the BuddyForms plugin installed for the plugin to work.
<a href="http://buddyforms.com" target="_blank">Get BuddyForms now!</a>

== Screenshots ==

1. ** ACF Field Group ** -  Use ACF Groups in Forms

2. ** ACF Single Field ** - Use Single fields in Groups

== Changelog ==

= 1.0.5 =
fixed a tgm issue if acf pro was installed it still asked for acf free

= 1.0.4 =
Fixed an issue with the dependencies management. If pro was activated it still ask for the free version. Fixed now with a new default BUDDYFORMS_PRO_VERSION in the core to check if the pro is active.

= 1.0.3 =
Add dependencies management with tgm
Rename buddyforms_add_form_element_to_select to buddyforms_add_form_element_select_option

= 1.0.2 =
Support for the form builder select box added
Make sure we have all in place if people switch from acf free to pro.
There was also an issue with the field in pro. Should work now with free and pro. Maybe it makes sense to split the plugin into free and pro to have the code separated
Fixed a incompatible issue with the pro version of acf groups
Only show form type related form elements
Fixed a issue with the conditional logic
Fixed a issue with acf field groups not getting saved.
Rename acf to acf-group if type is acf group

= 1.0.1 =
* There have been some wired css issues. Fixed now by  wp_dequeue_style colors-fresh.

= 1.0 =
* final 1.0 version
