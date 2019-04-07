<?php
/**
 * Add element instagram for VC.
 *
 * @since   1.0.0
 * @package Claue
 */

function jas_claue_vc_map_instagram() {
	vc_map(
		array(
			'name'     => esc_html__( 'Instagram', 'claue' ),
			'base'     => 'claue_addons_instagram',
			'icon'     => 'pe-7s-share',
			'category' => esc_html__( 'Social', 'claue' ),
			'params'   => array(
				array(
					'param_name'  => 'user_id',
					'heading'     => esc_html__( 'User ID', 'claue' ),
					'description' => sprintf( wp_kses_post( 'Lookup User ID <a target="_blank" href="%s">here</a>', 'claue' ), 'https://codeofaninja.com/tools/find-instagram-user-id' ),
					'type'        => 'textfield',
				),
				array(
					'param_name'  => 'username',
					'heading'     => esc_html__( 'Username', 'claue' ),
					'type'        => 'textfield',
					'admin_label' => true,
					'dependency' => array(
						'element' => 'slider',
						'value'   => 'no'
					),
				),
				array(
					'param_name' => 'link',
					'heading'    => esc_html__( 'Link to Instagram', 'claue' ),
					'type'       => 'textfield',
					'dependency' => array(
						'element'   => 'username',
						'not_empty' => true
					),
				),
				array(
					'param_name'  => 'access_token',
					'heading'     => esc_html__( 'Access Token', 'claue' ),
					'description' => sprintf( wp_kses_post( 'Lookup Access Token <a target="_blank" href="%s">here</a>', 'claue' ), 'http://instagram.pixelunion.net/' ),
					'type'        => 'textfield',
				),
				array(
					'param_name'  => 'limit',
					'heading'     => esc_html__( 'Per Page', 'claue' ),
					'description' => esc_html__( 'How much items per page to show', 'claue' ),
					'type'        => 'textfield',
					'value'       => 12
				),
				array(
					'param_name'  => 'columns',
					'heading'     => esc_html__( 'Columns', 'claue' ),
					'description' => esc_html__( 'This parameter is not working if slider has enabled', 'claue' ),
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( '2 columns', 'claue' ) => 2,
						esc_html__( '3 columns', 'claue' ) => 3,
						esc_html__( '4 columns', 'claue' ) => 4,
						esc_html__( '5 columns', 'claue' ) => 5,
						esc_html__( '6 columns', 'claue' ) => 6,
						esc_html__( '7 columns', 'claue' ) => 7,
						esc_html__( '8 columns', 'claue' ) => 8,
						esc_html__( '9 columns', 'claue' ) => 9,
						esc_html__( '10 columns', 'claue' ) => 10,
					),
					'dependency' => array(
						'element' => 'slider',
						'value'   => 'no'
					),
				),
				array(
					'param_name'  => 'size',
					'heading'     => esc_html__( 'Image size', 'claue' ),
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( '150x150', 'claue' ) => 'thumbnail',
						esc_html__( '320x320', 'claue' ) => 'low',
						esc_html__( '640x640', 'claue' ) => 'standard',
					),
					'std' => 'low',
				),
				array(
					'param_name' => 'gutter',
					'heading'    => esc_html__( 'Gutter Width', 'claue' ),
					'type'       => 'textfield',
				),
				array(
					'param_name' => 'slider',
					'heading'    => esc_html__( 'Enable Slider', 'claue' ),
					'type'       => 'dropdown',
					'value'      => array(
						esc_html__( 'No', 'claue' )  => 'no',
						esc_html__( 'Yes', 'claue' ) => 'yes',
					)
				),
				array(
					'param_name'  => 'items',
					'heading'     => esc_html__( 'Items (Number only)', 'claue' ),
					'group'       => esc_html__( 'Slider Settings', 'claue' ),
					'description' => esc_html__( 'Set the maximum amount of items displayed at a time with the widest browser width', 'claue' ),
					'type'        => 'textfield',
					'value'       => 4,
					'dependency' => array(
						'element' => 'slider',
						'value'   => 'yes'
					),
				),
				array(
					'param_name' => 'autoplay',
					'heading'    => esc_html__( 'Enable Auto play', 'claue' ),
					'group'      => esc_html__( 'Slider Settings', 'claue' ),
					'type'       => 'checkbox',
					'dependency' => array(
						'element' => 'slider',
						'value'   => 'yes'
					),
				),
				array(
					'param_name' => 'arrows',
					'heading'    => esc_html__( 'Enable Navigation', 'claue' ),
					'group'      => esc_html__( 'Slider Settings', 'claue' ),
					'type'       => 'checkbox',
					'dependency' => array(
						'element' => 'slider',
						'value'   => 'yes'
					),
				),
				array(
					'param_name' => 'dots',
					'heading'    => esc_html__( 'Enable Pagination', 'claue' ),
					'group'      => esc_html__( 'Slider Settings', 'claue' ),
					'type'       => 'checkbox',
					'dependency' => array(
						'element' => 'slider',
						'value'   => 'yes'
					),
				),
				array(
					'param_name'  => 'class',
					'heading'     => esc_html__( 'Extra class name', 'claue' ),
					'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'claue' ),
					'type' 	      => 'textfield',
				),
			)
		)
	);
}
add_action( 'vc_before_init', 'jas_claue_vc_map_instagram' );