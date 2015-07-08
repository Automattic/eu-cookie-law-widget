<div
	id="eu-cookie-law"
	class="<?php
		echo 'negative' === $instance['color-scheme'] ? 'negative ' : ''
	?>hide-on-<?php echo esc_attr( $instance['hide'] ); ?>"
	data-hide-timeout="<?php echo intval( $instance['hide-timeout'] ) ; ?>"
>
	<form action="<?php echo esc_attr( $blog_url ); ?>" method="post">
		<?php wp_nonce_field( 'eucookielaw' ); ?>
		<input type="hidden" name="eucookielaw" value="accept" />
		<input type="hidden" name="redirect_url" value="<?php echo esc_attr( $_SERVER['REQUEST_URI'] ) ?>" />
		<input type="submit" value="<?php echo esc_attr( $instance['button'] ) ?>" class="accept" />

		<?php if ( $instance['text'] == 'default' || empty( $instance['customtext'] ) ) {
			echo $defaults[ 'default-text' ];
			?><br /><?php
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
	overlay.find( 'form' ).on( 'submit', accept );
	if ( overlay.hasClass( 'hide-on-scroll' ) ) {
		initialScrollPosition = $( window ).scrollTop();
		scrollFunction = function() {
			if ( Math.abs( $( window ).scrollTop() - initialScrollPosition ) > 50 ) {
				accept();
			}
		};
		$( window ).on( 'scroll', scrollFunction );
	} else if ( overlay.hasClass( 'hide-on-time' ) ) {
		setTimeout( accept, overlay.data( 'hide-timeout' ) * 1000 );
	}

	var accepted = false;
	function accept( event ) {
		if ( accepted ) {
			return;
		}
		accepted = true;

		if ( event && event.preventDefault ) {
			event.preventDefault();
		}

		if ( overlay.hasClass( 'hide-on-scroll' ) ) {
			$( window ).off( 'scroll', scrollFunction );
		}

		var expireTime = new Date();
		expireTime.setTime( expireTime.getTime() + <?php echo $cookie_validity; ?> );

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
		z-index: 6000;
		font-size: 12px;
		color: #2e4467;
		line-height: 1.5;
		border: 1px solid #dedede;
		padding: 6px 6px 6px 15px;
		background-color: #fff;
	}

	#eu-cookie-law a,
	#eu-cookie-law a:active,
	#eu-cookie-law a:visited {
		color: inherit;
		text-decoration: underline;
		cursor: inherit;
	}

	#eu-cookie-law a:hover {
		text-decoration: none;
		cursor: pointer;
	}

	#eu-cookie-law.negative {
		background-color: #000;
		color: #fff;
		border: none;
	}

	/**
	* Using a highly-specific rule to make sure that all button styles
	* will be reset
	*/
	#eu-cookie-law input,
	#eu-cookie-law input:hover,
	#eu-cookie-law input:focus {
		display: inline;
		position: static;
		float: right;
		padding: 8px 12px;
		margin: 0 0 0 5%;
		border: 1px solid #dedede;
		border-radius: 4px;
		-moz-border-radius: 3px;
		-webkit-border-radius: 3px;
		background: #f3f3f3;
		font-size: 14px;
		line-height: inherit;
		text-transform: none;
		color: #2e4453;
		cursor: pointer;
		font-weight: inherit;
		font-family: inherit;
	}

	#eu-cookie-law.negative input,
	#eu-cookie-law.negative input:hover,
	#eu-cookie-law.negative input:focus {
		background-color: #282828;
		color: #fff;
		border-color: #535353;
	}

	@media (max-width: 600px) {
		#eu-cookie-law {
			padding-bottom: 55px;
		}

		#eu-cookie-law input.accept {
			position: absolute;
			bottom: 8px;
			right: 8px;
		}
	}

</style>
