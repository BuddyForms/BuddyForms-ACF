=== BuddyForms ACF ===
Contributors: svenl77, konradS, themekraft, buddyforms, gfirem
Tags: acf, advanced custom fields, buddypress, user, members, profiles, custom post types, taxonomy, frontend posting, frontend editing, moderation, revision
Requires at least: 4.0
Tested up to: 5.9
Stable tag: 1.3.7
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

<h4>Sync ACF with BuddyPress</h4>
Now you are able to Sync your ACF field under BuddyForms with BuddyPress xProfile.
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
= 1.3.7 - 04 Mar 2022 =
* Fixed issue with ACF .js file path.
* Tested up to WordPress 5.9

= 1.3.6 - 27 Sep 2021 =
* Tested up with WordPress 5.8

= 1.3.5 - 8 March 2021 =
* Tested up with WordPress 5.7

= 1.3.4 - 6 April 2020 =
* Fixed the label for single and groups ACF fields. Thanks to Patty O'Hara

= 1.3.3 - 23 March 2020 =
* Fixed the validation because it was not letting to submit the form after one error was catch.
* Improved the compatibility with BuddyForms labels and required signal.

= 1.3.2 - 28 Feb 2020 =
* Fixed the code correction alert. Thanks to `Alessandro Borges`.

= 1.3.1 - 18 Feb 2020 =
* Fixed the function to load the values in a ACF Field in a Registration Form.

= 1.3.0 - 11 Feb 2020 =
* Improved the form submission with the version of BuddyForms.
* Fixed the functionality to store the ACF data into the user meta.
* Added compatibility with BuddyPress and now is possible to sync from ACF with BuddyPress xProfile.

= 1.2.11 - 28 Jan 2020 =
* Added support for Registration and Contact Forms.

= 1.2.10 - 28 Jan 2020 =
* Fixed the single ACF Field element wrapper.

= 1.2.9 - 28 Jan 2020 =
* Improved the assets load to avoid cache issue when something changes.

= 1.2.8 - 18 Jan 2020 =
* Added a style coming from ACF wrapper.

= 1.2.7 - 18 Jan 2020 =
* Fixed the validation issue when the form not have any invalid fields.

= 1.2.6 - 18 Jan 2020 =
* Fixed submit form issue.

= 1.2.5 - 18 Jan 2020 =
* Fixed the validation issue.
* Improved compatibility with last version of BuddyForms.

= 1.2.4 - 11 Oct 2019 =
* Fixed the acf field validation making buddyforms ignore fields from ACF, them ACF field run their own validation.

= 1.2.3 - 7 Sept 2019 =
* Fixed the required signal to look like BF.
* Fixed the field validation.
* Integrated the field validation with BF.

= 1.2.2 -  Mar. 02 2019 =
* Freemius SDK Update

= 1.2.1 =
* Fixed an issue with conditional logic
* Freemius update

= 1.2 =
* Freemius update
* Fixed an issue reported and fixed by Patty When ACF goes to render the field it expects the value just to be an array of ids
* Changed the acf instructions form smal to span with class help-inline. props go to Patty for letting me know!
* Added Text Domain: buddyforms

= 1.1 =
* Added conditional logic. Works only with ACF Groups
* Acf field groups should work now nice in free and pro of acf
* Make the JavaScript work with ACF single if multiple single are in the same form.
* Conditional logic only works with field groups. Clean up all conditional code from single field.
* Added the label to the acf fields.
* Make all work even if you switch from free to pro or pro to free of ACF or if you have both activated.
* Added support for google maps, date, color picker, taxonomies and all other js based form elements.
* all form elements of ACF free and pro are now supported.
* Several smaller fixes
* Code clean up

= 1.0.5 =
* Freemius integration

= 1.0.5 =
* fixed a tgm issue if acf was installed it still asked for acf free

= 1.0.4 =
* Fixed an issue with the dependencies management. If pro was activated it still ask for the free version. Fixed now with a new default BUDDYFORMS_PRO_VERSION in the core to check if the pro is active.

= 1.0.3 =
* Add dependencies management with tgm
* Rename buddyforms_add_form_element_to_select to buddyforms_add_form_element_select_option

= 1.0.2 =
* Support for the form builder select box added
* Make sure we have all in place if people switch from acf free to pro.
* There was also an issue with the field in pro. Should work now with free and pro. Maybe it makes sense to split the plugin into free and pro to have the code separated
* Fixed a incompatible issue with the pro version of acf groups
* Only show form type related form elements
* Fixed a issue with the conditional logic
* Fixed a issue with acf field groups not getting saved.
* Rename acf to acf-group if type is acf group

= 1.0.1 =
* There have been some wired css issues. Fixed now by  wp_dequeue_style colors-fresh.

= 1.0 =
* final 1.0 version