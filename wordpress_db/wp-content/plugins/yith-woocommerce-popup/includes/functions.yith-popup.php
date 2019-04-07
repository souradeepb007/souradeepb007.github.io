<?php


/**
 * Return the list of page
 *
 * @author YITH
 * @package YITH WooCommerce Popup
 * @version 1.0.0
 */
if ( !function_exists( 'ypop_get_available_pages' ) ) {
    function ypop_get_available_pages() {
        $pages = get_pages();

        $array = array();
        if ( !empty( $pages ) ) {

            foreach ( $pages as $page ) {
                $array[$page->ID] = $page->post_title;
            }

            natcasesort( $array );
            return $array;
        }
        return array();
    }
}

/**
 *
 * Return the data info to show the icon
 *
 * @param $icon (FontFamily:Icon Code)
 *
 *
 * @return   string
 * @since    2.0.0
 * @access   public
 * @author   Emanuela Castorina <emanuela.castorina@yithemes.com>
 */
if ( !function_exists( 'ypop_get_icon_data' ) ) {
    function ypop_get_icon_data( $icon ) {

        $icon_list = YIT_Plugin_Common::get_icon_list();

        $icon_data = '';
        if ( $icon != '' ) {
            $ic = explode( ':', $icon );

            if ( count( $ic ) < 2 ) {
                return $icon_data;
            }

            $icon_code = array_search( $ic[1], $icon_list[$ic[0]] );

            if ( $icon_code ) {
                $icon_code = ( strpos( $icon_code, '\\' ) === 0 ) ? '&#x' . substr( $icon_code, 1 ) . ';' : $icon_code;
            }

            $icon_data = 'data-font="' . esc_attr( $ic[0] ) . '" data-name="' . esc_attr( $icon_code ) . '" data-key="' . esc_attr( $ic[1] ) . '" data-icon="' . $icon_code . '"';
        }

        return $icon_data;
    }
}


/**
 * Get list of forms by Contact Form 7 plugin
 *
 * @param   $array array
 * @since   1.0.0
 * @author  Emanuela Castorina
 * @return  array
 */

if( ! function_exists('yith_ypop_wpcf7_get_contact_forms') ){
    function yith_ypop_wpcf7_get_contact_forms(){

        if( ! function_exists( 'wpcf7_contact_form' ) ){
            return array( '' => __( 'Plugin not activated or not installed', 'yith-woocommerce-popup' ) );
        }

        $posts = WPCF7_ContactForm::find();

        foreach( $posts as $post ){
            $array[ $post->id() ] = $post->title();
        }

        if( empty( $array ) ) return array( '' => __( 'No contact form found', 'yith-woocommerce-popup' ) );

        return $array;
    }
}



/**
 * Get list of forms by YIT Contact Form plugin
 *
 * @param   $array array
 * @since   1.0.0
 * @author  Emanuela Castorina
 * @return  array
 */
if ( !function_exists( 'yith_ypop_get_contact_forms' ) ) {
    function yith_ypop_get_contact_forms() {
        if ( !function_exists( 'YIT_Contact_Form' ) ) {
            return array( '' => __( 'Plugin not activated or not installed', 'yith-woocommerce-popup' ) );
        }

        $array = array();

        $posts = get_posts( array(
            'post_type' => YIT_Contact_Form()->contact_form_post_type
        ) );

        foreach ( $posts as $post ) {
            $array[$post->post_name] = $post->post_title;
        }

        if ( $array == array() ) {
            return array( '' => __( 'No contact form found', 'yith-woocommerce-popup' ) );
        }

        return $array;
    }
}


if ( !function_exists( 'ypop_get_shop_categories' ) ) {
    function ypop_get_shop_categories( $show_all = true ) {
        global $wpdb;

        $terms = $wpdb->get_results( 'SELECT name, slug, wpt.term_id FROM ' . $wpdb->prefix . 'terms wpt, ' . $wpdb->prefix . 'term_taxonomy wptt WHERE wpt.term_id = wptt.term_id AND wptt.taxonomy = "product_cat" ORDER BY name ASC;' );

        $categories = array();
        if ( $show_all ) {
            $categories['0'] = __( 'All categories', 'ywcm' );
        }
        if ( $terms ) {
            foreach ( $terms as $cat ) {
                $categories[$cat->term_id] = ( $cat->name ) ? $cat->name : 'ID: ' . $cat->slug;
            }
        }
        return $categories;
    }
}

/**
 * Replaces placeholders with links to WooCommerce policy pages.
 *
 * @since 3.4.0
 * @param string $text Text to find/replace within.
 * @return string
 */
function ypop_replace_policy_page_link_placeholders( $text ) {
	$privacy_page_id = get_option( 'wp_page_for_privacy_policy', 0 );

	$privacy_link    = $privacy_page_id ? '<a href="' . esc_url( get_permalink( $privacy_page_id ) ) . '" class="ypop-privacy-policy-link" target="_blank">' . __( 'privacy policy', 'yith-woocommerce-popup' ) . '</a>' : __( 'privacy policy', 'yith-woocommerce-popup' );

	$find_replace = array(
		'[privacy_policy]' => $privacy_link,
	);

	return str_replace( array_keys( $find_replace ), array_values( $find_replace ), $text );
}