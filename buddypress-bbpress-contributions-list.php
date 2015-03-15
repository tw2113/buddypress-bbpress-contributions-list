<?php
/*
Plugin Name: BuddyPress/bbPress Contributions List
Plugin URI: http://michaelbox.net/
Description: Displays contributions to BuddyPress and bbPress core.
Version: 1.0
Author: Michael Beckwith
Author URI: http://michaelbox.net
License: WTFPL
Text Domain: buddypress-bbpress-contributions-list
*/

/*
		DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
			Version 2, December 2004

 Copyright (C) 2004 Sam Hocevar <sam@hocevar.net>

 Everyone is permitted to copy and distribute verbatim or modified
 copies of this license document, and changing it is allowed as long
 as the name is changed.

			DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
   TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION

  0. You just DO WHAT THE FUCK YOU WANT TO.

*/

namespace tw2113\BPBBPCL;

/**
 * @since 1.0
 */
function register_widgets() {
	require_once 'widgets/bbpress.php';
	require_once 'widgets/buddypress.php';

	register_widget( 'tw2113\BPBBPCL\BuddyPressWidget\BuddyPress_Contributions_List' );
	register_widget( 'tw2113\BPBBPCL\bbPressWidget\bbPress_Contributions_List' );
}
add_action( 'widgets_init', 'tw2113\BPBBPCL\register_widgets' );

/**
 * @since 1.0
 */
function requires() {
	require_once 'inc/shortcode.php';
	require_once 'inc/template_functions.php';
	require_once 'inc/bpbb_widget_base.php';
}
add_action( 'plugins_loaded', 'tw2113\BPBBPCL\requires' );

/**
 * @since 1.0
 */
function widgets_init() {
  load_plugin_textdomain( 'buddypress-bbpress-contributions-list', false, dirname( plugin_basename( __FILE__ ) . '/languages/' ) );
}
add_action( 'plugins_loaded', 'tw2113\BPBBPCL\widgets_init' );
