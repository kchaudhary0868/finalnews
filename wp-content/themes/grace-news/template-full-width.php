<?php
/**
 * The Template Name: Full Width
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Grace News
 */

get_header(); ?>
<div class="container">
<div id="contentbx_grace_news">
     <section class="content_leftbx_grace_news fullwidth">               
            <?php while( have_posts() ) : the_post(); ?>
				  <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>    
                   <div class="entry-content">
					  <?php the_content(); ?>
                      <?php
                        wp_link_pages( array(
                        'before' => '<div class="page-links">' . __( 'Pages:', 'grace-news' ),
                        'after'  => '</div>',
                        ) );
                      ?>
                     <?php
                        //If comments are open or we have at least one comment, load up the comment template
                        if ( comments_open() || '0' != get_comments_number() )
                            comments_template();
                    ?>
                </div><!-- entry-content -->
            <?php endwhile; ?>                    		
    </section><!-- section-->   
</div><!-- .contentbx_grace_news --> 
</div><!-- .container --> 
<?php get_footer(); ?>