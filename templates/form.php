<p>
	<strong><?php echo _x( 'Hide the banner', 'action', 'eucookielaw' ); ?></strong>
	<ul>
		<li>
			<label><input type="radio" name="<?php echo $this->get_field_name( 'hide' ); ?>" value="button" <?php checked( $instance['hide'], 'button' ); ?> /> <?php _e( 'after the user clicks the dismiss button', 'eucookielaw' ); ?></label>
		</li>
		<li>
			<label><input type="radio" name="<?php echo $this->get_field_name( 'hide' ); ?>" value="scroll" <?php checked( $instance['hide'], 'scroll' ); ?> /> <?php _e( 'after the user scrolls the page', 'eucookielaw' ); ?></label>
		</li>
		<li>
			<label><input type="radio" name="<?php echo $this->get_field_name( 'hide' ); ?>" value="time" <?php checked( $instance['hide'], 'time' ); ?> /> <?php _e( 'after this amount of time:', 'eucookielaw' ); ?></label> <input type="number" name="<?php echo $this->get_field_name( 'hide-timeout' ); ?>" value="<?php echo esc_attr( $instance['hide-timeout'] ); ?>" min="3" max="1000" style="width: 3em" /> <?php _e( 'seconds', 'eucookielaw' ); ?>
		</li>
	</ul>
</p>
<hr />
<p>
	<strong><?php _e( 'Banner text', 'eucookielaw' ); ?></strong>
	<ul>
		<li>
			<label><input type="radio" name="<?php echo $this->get_field_name( 'text' ); ?>" value="default" <?php checked( $instance['text'], 'default' ); ?> /> <?php _e( 'Default' ); ?></label>
		</li>
		<li>
			<label><input type="radio" name="<?php echo $this->get_field_name( 'text' ); ?>" value="custom" <?php checked( $instance['text'], 'custom' ); ?> /> <?php _e( 'Custom:' ); ?></label>
		</li>
	</ul>
	<textarea class="widefat" name="<?php echo $this->get_field_name( 'customtext' ); ?>" placeholder="<?php echo esc_attr( $instance['default-text'] ); ?>"><?php echo esc_html( $instance['customtext'] ); ?></textarea>
</p>
<hr />
<p>
	<strong><?php _e( 'Policy URL', 'eucookielaw' ); ?></strong>
	<ul>
		<li>
			<label><input type="radio" name="<?php echo $this->get_field_name( 'policy-url' ); ?>" value="default" <?php checked( $instance['policy-url'], 'default' ); ?> /> <?php _e( 'Default' ); ?></label>
		</li>
		<li>
			<label><input type="radio" name="<?php echo $this->get_field_name( 'policy-url' ); ?>" value="custom" <?php checked( $instance['policy-url'], 'custom' ); ?> /> <?php _e( 'Custom:' ); ?></label> <input type="text" class="widefat" name="<?php echo $this->get_field_name( 'custom-policy-url' ); ?>" placeholder="<?php echo esc_attr( $instance['default-policy-url'] ); ?>" style="margin-top: .5em" value="<?php echo esc_attr( $instance['custom-policy-url'] ); ?>" />
		</li>
	</ul>
</p>
<p>
	<strong><?php _e( 'Policy Link Text', 'eucookielaw' ); ?></strong>
	<label><input type="text" class="widefat" name="<?php echo $this->get_field_name( 'policy-link-text' ); ?>" value="<?php echo esc_attr( $instance['policy-link-text'] ); ?>" />
<hr />
<p>
	<strong><?php _e( 'Button text', 'eucookielaw' ); ?></strong>
	<label><input type="text" class="widefat" name="<?php echo $this->get_field_name( 'button' ); ?>" value="<?php echo esc_attr( $instance['button'] ); ?>" /></label>
</p>
<p class="small"><?php _e( 'It is your own responsibility to ensure that your site complies with the relevant laws.', 'eucookielaw' ); ?> <a href="https://en.support.wordpress.com/cookie-widget"><?php _e( 'Click here for more information' ); ?></a></p>
