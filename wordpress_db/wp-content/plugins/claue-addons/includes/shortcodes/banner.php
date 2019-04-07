<?php
/**
 * Banner shortcode.
 *
 * @package ClaueAddons
 * @since   1.0.0
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'claue_addons_shortcode_banner' ) ) {
	function claue_addons_shortcode_banner( $atts, $content = null ) {
		$output = $text = $image = '';

		extract( shortcode_atts( array(
			'image'         => '',
			'text'          => '',
			'link'          => '',
			'css_animation' => '',
			'class'         => '',
		), $atts ) );

		$classes = array( 'jas-banner pr oh' );

		if ( ! empty( $class ) ) {
			$classes[] = $class;
		}

		if ( '' !== $css_animation ) {
			wp_enqueue_script( 'waypoints' );
			$classes[] = 'wpb_animate_when_almost_visible wpb_' . $css_animation;
		}

		$output .= '<div class="' . esc_attr( implode( ' ', $classes ) ) . '">';
			if ( ! empty( $link ) ) {
				$link = vc_build_link( $link );
				$output .= '<a href="' . esc_attr( $link['url'] ) . '"' . ( $link['target'] ? ' target="' . esc_attr( $link['target'] ) . '"' : '' ) . ( $link['rel'] ? ' rel="' . esc_attr( $link['rel'] ) . '"' : '' ) . ( $link['title'] ? ' title="' . esc_attr( $link['title'] ) . '"' : '' ) . '>';
			}
				if ( ! empty( $image ) ) {
					$img_id = preg_replace( '/[^\d]/', '', $image );
					$image  = wpb_getImageBySize( array( 'attach_id' => $img_id ) );

					$output .= '<img class="w__100" src="' . esc_url( $image['p_img_large'][0] ) . '" width="' . esc_attr( $image['p_img_large'][1] ) . '" height="' . esc_attr( $image['p_img_large'][2] ) . '" alt="' . esc_attr( $text ) . '" />';
				}
			if ( ! empty( $link ) ) {
				$output .= '</a>';
			}
			if ( $text ) {
				$output .= '<h3 class="pa tc">' . esc_html( $text ) . '</h3>';
			}
		$output .= '</div>';

		// Return output
		return apply_filters( 'claue_addons_shortcode_banner', force_balance_tags( $output ) );
	}
}