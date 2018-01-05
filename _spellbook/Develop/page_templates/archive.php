<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

<?php if ( have_posts() ) : ?>
  <?php while ( have_posts() ) : the_post(); ?>
    <div class="bushel-banner">
        <div class="container-fluid" style="padding:0px;">
            <div class="page-header">
                <?php
                /* Page Header template ( with parameters ) */
                $pht = get_the_archive_title();
                $payload = array('page_header_title' => $pht);
                mm_get_template_part( 'template-parts/page', 'header',$payload );
                ?>
            </div>
        </div>
    </div>
  <?php endwhile; ?>
<?php endif; ?>

			<div class="page-content">
				<div class="container-fluid white-back">
          <div class="row">
            <div class="col-md-12">
          		<?php
          		if ( have_posts() ) : ?>
          			<?php
          			/* Start the Loop */
          			while ( have_posts() ) : the_post();

          				/*
          				 * Include the Post-Format-specific template for the content.
          				 * If you want to override this in a child theme, then include a file
          				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
          				 */
          				get_template_part( 'template-parts/content', get_post_format() );

          			endwhile;
                ?>
                <div class="pagination_holder">
                    <!-- PAGINATION -->
                    <?php get_template_part( 'template-parts/page', 'numberinate' ); ?>
                </div>
              <?php
          		else :

          			get_template_part( 'template-parts/content', 'none' );

          		endif; ?>
            </div>
          </div>
        </div>
      </div>


<?php get_footer();
