<?php /*

**************************************************************************

Plugin Name:  EU Cookie Law widget
Description:  Allows the display of a
Reference:    https://dotcom.wordpress.com/2015/06/10/developer-superhero-needed/
Author:       Igor Zinovyey, Alex Kirk
Author URI:   http://automattic.com/

**************************************************************************/

class EU_Cookie_Law_Widget extends WP_Widget {

	public $defaults = array(), $instance;

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
			'policylinktext' => __( 'Our Cookie Policy' ),
			'button' => __( 'Close and accept' ),
		);
	}

	public function widget( $args, $instance ) {
		$this->instance = wp_parse_args( $instance, $this->defaults );

		echo $args['before_widget'];
		echo $args['after_widget'];
		add_action( 'wp_footer', array( $this, 'footer' ) );
	}

	public function footer() {
		$instance = $this->instance;
		?>
<div id="eu-cookie-law" style="position: fixed; bottom: 0; left: 0; right: 0; height: 8em; background-color: #fff; padding: 2em">
	<button class="dismiss" style="float: right; margin-right: 3em"><?php echo esc_html( $instance['button'] ); ?></button>
	<div style="margin-right: 30%">
		<?php
		if ( $instance['text'] == 'default' || empty( $instance['customtext'] ) ) {
			echo __('Privacy & Cookies: This site uses cookies from WordPress.com and selected partners. By browsing you consent to their use. To find out more, as well as how to remove or block these, see here:' );

		} else {
			echo esc_html( $instance['customtext'] );
		}
		?>

		<a href="<?php echo esc_attr( empty( $instance['url'] ) ? 'https://en.support.wordpress.com/cookies' : $instance['url'] ); ?>"><?php
			echo esc_html( $instance['policylinktext'] );
		?></a>
	</div>
</div>
<script type="text/javascript">
jQuery( '#eu-cookie-law button.dismiss').on( 'click', function() {

});
</script>
<?php
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

		if ( isset( $new_instance['policylinktext'] ) ) {
			$instance['policylinktext'] = trim( mb_substr( $new_instance['policylinktext'], 0, 100 ) );
		}

		if ( empty( $instance['policylinktext'] ) || $instance['button'] == $this->defaults['policylinktext'] ) {
			unset( $instance['policylinktext'] );
		}

		if ( isset( $new_instance['button'] ) ) {
			$instance['button'] = trim( mb_substr( $new_instance['button'], 0, 100 ) );
		}

		if ( empty( $instance['button'] ) || $instance['button'] == $this->defaults['button'] ) {
			unset( $instance['button'] );
		}

		return $instance;
	}
}

add_action( 'widgets_init', function() {
	register_widget( 'EU_Cookie_Law_Widget' );
});
