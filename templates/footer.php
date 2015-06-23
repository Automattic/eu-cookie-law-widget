<div id="eu-cookie-law" style="position: fixed; bottom: 0; left: 0; right: 0; height: 8em; background-color: #fff; padding: 2em" class="hide-on-<?php echo esc_attr( $instance['hide'] ); ?>" data-hidetime="<?php echo intval( $instance['hidetime'] ) ; ?>">
	<form action="<?php echo $blog_url ?>" method="post">
		<div style="margin-right: 30%">
			<?php if ( $instance['text'] == 'default' || empty( $instance['customtext'] ) ) {
				echo __('Privacy & Cookies: This site uses cookies from WordPress.com and selected partners. By browsing you consent to their use. To find out more, as well as how to remove or block these, see here:' );
			} else {
				echo esc_html( $instance['customtext'] );
			}?>
			<a href="<?php echo esc_attr( empty( $instance['url'] ) ? 'https://en.support.wordpress.com/cookies' : $instance['url'] ); ?>"><?php
				echo esc_html( $instance['policylinktext'] );
			?></a>

			<?php wp_nonce_field( 'eucookielaw' ); ?>
			<input type="hidden" name="eucookielaw" value="accept" />
			<input type="hidden" name="redirect_url" value="<?php esc_attr_e( $_SERVER['REQUEST_URI'] ) ?>" />
			<input type="submit" value="<?php esc_attr_e( $instance['button'] ) ?>" class="dismiss" style="float: right; margin-right: 3em" />
		</div>
	</form>
</div>
<script type="text/javascript">
jQuery(function( $ ) {
	var div = $( '#eu-cookie-law' );
	if ( div.hasClass( 'hide-on-button' ) ) {
		div.find( 'input[type=submit]' ).on( 'click', accept );
	} else if ( div.hasClass( 'hide-on-scroll' ) ) {
		$( window ).on( 'scroll', accept );
	} else {
		setTimeout( accept, div.data( 'hidetime' ) );
	}

	function accept() {
		var expireTime = new Date;
		expireTime.setTime( expireTime.getTime() + 2592000 ); // 30 days

		document.cookie = 'eucookielaw=' + expireTime + ';path=/;expires=' + expireTime.toGMTString();
		div.remove();
	}
});
</script>
