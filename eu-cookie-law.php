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
				'description' => __( 'Display a banner.', 'eucookielaw' ),
			),
			array()
		);

	}

	public function widget( $args, $instance ) {
		$instance = wp_parse_args( $instance, $this->defaults );
		add_action( 'wp_footer', array( $this, 'footer' ) );
	}

	public function footer() {

		echo '<div style="position: fixed; bottom: 0; left: 0; right: 0; height: 195px; background-color: #fff">';
		echo '<img src="https://dotcom.files.wordpress.com/2015/06/cookie2.gif?w=520&h=390" />';
		echo '</div>';
	}


	public function form( $instance ) {
		$instance = wp_parse_args( $instance, $this->defaults );

		echo 'Settings';
	}

	public function update( $new_instance ) {
		$instance = array();

		return $instance;
	}
}

add_action( 'widgets_init', function() {
	register_widget( 'EU_Cookie_Law_Widget' );
});
