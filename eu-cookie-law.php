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
	public static $cookie_validity = 2592000; // 30 days

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
		$blog_url = get_bloginfo( 'url' );
		$instance = $this->instance;
		$cookie_name = self::$cookie_name;
		$cookie_validity = self::$cookie_validity;

		require( dirname( __FILE__ ) . '/templates/footer.php' );
	}

	public function form( $instance ) {
		$instance = wp_parse_args( $instance, $this->defaults );
		require( dirname( __FILE__ ) . '/templates/form.php' );
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();

		if ( in_array( $new_instance['hide'], array( 'button', 'scroll', 'time' ) ) ) {
			$instance['hide'] = $new_instance['hide'];
		}

		if ( isset( $new_instance['hidetime'] ) ) {
			// time can be a value between 5 and 1000 seconds
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

		if ( isset( $new_instance['resetcookie'] ) && $new_instance['resetcookie'] ) {
			// show the banner again
			setcookie( self::$cookie_name, '', time() - 86400, '/' );
		}

		return $instance;
	}

	public static function add_consent_cookie() {
		if (
			! isset( $_POST['eucookielaw'] )
			|| 'accept' !== $_POST['eucookielaw']
		) {
			return;
		}

		if (
			! isset( $_POST[ '_wpnonce' ] )
			|| ! wp_verify_nonce( $_POST[ '_wpnonce' ], 'eucookielaw' )
		) {
			return;
		}

		// Cookie is valid for 30 days, so the user will be shown the banner again after 30 days
		setcookie( self::$cookie_name, current_time( 'timestamp' ), time() + self::$cookie_validity, '/' );

		wp_safe_redirect( $_POST['redirect_url'] );
	}
}

// Only load the widget if we're inside the admin or the user has not given
// their consent to accept cookies
if ( is_admin() || empty( $_COOKIE[ EU_Cookie_Law_Widget::$cookie_name ] ) ) {
	add_action( 'widgets_init', function() {
		if ( ! is_automattician() ) {
			// only available for a12s for the moment
			return;
		}

		register_widget( 'EU_Cookie_Law_Widget' );
	});

	add_action( 'init', array( 'EU_Cookie_Law_Widget', 'add_consent_cookie' ) );
}
