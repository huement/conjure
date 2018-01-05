<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Bushel
 */
get_header(); ?>
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>

            <div class="bushel-banner">
                <div class="container-fluid" style="padding:0px;">
                    <div class="page-header">
                        <?php
                        /* Page Header template ( with parameters ) */
                        mm_get_template_part( 'template-parts/page', 'header' );
                        ?>
                    </div>
                </div>
            </div>

			<div class="page-content">

				<?php include(locate_template('template-parts/blog-social-share.php')); ?>

				<div class="container-fluid white-back">

					<div class="row">
                        <div class="col-md-12">
    						<div class="blog-post-content">
                                <?php wpautop(the_content()); ?>
                            </div>
                            <div class="blog-post-content-end"></div>
                        </div>
					</div>

                    <!-- <div class="row">
                        <div class="col-md-12">
                            <div class="blog-additional-nav">
                                <?php
                                // Previous/next post navigation.
                                // $NextLink = wp_trim_words(__( 'NEXT POST', 'onlinemag' ), 4);
                                // $PrevLink = wp_trim_words(__( 'PREVIOUS POST', 'onlinemag' ), 4);
                                // the_post_navigation(
                                //     array(
                                //     'next_text' => '<span class="post-navi" aria-hidden="true">' . $NextLink . '</span> ' .
                                //         '<span class="screen-reader-text">' . $NextLink . '</span> ' .
                                //         '<span class="post-title">%title</span>',
                                //     'prev_text' => '<span class="post-navi" aria-hidden="true">' . $PrevLink  . '</span> ' .
                                //         '<span class="screen-reader-text">' . $PrevLink  . '</span> ' .
                                //         '<span class="post-title">%title</span>'
                                //     )
                                // );
                                ?>
                            </div>
                        </div>
                    </div> -->

                    <div class="row">
                        <div class="col-md-12">
                            <div class="blog-additional-content">
                                <?php include(locate_template('template-parts/bottom-categories.php')); ?>
                                <?php include(locate_template('template-parts/related-blogs.php')); ?>
                                <?php include(locate_template('template-parts/resources.php')); ?>
                            </div>
                        </div>
                    </div>

                </div>

			</div>

            <div class="foot-mail">
                <?php
                /* Email Subscription template ( with parameters ) */
                mm_get_template_part( 'template-parts/email', 'subscriber', array('form_id' => '5959047', 'full_width' => true) );
                ?>
            </div>
		<?php endwhile; ?>
	<?php endif; // end have_posts() check ?>
<?php get_footer(); ?>
