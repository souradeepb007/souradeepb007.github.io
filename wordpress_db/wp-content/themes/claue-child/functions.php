<?php
/**
 * Claue child theme functions.
 *
 * @since   1.0.0
 * @package Claue
 */

/**
 * Enqueue style of child theme
 */
function jas_claue_enqueue_script() {
	wp_enqueue_style( 'jas-claue-parent-style', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'jas_claue_enqueue_script' );