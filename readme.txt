=== eHive Object Details ===
Contributors: vernonsystems 
Donate link:http://ehive.com/what_is_ehive
Tags: ehive, collection, museum, archive, history
Requires at least: 3.3.1
Tested up to: 4.2.2
Stable tag: 2.1.7
License: GPL2+
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A plugin to display a detail page for an eHive Object Record.

== Description ==

This plugin is part of a suite of plugins created by Vernon Systems Ltd., which give you the power to embed eHive functionality into your WordPress website.

This plugin allows you to display eHive Object details pages. This means that you can display all of the public metadata and image fields for any public eHive record.

Before you install this plugin you will need to install the eHive Access plugin. 

<span style="text-decoration: underline;">**Get more from the eHive plugin suite**</span>

To enhance the page you embed this plugin on you can also install the eHive Search plugin to allow your users to search for and view other eHive Object Records.

Other plugins in the suite include:

* eHive Account Details - A plugin for displaying eHive account information.
* eHive Object Comments - Enables users to add comments to Object Records from your site.
* eHive Objects Image Grid - Displays a grid of images from eHive filtered by certain criteria.
* eHive Objects Tag Cloud - Displays a tag cloud from eHive.
* eHive Search - Allows you to search eHive.
* eHive Objects Gallery widget - Provides a gallery of Object Records that can be placed in your sites widget areas. 
* eHive Objects Tag Cloud widget - Allows you to display a tag cloud in a widget area on your site.
* eHive Object Tags widget - A widget that displays tags for an Object Record.
* eHive Search widget - A widget plugin that provides access to eHive Search from a widget.

<div>
  <br />
</div>


== Installation ==
**Dependencies:**

* eHive Access plugin

This plugin requires the eHive Access plugin to be installed first. Please ensure you have installed and configured it correctly before installing this plugin.

There are three ways to install a plugin:

<span style="text-decoration: underline;">**Method 1**</span>


1.  Navigate to the plugins page by clicking the link in the WordPress admin menu.
2.  Click the "Add New" link
3.  Type the name of the plugin you want to install (i.e. "eHive Access plugin") into the search box
4.  Click the "Search plugins" button
5.  Locate the plugin you want to install from the search results
6.  Click the "Install Now" link and click "OK" on the popup confirmation window
7.  Click the "Activate plugin" link when the plugin installation has completed


<span style="text-decoration: underline;">**Method 2**</span>


1.  Download the plugin's .ZIP file.
2.  Navigate to the plugins page by clicking the link in the WordPress admin menu.
3.  Click the "Add New" link
4.  Click the "Upload" link
5.  Click the "Choose File" button and locate the .ZIP file you downloaded in step 1
6.  Click the "Install Now" button
7.  Click the "Activate plugin" link when the plugin installation has completed

<span style="text-decoration: underline;">**Method 3**</span>


1. Download the plugin's .ZIP file.
2. Unzip the contents into your WordPress sites plugin directory (<em>/wordpress/wp-contents/plugins</em>)
3. Navigate to the plugins page by clicking the link in the WordPress admin menu.
4. Click the "Activate plugin" link below the plugin's name

== Changelog ==
= 2.1.7 =
* Upgraded prettyPhoto jQuery lightbox to version 3.1.6 to fix a security exploit.

= 2.1.6 =
* Fixed broken links to static images when WordPress is installed in a sub folder.
* Help menu in admin panel now displays when the eHive Search plugin in not installed.

= 2.1.5 =
* Fixed rewrite rule so plugin will work on a page that has a parent page.

= 2.1.4 =
* Removed the broken "Replace page title with object name" option.
* Wrapped eHive Object field values with a span and class ehive-field-value to allow for easy styling.
 
= 2.1.3 =
* Fixed markup bug, removed stray closing div that was breaking some Themes sidebar layouts.
* Added option to enable or disable linking to an eHive account from the public profile name.
* Added option to enable or disable linking to a larger image when displaying images with prettyPhoto disabled.
* Added uninstall script to remove options from the database when the plugin is deleted. 
* Added version control for plugin options. Defaulting of new options without changing existing options is now possible. 

= 2.1.2 =
* Upgraded prettyPhoto to version 3.1.5
* Included admin option to disable prettyPhoto
* Included admin option to display all images or the first image for an eHive object record.

= 2.1.1 =
* First stable release of the eHive Access plugin. 

== Upgrade Notice ==
= 2.1.7 =
* Recommended update.
* Upgraded prettyPhoto jQuery lightbox to version 3.1.6 to fix a security exploit.

= 2.1.6 =
* Fixed broken links to static images when WordPress is installed in a sub folder.
* Help menu in admin panel now displays when the eHive Search plugin in not installed.

= 2.1.5 =
* Fixed rewrite rule so plugin will work on a page that has a parent page.

= 2.1.4 =
* Removed the broken "Replace page title with object name" option.
* Wrapped eHive Object field values with a span and class ehive-field-value to allow for easy styling.

= 2.1.3 =
* Fixed markup bug, removed stray closing div that was breaking some Themes sidebar layouts.
* Added option to enable or disable linking to an eHive account from the public profile name.
* Added option to enable or disable linking to a larger image when displaying images with prettyPhoto disabled.
* Added uninstall script to remove options from the database when the plugin is deleted. 
* Added version control for plugin options. Defaulting of new options without changing existing options is now possible. 


= 2.1.2 =
* Upgraded prettyPhoto to version 3.1.5
* Included admin option to disable prettyPhoto
* Included admin option to display all images or the first image for an eHive object record. 

= 2.1.1 =
This is the first stable release of the eHive Access plugin.

== Screenshots ==

1. eHive Object Details, object record 2415 - Kit(s)ch(ick)en. 
2. eHive Object Details shortcode help.
3. eHive Object Details Settings.


== Frequently Asked Questions ==

Q. What is eHive?

A. eHive is an online collections management software package. See more at <a href="http://ehive.com/what_is_ehive" target="_blank" title="what is ehive?">What is eHive?</a>

<div>
	<br />
</div>

Q. What do these plugins do?

A. The eHive plugin suite gives you the ability to provide eHive functionality to your site's visitors. This means that you can search and display eHive records, leave comments that are visible also in ehive and add and remove tags to records where the record owner has given permission to do so. You can filter the search results by account or community if you want to display only records from a particular source. We also provide plugins to do other nice things like display grids of interesting, popular or recent images added to eHive; display galleries of other objects by the same account as a record you are viewing etc.

<div>
	<br />
</div>

Q. How do I get an API Key?

A. To get an API Key you will first need an active eHive account. If you don't have one you can <a href="http://ehive.com/signup/" title="sign up for an ehive account">sign up</a> for an account for free. Once you have an account you can navigate to the "Edit My Profile > Api Keys" page and create a new Key.


