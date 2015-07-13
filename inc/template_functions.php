<?php

/**
 * Fetch our BuddyPress user contributions.
 *
 * @param string $user  User to get contributions for.
 * @param int    $count Contribution amount to display.
 *
 * @return string HTML markup list of BuddyPress user contributions.
 */
function bpbbcl_buddypress_get_contributions( $user = '', $count = 5 ) {

	$project = 'BuddyPress';

	return bpbbcl_get_contributions( $user, $count, $project );
}

/**
 * Echo our BuddyPress user contributions.
 *
 * @param string $user  User to get contributions for.
 * @param int    $count Contribution amount to display.
 *
 * @return string HTML markup list of BuddyPress user contributions.
 */
function bpbbcl_buddypress_display_contributions( $user = '', $count = 5 ) {
	echo bpbbcl_buddypress_get_contributions( $user, $count );
}

/**
 * Fetch our bbPress user contributions.
 *
 * @param string $user  User to get contributions for.
 * @param int    $count Contribution amount to display.
 *
 * @return string HTML markup list of bbPress user contributions.
 */
function bpbbcl_bbpress_get_contributions( $user = '', $count = 5 ) {

	$project = 'bbPress';

	return bpbbcl_get_contributions( $user, $count, $project );
}

/**
 * Fetch our bbPress user contributions.
 *
 * @param string $user  User to get contributions for.
 * @param int    $count Contribution amount to display.
 *
 * @return string HTML markup list of bbPress user contributions.
 */
function bpbbcl_bbpress_display_contributions( $user = '', $count = 5 ) {
	echo bpbbcl_bbpress_get_contributions( $user, $count );
}

/**
 * Fetch our contributions for the provided project.
 *
 * @param string $user    User to get contributions for.
 * @param int    $count   Contribution amount to display.
 * @param string $project Project to get contributions for.
 *
 * @return bool|string
 */
function bpbbcl_get_contributions( $user = '', $count = 5, $project = 'BuddyPress' ) {

	$base_object = new tw2113\BPBBPCL\ContribBase\BuddyPressbbPress_Contributions_List_Base( array(
		'trac_project' => $project
	) );

	if ( empty( $user ) ) {
		$base_object->no_user();
		return false;
	}

	$bpcontribs = $base_object->get_contribs_transient( $user, $project );
	$list_type = $base_object->list_type();

	$limiter = 1;
	$list = '';
	$output = '';

	foreach ( $bpcontribs as $contrib ) {
		if ( $limiter <= $count ) {
			$list .= $base_object->list_item( $contrib );
		} else {
			break;
		}
		$limiter++;
	}

	if ( empty( $bpcontribs ) ) {
		$output .= '<p>';
		$output .= sprintf(
			__( 'No contributions yet. Find some tickets at %s', 'buddypress-bbpress-contributions-list' ),
			sprintf(
				__( '<a href="%s">%s</a>' ),
				$base_object->trac_base_url,
				$project . ' Trac'
			)
		);
		$output .= '</p>';
	} else {
		$output .= sprintf(
			'<%s>%s</%s>',
			$list_type,
			$list,
			$list_type
		);
	}

	return $output;
}
