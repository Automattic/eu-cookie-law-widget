<?php
$blog_url = get_bloginfo( 'url' );

?><div id="eu-cookie-law">
	<form action="<?php echo $blog_url ?>" method="post">
		<?php wp_nonce_field( 'eucookielaw', self::get_nonce_name(), false ); ?>
		<input type="hidden" name="redirect_url" value="<?php esc_attr_e( $_SERVER['REQUEST_URI'] ) ?>" />
		<input type="submit" value="<?php _e( 'Dismiss' ) ?>" class="dismiss" />
	</form>
</div>
