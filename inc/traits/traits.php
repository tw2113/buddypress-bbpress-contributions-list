<?php

trait widget_inputs {

	public function form_input_text( array $args = array() ) {
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
}
