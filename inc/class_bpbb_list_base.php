<?php

namespace tw2113\BPBBPCL\ContribBase;

/**
 * Base class of contribution methods.
 *
 * @since 1.0
 */
class BuddyPressbbPress_Contributions_List_Base {

	/**
	 * @var string Trac URL to fetch data from.
	 */
	public $trac_url = '';

	/**
	 * @var string Trac base URL.
	 */
	public $trac_base_url = '';

	function __construct( array $args = array() ) {
		$args = wp_parse_args( $args,
			array(
				'trac_project' => 'buddypress'
			)
		);

		$this->trac_url = 'https://' . strtolower( $args['trac_project'] ) . '.trac.wordpress.org/search';
		$this->trac_base_url = 'https://' . strtolower( $args['trac_project'] ) . '.trac.wordpress.org';
	}

	/**
	 * Get a count of changesets a user is attributed to.
	 *
	 * @param string $username User to check the specified trac for.
	 *
	 * @since 1.0
	 *
	 * @return int|array Count of changesets available or empty array on empty user.
	 */
	public function get_changeset_count( $username = '' ) {
		if ( null == $username ) {
			return array();
		}

		$results_url = add_query_arg( array(
			'q'           => 'props+' . $username,
			'noquickjump' => '1',
			'changeset'   => 'on'
		), $this->trac_url );

		$overall = wp_remote_get( $results_url, array( 'sslverify' => false ) );
		$status = wp_remote_retrieve_response_code( $overall );

		$count = 0;
		if ( '200' == $status ) {
			$results = wp_remote_retrieve_body( $overall );

			$pattern = '/<meta name="totalResults" content="(\d*)" \/>/';

			preg_match( $pattern, $results, $matches );

			$count = intval( $matches[1] );
		}
		return $count;
	}

	/**
	 * Get a list of changesets a user is attributed to.
	 *
	 * @param string $username User to check the specified trac for.
	 *
	 * @since 1.0
	 *
	 * @return array Array of changesets available for user.
	 */
	public function get_changesets( $username = '' ) {

		if ( null == $username ) {
			return array();
		}

		if ( !isset( $this->trac_url ) ) {
			return array();
		}

		$results_url = add_query_arg( array(
			'q' => 'props+' . $username,
			'noquickjump' => '1',
			'changeset' => 'on'
		), $this->trac_url );

		$overall = wp_remote_get( $results_url, array( 'sslverify' => false ) );
		$status = wp_remote_retrieve_response_code( $overall );

		$formatted = array();

		if ( '200' == $status ) {
			$results = wp_remote_retrieve_body( $overall );

			$pattern = '/<dt><a href="(.*?)" class="searchable">\[(.*?)\]: ((?s).*?)<\/a><\/dt>\n\s*(<dd ass="searchable">.*\n?.*(?:ixes|ee) #(.*?)\n?<\/dd>)?/';

			preg_match_all( $pattern, $results, $matches, PREG_SET_ORDER );

			foreach ( $matches as $match ) {
				array_shift( $match );
				$new_match = array(
					'link' => $this->trac_base_url . $match[0],
					'changeset' => intval($match[1]),
					'description' => $match[2],
					'ticket' => isset( $match[3] ) ? intval($match[4]) : '',
				);
				array_push( $formatted, $new_match );
			}

		}

		return $formatted;
	}

	/**
	 * Display message to WordPress Admins if there is no user specified.
	 *
	 * @since 1.0
	 */
	public function no_user() {
		return __( 'Please provide a username.', 'buddypress-bbpress-contributions-list' );
	}

	/**
	 * Get user count transient.
	 *
	 * @param string $user    User to set the transient for.
	 * @param string $project Project to set the transient for.
	 *
	 * @since 1.0
	 *
	 * @return string|mixed Saved transient data or false.
	 */
	public function get_count_transient( $user = '', $project = '' ) {
		if ( false === ( $count = get_transient( $user . '_' , $project . 'bp_count' ) ) ) {
			$count = $this->get_changeset_count( $user );
			set_transient( $user . '_' , $project . 'bp_count', $count, HOUR_IN_SECONDS );
		}

		return $count;
	}

	/**
	 * Get user contributions transient.
	 *
	 * @param string $user    User to set the transient for.
	 * @param string $project Project to set the transient for.
	 *
	 * @since 1.0
	 *
	 * @return array|mixed Saved transient data or false.
	 */
	public function get_contribs_transient( $user = '', $project = '' ) {
		if ( false === ( $contribs = get_transient( $user . '_' . $project . '_contribs' ) ) ) {
			$contribs = $this->get_changesets( $user );
			set_transient( $user . '_' . $project . '_contribs', $contribs, HOUR_IN_SECONDS );
		}

		return $contribs;
	}

	/**
	 * Get list type to display.
	 *
	 * @since 1.0
	 *
	 * @return string List type to use.
	 */
	public function list_type() {
		$list_type = apply_filters( 'bpbbcl_list_type', 'ol' );

		if ( ! in_array( $list_type, array( 'ol', 'ul' ) ) ) {
			$list_type = 'ol';
		}

		return $list_type;
	}

	/**
	 * HTML List markup for an individual contribution.
	 *
	 * @param array $item Individual contribution.
	 *
	 * @since 1.0
	 *
	 * @return string HTML list item markup.
	 */
	public function list_item( $item = array() ) {
		return sprintf(
			'<li><a href="%s">[%s]: %s</a></li>',
			$item[ 'link' ],
			sprintf( __( 'Changeset #%s', 'buddypress-bbpress-contributions-list' ), $item[ 'changeset' ] ),
			$item[ 'description' ]
		);
	}
}
