<div id="eu-cookie-law" class="hide-on-<?php echo esc_attr( $instance['hide'] ); ?>" data-hide-timeout="<?php echo intval( $instance['hide-timeout'] ) ; ?>">
	<form action="<?php echo esc_attr( $blog_url ); ?>" method="post">
		<div class="text">
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

			?><a href="<?php echo esc_attr( empty( $instance['policy-url'] ) ? $defaults['default-policy-url'] : $instance['policy-url'] ); ?>"><?php
				echo esc_html( $instance['policy-link-text'] );
			?></a>

			<?php wp_nonce_field( 'eucookielaw' ); ?>
			<input type="hidden" name="eucookielaw" value="accept" />
			<input type="hidden" name="redirect_url" value="<?php echo esc_attr( $_SERVER['REQUEST_URI'] ) ?>" />
			<input type="submit" value="<?php echo esc_attr( $instance['button'] ) ?>" class="accept" />
		</div>
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
		bottom: 0;
		left: 0;
		right: 0;
		height: 8em;
		background-color: #fff;
		padding: 2em;
	}

	#eu-cookie-law div.text {
		margin-right: 30%;
	}

	#eu-cookie-law input.accept {
		float: right;
		margin-right: 3em;
	}
</style>
