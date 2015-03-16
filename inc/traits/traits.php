<?php

trait widget_inputs {

	public function form_input_text( array $args = array() ) {

		if ( !empty ( $args ) ) {
			$label_text = esc_attr( $args['label_text'] );
			$name       = esc_attr( $args['name'] );
			$id         = esc_attr( $args['id'] );
			$value      = esc_attr( $args['value'] );

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

	public function form_input_textarea( array $args = array() ) {
		if ( !empty( $args ) ) {
			$rows = !empty( $args['rows'] ) ? esc_attr( absint( $args['rows'] ) ) : 16;
			$cols = !empty( $args['cols'] ) ? esc_attr( absint( $args['cols'] ) ) : 20;
			$id   = esc_attr( $args['id'] );
			$name = esc_attr( $args['name'] );
			$label_text = esc_attr( $args['label_text'] );
			$text = esc_html( $args['value'] );

			printf(
				'<p><label for="%s">%s</label><textarea class="widefat" rows="%s" cols="%s" id="%s" name="%s">%s</textarea></p>',
				$id,
				$label_text,
				$rows,
				$cols,
				$id,
				$name,
				$text
			);
		}
	}
}
