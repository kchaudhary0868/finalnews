<?php
/**
 * The template for displaying all pages.
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
         <section class="content_leftbx_grace_news">               
                <?php while( have_posts() ) : the_post(); ?>                               
                    <?php get_template_part( 'content', 'page' ); ?>
                    <?php
                        //If comments are open or we have at least one comment, load up the comment template
                        if ( comments_open() || '0' != get_comments_number() )
                            comments_template();
                        ?>                               
                <?php endwhile; ?>                     
        </section><!-- .content_leftbx_grace_news-->   
 <?php get_sidebar();?>      
<div class="clear"></div>
</div><!-- .contentbx_grace_news --> 
</div><!-- .container --> 
<?php get_footer(); ?>