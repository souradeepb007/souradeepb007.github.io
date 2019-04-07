<?php
/**
 * Instagram widget.
 *
 * @since   1.0.0
 * @package Claue
 */

class jas_claue_Widget_Instagram extends WP_Widget {

	function __construct() {
		$widget_ops  = array(
			'description' => esc_html__( 'Show off your favorite Instagram photos', 'claue' )
		);
		$control_ops = array(
			'width'  => 'auto',
			'height' => 'auto'
		);
		parent::__construct( 'jas_claue_instagram', esc_html__( 'Claue - Instagram', 'claue' ), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title   = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$id      = empty($instance['id']) ? '' : $instance['id'];
		$token   = empty($instance['token']) ? '' : $instance['token'];
		$limit   = empty( $instance['limit'] ) ? 4 : ( int ) $instance['limit'];
		$columns = empty( $instance['columns'] ) ? 2 : ( int ) $instance['columns'];

		if ( ! ( $id && $token ) ) return;

		echo wp_kses_post( $before_widget );
		
		if ( ! empty( $title ) ) {
			echo wp_kses_post( $before_title . $title . $after_title );
		}
		if ( intval( $id ) === 0 ) {
			echo '<p>No user ID specified.</p>';
		}
		
		$transient_var = $id . '_' . $limit;
		
		if ( false === ( $items = get_transient( $transient_var ) ) ) {
		
			$response = wp_remote_get( 'https://api.instagram.com/v1/users/' . esc_attr( $id ) . '/media/recent/?access_token=' . esc_attr( $token ) . '&count=' . esc_attr( $limit ) );

			if ( ! is_wp_error( $response ) ) {
		
				$response_body = json_decode( $response['body'] );
				
				if ( $response_body->meta->code !== 200 ) {
					echo '<p>Incorrect user ID specified.</p>';
				}
				
				$items_as_objects = $response_body->data;
				$items = array();
				foreach ( $items_as_objects as $item_object ) {
					$item['link'] = $item_object->link;
					$item['src']  = $item_object->images->thumbnail->url;
					$items[]      = $item;
				}
				
				set_transient( $transient_var, $items, 60 * 60 );
			}
		}
		
		$output = '<div class="jas-instagram clearfix columns-' . esc_attr( $columns ) . '">';
		
		if ( isset( $items ) ) {
			foreach ( $items as $item ) {
				$link  = $item['link'];
				$image = $item['src'];
				$output	.= '<div class="item dib"><a target="_blank" href="' . esc_url( $link ) .'"><img width="150" height="150" src="' . esc_url( $image ) . '" alt="Instagram" /></a></div>';
			}
		}
		
		$output .= '</div>';

		echo wp_kses_post( $output . $after_widget );
	}

	function update( $new_instance, $old_instance ) {
		$instance            = $old_instance;
		$instance['title']   = strip_tags( $new_instance['title'] );
		$instance['id']      = $new_instance['id'];
		$instance['token']   = $new_instance['token'];
		$instance['limit']   = strip_tags( $new_instance['limit'] );
		$instance['columns'] = strip_tags( $new_instance['columns'] );

		return $instance;
	}

	function form( $instance ) {
		$instance  = wp_parse_args( ( array ) $instance, array( 'title' => '', 'id' => '', 'limit' => 4, 'columns' => 2 ) );
		$title     = strip_tags( $instance['title'] );
		$id        = isset( $instance['id'] ) ? $instance['id'] : '';
		$token     = isset( $instance['token'] ) ? $instance['token'] : '';
		$limit     = ( int ) $instance['limit'];
		$columns   = ( int ) $instance['columns'];
		$url_id    = 'https://codeofaninja.com/tools/find-instagram-user-id';
		$url_token = 'http://instagram.pixelunion.net/';
	?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_html__( 'Title:', 'claue' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'id' ) ); ?>"><?php printf( wp_kses_post( 'Instagram user ID (<a href="%s" target="_blank">Lookup your User ID</a>)', 'claue' ), $url_id ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'id' ) ); ?>" type="text" value="<?php echo esc_attr( $id ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'token' ) ); ?>"><?php printf( wp_kses_post( 'Instagram Access Token (<a href="%s" target="_blank">Lookup your Access Token</a>)', 'claue' ), $url_token ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'token' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'token' ) ); ?>" type="text" value="<?php echo esc_attr( $token ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php echo esc_html__( 'Number of Photos:', 'claue' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>" type="number" min="1" value="<?php echo esc_attr( $limit ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'columns' ) ); ?>"><?php echo esc_html__( 'Columns (1-4):', 'claue' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'columns' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'columns' ) ); ?>" type="number" min="1" max="4" step="1" value="<?php echo esc_attr( $columns ); ?>" />
		</p>

	<?php
	}
}