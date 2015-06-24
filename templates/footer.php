<div id="eu-cookie-law" class="hide-on-<?php echo esc_attr( $instance['hide'] ); ?>" data-hide-timeout="<?php echo intval( $instance['hide-timeout'] ) ; ?>">
	<form action="<?php echo esc_attr( $blog_url ); ?>" method="post">
		<?php wp_nonce_field( 'eucookielaw' ); ?>
		<input type="hidden" name="eucookielaw" value="accept" />
		<input type="hidden" name="redirect_url" value="<?php echo esc_attr( $_SERVER['REQUEST_URI'] ) ?>" />
		<input type="submit" value="<?php echo esc_attr( $instance['button'] ) ?>" class="accept" />

		<?php if ( $instance['text'] == 'default' || empty( $instance['customtext'] ) ) {
			echo $defaults[ 'default-text' ];
		
			if ( $instance['hide'] === 'time' ) {
				echo ' ';
			printf( _n( 'This message will disappear after %s second.', 'This message will disappear after %s seconds.', $instance['hide-timeout'], 'eucookielaw' ), $instance['hide-timeout'] );
			}
			echo ' ';
			_e( 'To find out more, as well as how to remove or block these, see here:', 'eucookielaw' );
			echo ' ';
		} else {
			echo esc_html( $instance['customtext'] ), ' ';
		}
		
		?><a href="<?php echo esc_attr( $instance['policy-url'] == 'default' || empty( $instance['custom-policy-url'] ) ? $defaults['default-policy-url'] : $instance['custom-policy-url'] ); ?>"><?php
		 echo esc_html( $instance['policy-link-text'] );
		?></a>
 </form>
</div>

<script type="text/javascript">
jQuery(function( $ ) {
	var overlay = $( '#eu-cookie-law' ), initialScrollPosition, scrollFunction;
	if ( overlay.hasClass( 'hide-on-button' ) ) {
		overlay.find( 'input.accept' ).on( 'click', accept );
	} else if ( overlay.hasClass( 'hide-on-scroll' ) ) {
		initialScrollPosition = $( window ).scrollTop();
		scrollFunction = function() {
			if ( Math.abs( $( window ).scrollTop() - initialScrollPosition ) > 50 ) {
				console.log($( window ).scrollTop() - initialScrollPosition);
				accept();
			}
		};
		$( window ).on( 'scroll', scrollFunction );
	} else if ( overlay.hasClass( 'hide-on-time' ) ) {
		setTimeout( accept, overlay.data( 'hide-timeout' ) * 1000 );
	}

	var accepted = false;
	function accept() {
		if ( accepted ) {
			return;
		}
		accepted = true;

		if ( overlay.hasClass( 'hide-on-scroll' ) ) {
			$( window ).off( 'scroll', scrollFunction );
		}

		var expireTime = new Date();
		expireTime.setTime( expireTime.getTime() + <?php echo $cookie_validity; ?> ); // 30 days

		document.cookie = '<?php echo $cookie_name; ?>=' + expireTime.getTime() + ';path=/;expires=' + expireTime.toGMTString();

		overlay.fadeOut(400, function() {
			overlay.remove();
		});
	}
});
</script>

<style type="text/css">
	#eu-cookie-law {
		position: fixed;
		bottom: 1em;
		left: 1em;
		right: 1em;
		z-index: 1000;
		font-size: 90%;
		line-height: 1.4;
		border: 1px solid #dedede;
		padding: 10px 20px;
		background-color: #fff;
	}

	#eu-cookie-law input.accept {
		float: right;
		margin-left: 5%;
	}
</style>
