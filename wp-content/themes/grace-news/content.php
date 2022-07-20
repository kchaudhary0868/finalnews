<?php
/**
 * @package Grace News
 */
?>
 <div class="recentpost_listing <?php if( get_theme_mod( 'grace_news_removesidebar_from_frontapge' ) ) { ?>post3col<?php } ?>">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>            
         <?php if( get_theme_mod( 'grace_news_hidethumb_blogposts' ) == '') { ?> 
        <?php if (has_post_thumbnail() ){ ?>
			<div class="blogpost_imagebx">
            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
            <?php if( get_theme_mod( 'grace_news_hide_postcategory' ) == '') { ?> 
              <div class="blogpost_cat"><?php the_category( __( ', ', 'grace-news' ));?></div>
            <?php } ?>
			</div>
		<?php } }  ?>
        
        <header class="entry-header">           
            <h3><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
            <?php if ( 'post' == get_post_type() ) : ?>
                <div class="postmeta">
                   <?php if( get_theme_mod( 'grace_news_hide_postdate' ) == '') { ?> 
                     <div class="post-date"><?php echo get_the_date(); ?></div><!-- post-date --> 
                   <?php } ?> 
                   <?php if( get_theme_mod( 'grace_news_hide_postcomments' ) == '') { ?>  
                    <div class="blog-comment"> <a href="<?php comments_link(); ?>"><?php comments_number(); ?></a></div>  
                    <?php } ?>                          
                </div><!-- postmeta -->
            <?php endif; ?>
        </header><!-- .entry-header -->
          
        <?php if ( is_search() || !is_single() ) : // Only display Excerpts for Search ?>
        <div class="entry-summary">
           	<?php the_excerpt(); ?>
            <a class="blogreadmore" href="<?php the_permalink(); ?>"><?php esc_html_e('Learn more &rarr;','grace-news'); ?></a>         
        </div><!-- .entry-summary -->
        <?php else : ?>
        <div class="entry-content">
            <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'grace-news' ) ); ?>
            <?php
                wp_link_pages( array(
                    'before' => '<div class="page-links">' . __( 'Pages:', 'grace-news' ),
                    'after'  => '</div>',
                ) );
            ?>
        </div><!-- .entry-content -->
        <?php endif; ?>
        <div class="clear"></div>
    </article><!-- #post-## -->
</div>