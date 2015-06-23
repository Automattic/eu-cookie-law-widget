<p>
	<strong><?php _e( 'Hide the cookie banner' ); ?></strong>
	<ul>
		<li>
			<label><input type="radio" name="<?php echo $this->get_field_name( 'hide' ); ?>" value="button" <?php checked( $instance['hide'], 'button' ); ?> /> <?php _e( 'after the user clicks the dismiss button' ); ?></label>
		</li>
		<li>
			<label><input type="radio" name="<?php echo $this->get_field_name( 'hide' ); ?>" value="scroll" <?php checked( $instance['hide'], 'scroll' ); ?> /> <?php _e( 'after the user scrolls the page' ); ?></label>
		</li>
		<li>
			<label><input type="radio" name="<?php echo $this->get_field_name( 'hide' ); ?>" value="time" <?php checked( $instance['hide'], 'time' ); ?> /> <?php _e( 'after this amount of time:' ); ?></label> <input type="number" name="<?php echo $this->get_field_name( 'hidetime' ); ?>" value="<?php echo esc_attr( $instance['hidetime'] ); ?>" style="width: 3em" /> <?php _e( 'seconds' ); ?>
		</li>
	</ul>
</p>
<hr />
<p>
	<strong><?php _e( 'Banner text' ); ?></strong>
	<ul>
		<li>
			<label><input type="radio" name="<?php echo $this->get_field_name( 'text' ); ?>" value="default" <?php checked( $instance['text'], 'default' ); ?> /> <?php _e( 'Default' ); ?></label>
		</li>
		<li>
			<label><input type="radio" name="<?php echo $this->get_field_name( 'text' ); ?>" value="custom" <?php checked( $instance['text'], 'custom' ); ?> /> <?php _e( 'Custom:' ); ?></label>
		</li>
	</ul>
	<textarea class="widefat" name="<?php echo $this->get_field_name( 'customtext' ); ?>"><?php echo esc_html( $instance['customtext'] ); ?></textarea>
</p>
<hr />
<p>
	<strong><?php _e( 'Policy URL' ); ?></strong>
	<ul>
		<li>
			<label><input type="radio" name="<?php echo $this->get_field_name( 'policyurl' ); ?>" value="default" <?php checked( $instance['policyurl'], 'default' ); ?> /> <?php _e( 'Default' ); ?></label>
		</li>
		<li>
			<label><input type="radio" name="<?php echo $this->get_field_name( 'policyurl' ); ?>" value="custom" <?php checked( $instance['policyurl'], 'custom' ); ?> /> <?php _e( 'Custom:' ); ?></label> <input type="text" class="widefat" name="<?php echo $this->get_field_name( 'custompolicyurl' ); ?>" placeholder="http://" style="margin-top: .5em" value="<?php echo esc_attr( $instance['custompolicyurl'] ); ?>" />
		</li>
	</ul>
</p>
<p>
	<strong><?php _e( 'Policy Link Text' ); ?></strong>
	<label><input type="text" class="widefat" name="<?php echo $this->get_field_name( 'policylinktext' ); ?>"value="<?php echo esc_attr( $instance['policylinktext'] ); ?>" />
<hr />
<p>
	<strong><?php _e( 'Button text' ); ?></strong>
	<label><input type="text" class="widefat" name="<?php echo $this->get_field_name( 'button' ); ?>"value="<?php echo esc_attr( $instance['button'] ); ?>" /></label>
</p>
<hr />
<p class="small"><?php _e( 'It is your own responsibility to ensure that your site complies with the relevant laws.' ); ?> <a href="https://en.support.wordpress.com/cookies-widget"><?php _e( 'Click here for more information' ); ?></a></p>
