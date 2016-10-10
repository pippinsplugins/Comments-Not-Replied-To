=== Comments Not Replied To ===
Contributors: mordauk, norcross, tommcfarlin
Tags: comments
Requires at least: 3.5
Tested up to: 4.7
Stable tag: 1.1.1

Easily see which comments have not received a reply from each post's author.

== Description ==

"Comments Not Replied To" is a plugin that makes it easy to manage the comments on your blog, especially for those of you who have a significant amount of comments.

Simply put, "Comments Not Replied To" introduces a new area in the administrative dashboard that allows you to see what comments to which you - as the site author - have not yet replied.

== Installation ==

= In The WordPress Dashboard =

1. Navigate to the 'Add New' plugin dashboard
2. Select `Comments-Not-Replied-To.zip` from your computer
3. Upload
4. Activate the plugin in the WordPress Plugin Dashboard

= Using FTP =

1. Extract `Comments-Not-Replied-To.zip` to your computer
2. Upload the `Comments-Not-Replied-To` directory to your wp-content/plugins directory
3. Navigate to the WordPress Plugin Dashboard
4. Activate the plugin from this page

== Frequently Asked Questions ==

= Does this look at all my existing comments? =

At this point, no. That would cause issues on larger sites with upwards of 10,000 comments. We plan on introducing a method to handle this in the future.

== Screenshots ==

1. The updated 'Comments Dashboard' showing the new columns with the 'Missing Comments' and their status

== Changelog ==

= 1.1.1 =

* Fix: PHP notice if $current_screen is not an object

= 1.1.0 =
* Adding support for the GitHub updater plugin
* Moving the screenshot files to the `assets` directory for better practices
* Updating the constant plugin version

= 1.0.1 =
* Removing a duplicate installation instruction in the README
* Adding a plugin header image
* Adding a constant definition for the plugin version

= 1.0 =
* Initial release

