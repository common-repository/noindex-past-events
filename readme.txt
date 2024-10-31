=== noindex Past Events for The Events Calendar ===
Contributors: room34
Donate link: http://room34.com/donation
Tags: The Events Calendar, past events, noindex, search engines
Requires at least: 4.0
Tested up to: 6.4
Stable tag: 1.2.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Automatically add a "noindex" meta tag to The Events Calendar's detail pages for past events, to prevent them from appearing in search engines.

== Description ==

This plugin is an add-on for Modern Tribe's The Events Calendar plugin. It adds a "noindex" meta tag to the individual detail pages for events after their end date has passed, to prevent them from appearing in search engines like Google or Bing.

Note that this only takes effect the next time a search engine indexes your site, so past events may still appear in search results for a few days.

== Installation ==

== Frequently Asked Questions ==

== Screenshots ==

== Changelog ==

= 1.2.4 - 2021.12.16 =

* Modified plugin title to make clear that it is specifically for use with Modern Tribe's The Events Calendar plugin.
* Updated "Tested up to" to 5.8.2.

= 1.2.3 - 2021.09.20 =

* Switched check for past events to using `wp_date()` (if it's available) instead of `date()`.
* Updated logo/icon assets.
* Updated "Tested up to" to 5.8.1.
* Reformatted changelog.

= 1.2.2 =

* Removed priority from add_action('pre\_get\_posts', 'r34npe\_search\_exclude'); because it wasn't working.

= 1.2.1 =

* Switched time() to current\_time() to account for WP time zone handling.

= 1.2.0 =

* Added logic to exclude past events from WP search results.

= 1.1.0.1 =

* Updated "Tested up to" to 4.7.

= 1.1.0 =

* Added admin message if The Events Calendar plugin is not activated.

= 1.0.0 =

* Initial release in WordPress Plugin Directory.
