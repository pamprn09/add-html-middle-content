
<?php 
/**
 * Get list of Related Article posts based on the tag
 *
 * @return string HTML two item list, with post title and link
 */
function thehill_get_promo_link() {
	$tags       = wp_get_post_tags( post_id() );
	$first_tag  = $tags[0]->term_id;
	$promo_link = get_posts(
		[
			'suppress_filters' => false,
			'tag__in'          => [ $first_tag ],
			'numberposts'      => 2,
			'post__not_in'     => [ post_id() ],
		]
	);

	$promo_link_list = '';

	if ( $promo_link ) {
		foreach ( $promo_link as $promo_link_item ) {
			setup_postdata( $promo_link_item );

			$promo_link_list .=
				'<li class="color-the-hill-blue weight-semibold text-400 ">
					<a href="' . esc_url( $promo_link_item->guid ) . '" rel="bookmark" title="' . esc_attr( $promo_link_item->post_title ) . '">' . esc_html( $promo_link_item->post_title ) . '</a>
				</li>';

		}
	}
	wp_reset_postdata();
	return '<aside class="promo-link | border-thin"><ul>' . $promo_link_list . '</ul></aside>';
}

/**
 * Count paragraphs inside content and add Related Content block above 3 last paragraphs.
 *
 * @return string with HTML having the text paragraphs and also the Related Content block.
 */
function thehill_add_related_content() {

	$content = get_the_content();

	$paragraphs = explode( '</p>', $content );

	$count_paragraphs = count( $paragraphs );

	$define_related_posts_position = $count_paragraphs - 5;

	$paragraphs[ $define_related_posts_position ] .= thehill_get_promo_link();

	/**
	 * Add related posts at the end if text is shorter than 4 paragraphs
	 * */

	if ( $count_paragraphs < 4 ) {
		$paragraphs[ $count_paragraphs ] .= thehill_get_promo_link();
	}

	return implode( '</p>', $paragraphs );
}

add_filter( 'the_content', __NAMESPACE__ . '\\thehill_add_related_content' );
