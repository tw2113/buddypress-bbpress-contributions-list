<?php

trait WP_Widget_Inputs {

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
			$rows       = ! empty( $args['rows'] ) ? esc_attr( absint( $args['rows'] ) ) : 16;
			$cols       = ! empty( $args['cols'] ) ? esc_attr( absint( $args['cols'] ) ) : 20;
			$id         = esc_attr( $args['id'] );
			$name       = esc_attr( $args['name'] );
			$label_text = esc_attr( $args['label_text'] );
			$text       = esc_html( $args['value'] );

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

/*
 * <label for="<?php echo $this->get_field_id('sortby'); ?>"><?php _e( 'Sort by:' ); ?></label>
			<select name="<?php echo $this->get_field_name('sortby'); ?>" id="<?php echo $this->get_field_id('sortby'); ?>" class="widefat">
				<option value="post_title"<?php selected( $instance['sortby'], 'post_title' ); ?>><?php _e('Page title'); ?></option>
				<option value="menu_order"<?php selected( $instance['sortby'], 'menu_order' ); ?>><?php _e('Page order'); ?></option>
				<option value="ID"<?php selected( $instance['sortby'], 'ID' ); ?>><?php _e( 'Page ID' ); ?></option>
			</select>

Label before/after
<input class="checkbox" type="checkbox" <?php checked($instance['images'], true) ?> id="<?php echo $this->get_field_id('images'); ?>" name="<?php echo $this->get_field_name('images'); ?>" />
		<label for="<?php echo $this->get_field_id('images'); ?>"><?php _e('Show Link Image'); ?></label><br />


 */
