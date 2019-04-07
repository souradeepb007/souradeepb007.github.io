<?php
/**
 * Checkout terms and conditions area.
 *
 * @package WooCommerce/Templates
 * @version 3.4.0
 */
defined( 'ABSPATH' ) || exit;

$terms_page_id = wc_get_page_id( 'terms' );

if ( $terms_page_id > 0 && apply_filters( 'woocommerce_checkout_show_terms', true ) ) :
	$terms         = get_post( $terms_page_id );
	$terms_content = has_shortcode( $terms->post_content, 'woocommerce_checkout' ) ? '' : wc_format_content( $terms->post_content );

	if ( $terms_content ) {
		do_action( 'woocommerce_checkout_before_terms_and_conditions' );
		echo '<div class="woocommerce-terms-and-conditions" style="display: none; max-height: 200px; overflow: auto;">' . do_shortcode( $terms_content ) . '</div>';
	}
	?>
	<div class="woocommerce-terms-and-conditions-wrapper">
		<?php
			/**
			 * Terms and conditions hook used to inject content.
			 *
			 * @since 3.4.0.
			 * @hooked wc_privacy_policy_text() Shows custom privacy policy text. Priority 20.
			 * @hooked wc_terms_and_conditions_page_content() Shows t&c page content. Priority 30.
			 */
			do_action( 'woocommerce_checkout_terms_and_conditions' );
		?>
		<?php if ( wc_terms_and_conditions_checkbox_enabled() ) : ?>
			<p class="validate-required form-row terms wc-terms-and-conditions pr style-checkbox">
				<input type="checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" name="terms" <?php checked( apply_filters( 'woocommerce_terms_is_checked_default', isset( $_POST['terms'] ) ), true ); // WPCS: input var ok, csrf ok. ?> id="terms" />
				<label for="terms" class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox"></label><span><?php printf( __( 'I&rsquo;ve read and accept the <a href="%s" class="woocommerce-terms-conditions-link" target="_blank">terms &amp; conditions</a>', 'claue' ), esc_url( wc_get_page_permalink( 'terms' ) ) ); ?></span> <span class="required">*</span>
				
				<input type="hidden" name="terms-field" value="1" />
			</p>
		<?php endif; ?>
	</div>
	<?php do_action( 'woocommerce_checkout_after_terms_and_conditions' ); ?>
<?php endif; ?>
