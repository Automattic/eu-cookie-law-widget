<?php /*

**************************************************************************

Plugin Name:  EU Cookie Law widget
Description:  Allows the display of a
Reference:    https://dotcom.wordpress.com/2015/06/10/developer-superhero-needed/
Author:       Igor Zinovyey, Alex Kirk
Author URI:   http://automattic.com/

**************************************************************************/

class EU_Cookie_Law_Widget extends WP_Widget {

	public static $cookie_name = 'eucookielaw';

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

	static public function get_nonce_name() {
		return 'eucookielaw_dismiss_' . get_current_blog_id();
	}

	public function widget( $args, $instance ) {
		$this->instance = wp_parse_args( $instance, $this->defaults );

		echo $args['before_widget'];
		echo $args['after_widget'];
		add_action( 'wp_footer', array( $this, 'footer' ) );
	}

	public function footer() {
		require( dirname( __FILE__ ) . '/templates/footer.php' );
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
<hr />
<p class="small"><?php _e( 'It is your own responsibility to ensure your site complies with the relevant laws.' ); ?> <a href="https://en.support.wordpress.com/cookies-widget"><?php _e( 'Click here for more information' ); ?></a></p>
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
				unset( $instance['custompolicyurl'] );
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

	public static function add_consent_cookie() {
		if (
			! isset( $_POST[ self::get_nonce_name() ] )
			|| ! wp_verify_nonce(
				$_POST[ self::get_nonce_name() ],
				'eucookielaw'
			)
		) {
			return;
		}

		setcookie( self::$cookie_name, current_time( 'timestamp' ), time() + (10 * 365 * 24 * 60 * 60), '/' );
		wp_safe_redirect( $_POST['redirect_url'] );
	}
}

// Only load the widget if we're inside the admin or the user has not given
// their consent to accept cookies
if ( is_admin() || ! isset( $_COOKIE[ EU_Cookie_Law_Widget::$cookie_name ] ) ) {
	add_action( 'widgets_init', function() {
		register_widget( 'EU_Cookie_Law_Widget' );
	});

	add_action( 'init', array( 'EU_Cookie_Law_Widget', 'add_consent_cookie' ) );
}
