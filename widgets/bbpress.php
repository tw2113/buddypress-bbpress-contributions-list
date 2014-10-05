<?php
/**
 * bbPress Contributions list
 *
 * @since 1.0
 */
class bbPress_Contributions_List extends WP_Widget {

	public function __construct() {
		$widget_ops = array( 'classname' => '', 'description' => __( 'Widget to display your bbPress contributions', 'buddypress-bbpress-contributions-list' ) );
		parent::__construct( 'bbPress_Contributions_List', __( 'bbPress Contributions List', 'buddypress-bbpress-contributions-list' ), $widget_ops );
	}

	/**
	 * Form method
	 * @param array $instance Widget instance
	 *
	 * @return string|void
	 */
	public function form( $instance ) {
		$defaults = array(
            'bpbbcl_title'      => __( 'My bbPress contributions', 'buddypress-bbpress-contributions-list' ),
            'bpbbcl_bp_user'    => '',
            'bpbbcl_bp_count'   => '5',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );

		$title = strip_tags( $instance[ 'bpbbcl_title' ] );
		$user = strip_tags( $instance[ 'bpbbcl_bp_user' ] );
		$count = strip_tags( $instance[ 'bpbbcl_bp_count' ] );

		$this->form_input_text( array(
			'label_text' => __( 'Title', 'buddypress-bbpress-contributions-list' ),
			'name' => 'bpbbcl_title',
			'id' => 'bpbbcl_title',
			'value' => $title
		) );

		$this->form_input_text( array(
			'label_text' => __( 'Username', 'buddypress-bbpress-contributions-list' ),
			'name' => 'bpbbcl_bp_user',
			'id' => 'bpbbcl_bp_user',
			'value' => $user
		) );

		$this->form_input_text( array(
			'label_text' => __( 'Count', 'buddypress-bbpress-contributions-list' ),
			'name' => 'bpbbcl_bp_count',
			'id' => 'bpbbcl_bp_count',
			'value' => $count
		) );

	}

	/**
	 * Render a text input for the widget form
	 * @param array $args Array of values to use with input
	 *
	 * @since 1.0
	 */
	function form_input_text( $args = array() ) {
		$label_text = esc_attr( $args['label_text'] );
		$name = esc_attr( $this->get_field_name( $args['name'] ) );
		$id = esc_attr( $this->get_field_id( $args['id'] ) );
		$value = esc_attr( $args['value'] );

		printf(
			'<p><label for="%s">%s</label><input type="text" class="widefat" name="%s" id="%s" value="%s" /></p>',
			$id,
			$label_text,
			$name,
			$id,
			$value
		);
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

		bpbbcl_bbpress_display_contributions( $user, $count );

		echo $args[ 'after_widget' ];
	}
}
