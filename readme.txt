=== BuddyForms – Advanced Custom Fields Integration Add-on ===
Contributors: svenl77, konradS, themekraft, buddyforms, gfirem, camiloluna
Tags: forms, frontend, custom fields, submission, buddypress, profiles
Requires at least: 4.0
Tested up to: 6.8.2
Stable tag: 1.3.17
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Add BuddyForms frontend forms that map to field groups created with the Advanced Custom Fields plugin. Independent integration; ACF is not included.

== Description ==

This add-on lets you render ACF field groups inside BuddyForms so users can create and edit content from the frontend—while keeping ACF-powered meta in sync.

**Highlights**
- Works with ACF Free and PRO (ACF must be installed separately).
- Map ACF field groups to BuddyForms forms for frontend create/edit.
- Supports common ACF field types (text, textarea, select, checkbox, date, color, maps, etc.).
- BuddyForms Moderation support for review/approval workflows.
- BuddyPress integration: sync selected ACF fields with xProfile.

> Note: This plugin integrates with Advanced Custom Fields; it does not bundle any ACF code or assets.

== Installation ==

1. Install and activate **BuddyForms**.
2. Install and activate **Advanced Custom Fields** (Free or PRO).
3. Upload and activate this add-on.
4. Go to **BuddyForms → Forms**, create or edit a form, and map your ACF field groups or fields.

== Frequently Asked Questions ==

= Does this plugin include ACF? =
No. ACF needs to be installed and active.

= Do I need ACF PRO? =
No. The free version works; PRO field types are supported where possible.

= Does this modify my ACF field groups? =
No. Field groups are read to render frontend fields; they aren't altered.

== Screenshots ==
1. Mapping an ACF field group to a BuddyForms form
2. Frontend submission form
3. Submitted entry view

== Changelog ==
= 1.3.17 - 24 Sep 2025 =
* Updated plugin display name for compliance.
* Cleaned up readme file.
* Added trademark disclaimer and clarified independent integration.
* Replaced third-party brand assets references with neutral wording.
* Updated tk_scripts depencency version.
* Added dependency config to allow plugins.
* Tested up to WordPress 6.8.2

= 1.3.16 - 06 Feb 2024 =
* Fixed issue with JS dependencies of ACF pro fields.
* Updated Freemius SDK
* Tested up to WordPress 6.4.3

= 1.3.15 - 19 Nov 2023 =
* Updated Freemius SDK
* Tested up to WordPress 6.4.1

= 1.3.14 - 18 May 2023 =
* Tested up to WordPress 6.2.1

= 1.3.13 - 06 Nov 2022 =
* Updated download link in TGM class.
* Tested up to WordPress 6.1

= 1.3.12 - 08 Sep 2022 =
* Fixed issue with multiple ACF fields used in the same form.
* Tested up to WordPress 6.0.2

= 1.3.11 - 22 Aug 2022 =
* Fixed issue with fields value update.

= 1.3.10 - 17 Aug 2022 =
* Fixed issue with group field elements.

= 1.3.9 - 16 Aug 2022 =
* Fixed security issue.
* Improved Freemius integration.
* Tested up to WordPress 6.0.1

= 1.3.8 - 17 May 2022 =
* Updated readme.txt

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
