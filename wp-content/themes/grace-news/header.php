<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div class="container">
 *
 * @package Grace News
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php echo esc_url( get_bloginfo( 'pingback_url' ) ); ?>">
<?php endif; ?>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php
	if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	} else {
		do_action( 'wp_body_open' );
	}
?>
<a class="skip-link screen-reader-text" href="#contentbx_grace_news">
<?php esc_html_e( 'Skip to content', 'grace-news' ); ?>
</a>
<?php
$grace_news_show_topticker 	  		        = get_theme_mod('grace_news_show_topticker', false);
$grace_news_show_hdrslidersection 	  		= get_theme_mod('grace_news_show_hdrslidersection', false);
$grace_news_show_topheader_social_part 	  	= get_theme_mod('grace_news_show_topheader_social_part', false);
?>
<div id="site_layout" <?php if( get_theme_mod( 'grace_news_boxlayout' ) ) { echo 'class="boxlayout"'; } ?>>
<?php
if ( is_front_page() && !is_home() ) {
	if( !empty($grace_news_show_hdrslidersection)) {
	 	$inner_cls = '';
	}
	else {
		$inner_cls = 'siteinner';
	}
}
else {
$inner_cls = 'siteinner';
}
?>

<div class="header-top">
<div class="container"> 
  <?php if( $grace_news_show_topticker != ''){ ?> 
    <div class="tickerarea">    
       <?php
        $grace_news_ticker_titletext = get_theme_mod('grace_news_ticker_titletext');
        if( !empty($grace_news_ticker_titletext) ){ ?>
            <div class="newsticker"><?php echo esc_html($grace_news_ticker_titletext); ?></div>
        <?php } ?>
        
        <?php
        $grace_news_ticker_shortdesc = get_theme_mod('grace_news_ticker_shortdesc');
        if( !empty($grace_news_ticker_shortdesc) ){ ?>
           <marquee><?php echo esc_html($grace_news_ticker_shortdesc); ?></marquee>
        <?php } ?>        
    </div><!--end tickerarea-->
    <?php } ?> 
    
    <?php if( $grace_news_show_topheader_social_part != ''){ ?> 
	<div class="right">
    <div class="hdrtop_social">                                                
                   <?php $grace_news_fb_link = get_theme_mod('grace_news_fb_link');
                    if( !empty($grace_news_fb_link) ){ ?>
                    <a title="facebook" class="fab fa-facebook-f" target="_blank" href="<?php echo esc_url($grace_news_fb_link); ?>"></a>
                   <?php } ?>
                
                   <?php $grace_news_twitt_link = get_theme_mod('grace_news_twitt_link');
                    if( !empty($grace_news_twitt_link) ){ ?>
                    <a title="twitter" class="fab fa-twitter" target="_blank" href="<?php echo esc_url($grace_news_twitt_link); ?>"></a>
                   <?php } ?>
            
                  <?php $grace_news_gplus_link = get_theme_mod('grace_news_gplus_link');
                    if( !empty($grace_news_gplus_link) ){ ?>
                    <a title="google-plus" class="fab fa-google-plus" target="_blank" href="<?php echo esc_url($grace_news_gplus_link); ?>"></a>
                  <?php }?>
            
                  <?php $grace_news_linked_link = get_theme_mod('grace_news_linked_link');
                    if( !empty($grace_news_linked_link) ){ ?>
                    <a title="linkedin" class="fab fa-linkedin" target="_blank" href="<?php echo esc_url($grace_news_linked_link); ?>"></a>
                  <?php } ?>                  
               </div><!--end .hdrtop_social-->
        </div>
         <?php } ?> 
	<div class="clear"></div>
  </div>
</div>


<div class="site-header <?php echo esc_attr($inner_cls); ?>"> 
  <div class="container"> 
     <div class="logo">
        <?php grace_news_the_custom_logo(); ?>
           <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
            <?php $description = get_bloginfo( 'description', 'display' );
            if ( $description || is_customize_preview() ) : ?>
                <p><?php echo esc_html($description); ?></p>
            <?php endif; ?>
      </div><!-- logo -->
  </div><!-- .container --> 
  
  <div class="header_navigation">  
	<div class="container">     
        <div class="toggle">
         <a class="toggleMenu" href="#"><?php esc_html_e('Menu','grace-news'); ?></a>
       </div><!-- toggle --> 
         <div class="grace_navi">                   
            <?php wp_nav_menu( array('theme_location' => 'primary') ); ?>
         </div><!--.grace_navi -->    
    </div><!-- .container --> 
  </div><!--header_navigation-->
    
  </div><!--.site-header --> 
  
<?php 
if ( is_front_page() && !is_home() ) {
if($grace_news_show_hdrslidersection != '') {
	for($i=1; $i<=3; $i++) {
	  if( get_theme_mod('grace_news_hdrslider_selectpage'.$i,false)) {
		$slider_Arr[] = absint( get_theme_mod('grace_news_hdrslider_selectpage'.$i,true));
	  }
	}
?> 
<div class="top_slider_area">                
<?php if(!empty($slider_Arr)){ ?>
<div id="slider" class="nivoSlider">
<?php 
$i=1;
$slidequery = new WP_Query( array( 'post_type' => 'page', 'post__in' => $slider_Arr, 'orderby' => 'post__in' ) );
while( $slidequery->have_posts() ) : $slidequery->the_post();
$image = wp_get_attachment_url( get_post_thumbnail_id($post->ID)); 
$thumbnail_id = get_post_thumbnail_id( $post->ID );
$alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true); 
?>
<?php if(!empty($image)){ ?>
<img src="<?php echo esc_url( $image ); ?>" title="#slidecaption<?php echo esc_attr( $i ); ?>" alt="<?php echo esc_attr($alt); ?>" />
<?php } ?>
<?php $i++; endwhile; ?>
</div>   

<?php 
$j=1;
$slidequery->rewind_posts();
while( $slidequery->have_posts() ) : $slidequery->the_post(); ?>                 
    <div id="slidecaption<?php echo esc_attr( $j ); ?>" class="nivo-html-caption">     
      <div class="custominfo">       
    	<h2><?php the_title(); ?></h2>
    	<?php the_excerpt(); ?>
		<?php
        $grace_news_hdrslider_readmoretext = get_theme_mod('grace_news_hdrslider_readmoretext');
        if( !empty($grace_news_hdrslider_readmoretext) ){ ?>
            <a class="slide_morebtn" href="<?php the_permalink(); ?>"><?php echo esc_html($grace_news_hdrslider_readmoretext); ?></a>
        <?php } ?>
       </div><!-- .custominfo -->                    
    </div>   
<?php $j++; 
endwhile;
wp_reset_postdata(); ?>  
<div class="clear"></div>  
</div><!--end .top_slider_area -->     
<?php } ?>
<?php } } ?>