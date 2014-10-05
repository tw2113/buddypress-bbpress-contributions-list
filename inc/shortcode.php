<?php
/**
 * Shortcode callback for BuddyPress contributions
 *
 * @param array $atts Attributes provided for the BuddyPress shortcode
 *
 * @since 1.0
 *
 * @return string HTML list of contributions
 */
function bpbbcl_buddypress_list( $atts = array() ) {

	$theatts = shortcode_atts( array(
		'user' => '',
		'count' => 5,
	), $atts );

	return bpbbcl_buddypress_get_contributions( $theatts[ 'user' ], $theatts[ 'count' ] );
}
add_shortcode( 'buddypress_contributions_list', 'bpbbcl_buddypress_list' );

/**
 * Shortcode callback for bbPress contributions
 *
 * @param array $atts Attributes provided for the bbPress shortcode
 *
 * @since 1.0
 *
 * @return string HTML list of contributions
 */
function bpbbcl_bbpress_list( $atts = array() ) {

	$theatts = shortcode_atts( array(
		'user' => '',
		'count' => 5,
	), $atts );

	return bpbbcl_bbpress_get_contributions( $theatts[ 'user' ], $theatts[ 'count' ] );
}
add_shortcode( 'bbpress_contributions_list', 'bpbbcl_bbpress_list' );
