<?php
  /**
   * Get a post's permalink, then run it through special filters and trigger
   * the 'special_action' action hook.
   *
   * @param int $post_id The post ID being linked to.
   * @return str|bool    The permalink or a boolean false if $post_id does
   *                     not exist.
   */
  function my_permalink_function( $post_id ) {
  	$permalink = get_permalink( absint( $post_id ) );
  	$permalink = apply_filters( 'special_filter', $permalink );

  	do_action( 'special_action', $permalink );

  	return $permalink;
  }
?>
