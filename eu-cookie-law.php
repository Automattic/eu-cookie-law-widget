<?php /*

**************************************************************************

Plugin Name:  EU Cookie Law widget
Description:  Allows the display of a
Reference:    https://dotcom.wordpress.com/2015/06/10/developer-superhero-needed/
Author:       Igor Zinovyey, Alex Kirk
Author URI:   http://automattic.com/

**************************************************************************/

class EU_Cookie_Law_Widget extends WP_Widget {

	public $defaults = array();

	function __construct() {
		parent::__construct(
			'eu_cookie_law_widget',
			__( 'EU Cookie Law Banner', 'eucookielaw' ),
			array(
				'description' => __( 'Display a banner for compliance with the EU Cookie Law.', 'eucookielaw' ),
			),
			array()
		);

		$this->defaults = array(
			'hide' => 'button',
			'text' => 'default',
			'customtext' => '',
			'policyurl' => 'default',
			'custompolicyurl' => '',
		);
	}

	public function widget( $args, $instance ) {
		$instance = wp_parse_args( $instance, $this->defaults );
		echo $args['before_widget'];
		echo $args['after_widget'];
		add_action( 'wp_footer', array( $this, 'footer' ) );
	}

	public function footer() {

		echo <<<FOOTER
<div id="eu-cookie-law" style="position: fixed; bottom: 0; left: 0; right: 0; height: 195px; background-color: #fff">
	<img src="https://dotcom.files.wordpress.com/2015/06/cookie2.gif?w=520&h=390" align="middle" /> <button class="dismiss">Dismiss</button>
</div>
<script type="text/javascript">
jQuery( '#eu-cookie-law button.dismiss').on( 'click', function() {

});
</script>
FOOTER;
	}


	public function form( $instance ) {
		$instance = wp_parse_args( $instance, $this->defaults );
		?>
<p>
	<strong><?php _e( 'Hide the cookie banner' ); ?></strong>
	<ul>
		<li>
			<label><input type="radio" name="<?php echo $this->get_field_name( 'hide' ); ?>" value="button" <?php checked( $instance['hide'], 'button' ); ?> /> <?php _e( 'after the user clicks the dismiss button' ); ?></label>
		</li>
		<li>
			<label><input type="radio" name="<?php echo $this->get_field_name( 'hide' ); ?>" value="scroll" <?php checked( $instance['hide'], 'scroll' ); ?> /> <?php _e( 'after the user scrolls the page' ); ?></label><br />
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
			<label><input type="radio" name="<?php echo $this->get_field_name( 'text' ); ?>" value="custom" <?php checked( $instance['text'], 'custom' ); ?> /> <?php _e( 'Custom:' ); ?></label><br/>
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
			<label><input type="radio" name="<?php echo $this->get_field_name( 'policyurl' ); ?>" value="custom" <?php checked( $instance['policyurl'], 'custom' ); ?> /> <?php _e( 'Custom:' ); ?></label> <input type="text" class="widefat" name="<?php echo $this->get_field_name( 'custompolicyurl' ); ?>" placeholder="http://" style="margin-top: .5em" value="<?php echo esc_attr( $instance['custompolicyurl'] ); ?>" /><br/>
		</li>
	</ul>

</p>

		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();

		if ( in_array( $new_instance['hide'], array( 'button', 'scroll', 'time' ) ) ) {
			$instance['hide'] = $new_instance['hide'];
		}

		if ( isset( $new_instance['hidetime'] ) ) {
			$instance['hidetime'] = min( 1000, max( 5, intval( $new_instance['hidetime'] ) ) );
		}

		if ( in_array( $new_instance['text'], array( 'default', 'custom' ) ) ) {
			$instance['text'] = $new_instance['text'];
		}

		if ( isset( $new_instance['customtext'] ) ) {
			$instance['customtext'] = mb_substr( $new_instance['customtext'], 0, 4096 );
		} else {
			$instance['text'] = 'default';
		}

		if ( in_array( $new_instance['policyurl'], array( 'default', 'custom' ) ) ) {
			$instance['policyurl'] = $new_instance['policyurl'];
		}

		if ( isset( $new_instance['custompolicyurl'] ) ) {
			$instance['custompolicyurl'] = esc_url( $new_instance['custompolicyurl'], array( 'http', 'https' ) );

			if ( strlen( $instance['custompolicyurl'] ) < 10 ) {
				$instance['policyurl'] = 'default';
			}
		} else {
			$instance['policyurl'] = 'default';
		}

		return $instance;
	}
}

add_action( 'widgets_init', function() {
	register_widget( 'EU_Cookie_Law_Widget' );
});
