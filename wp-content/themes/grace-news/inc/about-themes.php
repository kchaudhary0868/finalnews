<?php
/**
 *Grace News About Theme
 *
 * @package Grace News
 */

//about theme info
add_action( 'admin_menu', 'grace_news_abouttheme' );
function grace_news_abouttheme() {    	
	add_theme_page( __('About Theme Info', 'grace-news'), __('About Theme Info', 'grace-news'), 'edit_theme_options', 'grace_news_guide', 'grace_news_mostrar_guide');   
} 

//Info of the theme
function grace_news_mostrar_guide() { 	
?>
<div class="wrap-GT">
	<div class="gt-left">
   		   <div class="heading-gt">
			  <h3><?php esc_html_e('About Theme Info', 'grace-news'); ?></h3>
		   </div>
          <p><?php esc_html_e('The Grace News is a simple, beautiful, wonderfully creative, modern, cutting edge and responsive free magazine style WordPress theme. This theme is especially developed for news, blog, magazines, review, online fashion, lifestyle blog, entertainment, politics, world news, music and other news websites.','grace-news'); ?></p>
<div class="heading-gt"><h3><?php esc_html_e('Theme Features', 'grace-news'); ?><h3></div>
 

<div class="col-2">
  <h4><?php esc_html_e('Theme Customizer', 'grace-news'); ?></h4>
  <div class="description"><?php esc_html_e('The built-in customizer panel quickly change aspects of the design and display changes live before saving them.', 'grace-news'); ?></div>
</div>

<div class="col-2">
  <h4><?php esc_html_e('Responsive Ready', 'grace-news'); ?></h4>
  <div class="description"><?php esc_html_e('The themes layout will automatically adjust and fit on any screen resolution and looks great on any device. Fully optimized for iPhone and iPad.', 'grace-news'); ?></div>
</div>

<div class="col-2">
<h4><?php esc_html_e('Cross Browser Compatible', 'grace-news'); ?></h4>
<div class="description"><?php esc_html_e('Our themes are tested in all mordern web browsers and compatible with the latest version including Chrome,Firefox, Safari, Opera, IE11 and above.', 'grace-news'); ?></div>
</div>

<div class="col-2">
<h4><?php esc_html_e('E-commerce', 'grace-news'); ?></h4>
<div class="description"><?php esc_html_e('Fully compatible with WooCommerce plugin. Just install the plugin and turn your site into a full featured online shop and start selling products.', 'grace-news'); ?></div>
</div>
<hr />  
</div><!-- .gt-left -->
	
<div class="gt-right">			
        <div>				
            <a href="<?php echo esc_url( GRACE_NEWS_LIVE_DEMO ); ?>" target="_blank"><?php esc_html_e('Live Demo', 'grace-news'); ?></a> | 
            <a href="<?php echo esc_url( GRACE_NEWS_PROTHEME_URL ); ?>" target="_blank"><?php esc_html_e('Purchase Pro', 'grace-news'); ?></a> | 
            <a href="<?php echo esc_url( GRACE_NEWS_THEME_DOC ); ?>" target="_blank"><?php esc_html_e('Documentation', 'grace-news'); ?></a>
        </div>		
</div><!-- .gt-right-->
<div class="clear"></div>
</div><!-- .wrap-GT -->
<?php } ?>