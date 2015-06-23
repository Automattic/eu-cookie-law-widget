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

	public static $instance;

	public $defaults = array();

	function __construct() {
		parent::__construct(
			'eu_cookie_law_widget',
			__( 'EU Cookie Law Banner', 'eucookielaw' ),
			array(
				'description' => __( 'Display a banner.', 'eucookielaw' ),
			),
			array()
		);

		add_action( 'widgets_init', array( $this, 'add_consent_cookie' ) );

		self::$instance = $this;
	}

	static public function get_nonce_name() {
		return 'eucookielaw_dismiss_' . get_current_blog_id();
	}

	public function widget( $args, $instance ) {
		$instance = wp_parse_args( $instance, $this->defaults );
		add_action( 'wp_footer', array( $this, 'footer' ) );
	}

	public function footer() {
		require( dirname( __FILE__ ) . '/templates/footer.php' );
	}


	public function form( $instance ) {
		$instance = wp_parse_args( $instance, $this->defaults );
		echo <<<SETTINGS
<label>Banner text</label><br /><textarea name="text"></textarea><br />
<br />
Hide the cookie banner<br />
<label><input type="radio" name="hide" value="button" checked="checked" /> after the user clicks the dismiss button</label><br />
<label><input type="radio" name="hide" value="scroll" /> after the user scrolls the page</label><br />
<label><input type="radio" name="hide" value="time" /> after this time: <input type="text" name="hidetime" /></label><br />

SETTINGS;
	}

	public function update( $new_instance ) {
		$instance = array();

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
