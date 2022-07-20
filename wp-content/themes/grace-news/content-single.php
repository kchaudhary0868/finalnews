<?php
/**
 * @package Grace News
 */
?>
<div class="recentpost_listing">
<article id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?>>
    <header class="entry-header">
        <?php the_title( '<h3 class="single-title">', '</h3>' ); ?>
    </header><!-- .entry-header -->    
     <div class="postmeta">
             <?php if( get_theme_mod( 'grace_news_hide_postdate' ) == '') { ?> 
                  <div class="post-date"><?php echo get_the_date(); ?></div><!-- post-date --> 
             <?php } ?>
             <?php if( get_theme_mod( 'grace_news_hide_postcomments' ) == '') { ?> 
                  <div class="blog-comment"> <a href="<?php comments_link(); ?>"><?php comments_number(); ?></a></div>  
             <?php } ?>
              <?php if( get_theme_mod( 'grace_news_hide_postcategory' ) == '') { ?>   
                 <?php the_category( __( ', ', 'grace-news' ));?> 
             <?php } ?>                 
    </div><!-- postmeta --> 
    
     

    <div class="entry-content">		
        <?php the_content(); ?>
        <?php
        wp_link_pages( array(
            'before' => '<div class="page-links">' . __( 'Pages:', 'grace-news' ),
            'after'  => '</div>',
        ) );
        ?>
        <div class="postmeta">          
            <div class="post-tags"><?php the_tags(); ?> </div>
            <div class="clear"></div>
        </div><!-- postmeta -->
    </div><!-- .entry-content -->
   
    <footer class="entry-meta">
      <?php edit_post_link( __( 'Edit', 'grace-news' ), '<span class="edit-link">', '</span>' ); ?>
    </footer><!-- .entry-meta -->

</article>
</div><!-- .recentpost_listing-->