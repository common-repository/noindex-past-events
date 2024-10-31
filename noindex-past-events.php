<?php
/*
Plugin Name: noindex Past Events for The Events Calendar
Plugin URI:  http://room34.com
Description: Automatically add a "noindex" meta tag to The Events Calendar's detail pages for past events, to prevent them from appearing in search engines.
Version:     1.2.4
Author:      Room 34 Creative Services, LLC
Author URI:  http://room34.com
Text Domain: r34npe
License:     GPL2
*/

/*  Copyright 2016 Room 34 Creative Services, LLC (email: info@room34.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as 
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Don't load directly
if (!defined('ABSPATH')) { exit; }


// Main function for adding noindex tag when appropriate
function r34npe_noindex_past_events() {
	global $post;
	if (!is_admin() && is_singular() && @$post->post_type == 'tribe_events') {
		if (!function_exists('tribe_get_end_date')) { return false; }
		if (strtotime(tribe_get_end_date($post->ID, true, 'r')) < time()) {
			echo "\n<!-- noindex Past Events -->\n<meta name=\"robots\" content=\"noindex, follow\" />\n\n";
		}
	}
}
add_action('wp_head', 'r34npe_noindex_past_events');


// Add admin page
function r34npe_admin() {
	// Missing plugin notice
	if (!is_plugin_active('the-events-calendar/the-events-calendar.php')) {
		add_action('admin_notices', 'r34npe_missing_plugin');
	}
	// Admin page
	else {
		// Placeholder for future admin page
	}
}
add_action('admin_menu', 'r34npe_admin');


// Admin notice for missing plugin
function r34npe_missing_plugin() {
	?>
	<div class="notice notice-error"><p><b>noindex Past Events</b> requires <b>The Events Calendar</b> plugin, but it is missing. Please <a href="plugins.php?s=The+Events+Calendar">activate</a> or <a href="plugin-install.php?s=The+Events+Calendar&tab=search&type=term">install</a> The Events Calendar, or <a href="plugins.php?s=noindex+Past+Events">deactivate</a> noindex Past Events.</p></div> 
	<?php
}


// Exclude past events from WP search
function r34npe_search_exclude($query) {
	// Verify Events Calendar plugin is active
	include_once(ABSPATH . 'wp-admin/includes/plugin.php');
	if (!is_plugin_active('the-events-calendar/the-events-calendar.php')) {
		return $query;
	}
	global $wpdb;
	if (!is_admin() && $query->is_search()) {
		$now = function_exists('wp_date') ? wp_date('Y-m-d H:i:s') : date('Y-m-d H:i:s');
		// Get full list of past event IDs to exclude (least invasive change to query)
		$sql = "SELECT `post_id` FROM `" . $wpdb->postmeta . "` WHERE `meta_key` = '_EventEndDate' AND `meta_value` < '" . $now . "'";
		$exclude_posts = $wpdb->get_results($sql, OBJECT_K);
		if (!empty($exclude_posts)) {
			$post__not_in = (array)$query->get('post__not_in') + array_keys($exclude_posts);
			$query->set('post__not_in', $post__not_in);
		}
	}
	return $query;
}
add_action('pre_get_posts', 'r34npe_search_exclude'); // Don't set priority!
