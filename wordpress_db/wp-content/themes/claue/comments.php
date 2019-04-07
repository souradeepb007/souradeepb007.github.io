<?php
/**
 * The template for displaying comments.
 *
 * @since   1.0.0
 * @package Claue
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>
<div id="comments" class="comments-area">
	<?php if ( have_comments() ) : ?>
		<h4 class="tu mg__0 mt__50 mb__30 fs__16 ls__2 fwb">
			<?php
				$comments_number = get_comments_number();
				if ( 1 === $comments_number ) {
					/* translators: %s: post title */
					printf( _x( 'Comment (1)', 'comments title', 'claue' ), get_the_title() );
				} else {
					printf(
						/* translators: 1: number of comments, 2: post title */
						_nx(
							'Comment (%1$s)',
							'Comments (%1$s)',
							$comments_number,
							'comments title',
							'claue'
						),
						number_format_i18n( $comments_number ),
						get_the_title()
					);
				}
			?>
		</h4>

		<?php the_comments_navigation(); ?>

		<ol class="commentlist">
			<?php
				wp_list_comments( array(
					'style'    => 'ol',
					'callback' => 'jas_claue_comments_list',
				) );
			?>
		</ol><!-- .comment-list -->

		<?php the_comments_navigation(); ?>

	<?php endif; // Check for have_comments(). ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php echo esc_html__( 'Comments are closed.', 'claue' ); ?></p>
	<?php endif; ?>

	<?php
		$args = array(
			'comment_notes_before' => '',
			// Redefine your own textarea (the comment body)
			'comment_field' => '<div class="comment-form-comment mb__25"><textarea class="w__100" rows="8" placeholder="' . esc_html__( 'Your comment *', 'claue' ) . '" name="comment" aria-required="true"></textarea></div>',

			'fields' => '
				<div class="jas-row mb__30">
					<div class="comment-form-author jas-col-md-4">
						<input placeholder="' . esc_html__( 'Your name *', 'claue' ) . '" type="text" required="required" size="30" value="" name="author" id="author">
					</div>
					<div class="comment-form-email jas-col-md-4">
						<input placeholder="' . esc_html__( 'Your email *', 'claue' ) . '" type="email" required="required" size="30" value="" name="email" id="email">
					</div>
					<div class="comment-form-url jas-col-md-4">
						<input placeholder="' . esc_html__( 'Your website', 'claue' ) . '" type="url" size="30" value="" name="url" id="url">
					</div>
				</div>
			',

			// Change the title of the reply section
			'title_reply'=> esc_html__( 'Leave your comment', 'claue' ),

			// Change the title of send button 
			'label_submit'=> esc_html__( 'Submit', 'claue' ),
		);

		comment_form( $args );
	?>
</div><!-- .comments-area -->
