<?php

namespace tw2113\BPBBPCL\BuddyPressWidget;

/**
 * BuddyPress Contributions list
 *
 * @since 1.0
 */
class BuddyPress_Contributions_List extends \WP_Widget {

	use \widget_inputs;

	public function __construct() {
		$widget_ops = array( 'classname' => '', 'description' => __( 'Widget to display your BuddyPress contributions', 'buddypress-bbpress-contributions-list' ) );
		parent::__construct( 'BuddyPress_Contributions_List', __( 'BuddyPress Contributions List', 'buddypress-bbpress-contributions-list' ), $widget_ops );
	}

	/**
	 * Form method
	 * @param array $instance Widget instance
	 *
	 * @return string|void
	 */
	public function form( $instance ) {
		$defaults = array(
            'bpbbcl_title'      => __( 'My BuddyPress contributions', 'buddypress-bbpress-contributions-list' ),
            'bpbbcl_bp_user'    => '',
            'bpbbcl_bp_count'   => '5',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );

		$title = strip_tags( $instance[ 'bpbbcl_title' ] );
		$user = strip_tags( $instance[ 'bpbbcl_bp_user' ] );
		$count = strip_tags( $instance[ 'bpbbcl_bp_count' ] );

		$this->form_input_text( array(
			'label_text' => __( 'Title', 'buddypress-bbpress-contributions-list' ),
			'name' => $this->get_field_name( 'bpbbcl_title' ),
			'id' => $this->get_field_id( 'bpbbcl_title' ),
			'value' => $title
		) );

		$this->form_input_text( array(
			'label_text' => __( 'Username', 'buddypress-bbpress-contributions-list' ),
			'name' => $this->get_field_name( 'bpbbcl_bp_user' ),
			'id' => $this->get_field_id( 'bpbbcl_bp_user' ),
			'value' => $user
		) );

		$this->form_input_text( array(
			'label_text' => __( 'Count', 'buddypress-bbpress-contributions-list' ),
			'name' => $this->get_field_name( 'bpbbcl_bp_count' ),
			'id' => $this->get_field_id( 'bpbbcl_bp_count' ),
			'value' => $count
		) );

	}

	/**
	 * Update method
	 * @param array $new_instance New data
	 * @param array $old_instance Original data
	 *
	 * @return array Updated data
	 */
	public function update( $new_instance, $old_instance ) {
        $instance                      = $old_instance;
        $instance[ 'bpbbcl_title' ]    = trim( strip_tags( $new_instance[ 'bpbbcl_title' ] ) );
		$instance[ 'bpbbcl_bp_user' ]  = trim( strip_tags( $new_instance[ 'bpbbcl_bp_user' ] ) );
		$instance[ 'bpbbcl_bp_count' ] = absint( trim( $new_instance[ 'bpbbcl_bp_count' ] ) );

		return $instance;
	}

	/**
	 * Widget method
	 * @param array $args Widget args
	 * @param array $instance Widget instance
	 */
	public function widget( $args, $instance ) {
		$title = trim( strip_tags( $instance[ 'bpbbcl_title' ] ) );
		$user = trim( strip_tags( $instance[ 'bpbbcl_bp_user' ] ) );
		$count = trim( strip_tags( $instance[ 'bpbbcl_bp_count' ] ) );

		echo $args[ 'before_widget' ];
		if ( $title ) {
			echo $args[ 'before_title' ] . $title . $args[ 'after_title' ];
		}

		bpbbcl_buddypress_display_contributions( $user, $count );

		echo $args[ 'after_widget' ];
	}
}
