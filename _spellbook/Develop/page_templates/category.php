<?php
/**
 * The template for displaying Category pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>
  <?php if ( have_posts() ) : ?>

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

  <?php endif; ?>
  
	<div class="page-content">
		<div class="container-fluid white-back">
      <div class="row">
        <div class="col-md-12">
      		<?php if ( have_posts() ) : ?>
      			
      			<?php /* The loop */ ?>
      			<?php while ( have_posts() ) : $related = the_post(); ?>
      				
              <div class="page-content">
        				
        				<div class="block row fullwidth">
        					<div class="wrapper">
        						<?php the_content(); ?>
        					</div>
        					<div class="wrapper wide">
        						
        					</div>
        				</div>
                
        			</div>
              
              
      			<?php endwhile; ?>

      			<!-- PAGE NAVIGATION -->
      		<?php endif; ?>
        </div>
      </div>
    </div>
  </div>

<?php get_footer(); ?>
