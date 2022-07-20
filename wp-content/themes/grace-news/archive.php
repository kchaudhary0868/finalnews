<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Grace News
 */

get_header(); ?>

<div class="container">
     <div id="contentbx_grace_news">
        <section class="content_leftbx_grace_news <?php if( get_theme_mod( 'grace_news_removesidebar_from_frontapge' ) ) { ?>fullwidth<?php } ?>">
			<?php if ( have_posts() ) : ?>
                <header class="page-header">
                     <?php
						the_archive_title( '<h1 class="entry-title">', '</h1>' );
						the_archive_description( '<div class="taxonomy-description">', '</div>' );
					?> 
                </header><!-- .page-header -->
				<div class="defaultpost_lyout">
					<?php /* Start the Loop */ ?>
                    <?php while ( have_posts() ) : the_post(); ?>
                        <?php get_template_part( 'content' ); ?>
                    <?php endwhile; ?>                   
                </div>
                <?php the_posts_pagination(); ?>
            <?php else : ?>
                <?php get_template_part( 'no-results' ); ?>
            <?php endif; ?>
        </section>
       <?php if( get_theme_mod( 'grace_news_removesidebar_from_frontapge' ) == '') { ?> 
          		<?php get_sidebar();?>
        	<?php } ?>
        <div class="clear"></div>
    </div><!-- site-aligner -->
</div><!-- container -->
	
<?php get_footer(); ?>