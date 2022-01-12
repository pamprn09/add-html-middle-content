
<?php 
/**
 * Get list of Related Article posts based on the tag
 *
 * @return string HTML two item list, with post title and link
 */
function get_html_block() {
	
	return '<div>Your HTML block here</div>';
}

/**
 * Count paragraphs inside content and add HTML Block block above 3 last paragraphs.
 *
 * @return string with HTML having the text paragraphs and also the HTML block.
 */
function paragraph_count_and_add() {

	$content = get_the_content();

	$paragraphs = explode( '</p>', $content );

	$count_paragraphs = count( $paragraphs );

	$define_related_posts_position = $count_paragraphs - 5;

	$paragraphs[ $define_related_posts_position ] .= get_html_block();

	/**
	 * Add related posts at the end if text is shorter than 4 paragraphs
	 * */

	if ( $count_paragraphs < 4 ) {
		$paragraphs[ $count_paragraphs ] .= get_html_block();
	}

	return implode( '</p>', $paragraphs );
}

add_filter( 'the_content', 'paragraph_count_and_add' );
