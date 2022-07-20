<?php    
/**
 *Grace News Theme Customizer
 *
 * @package Grace News
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function grace_news_customize_register( $wp_customize ) {	
	
	function grace_news_sanitize_dropdown_pages( $page_id, $setting ) {
	  // Ensure $input is an absolute integer.
	  $page_id = absint( $page_id );
	
	  // If $page_id is an ID of a published page, return it; otherwise, return the default.
	  return ( 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default );
	}

	function grace_news_sanitize_checkbox( $checked ) {
		// Boolean check.
		return ( ( isset( $checked ) && true == $checked ) ? true : false );
	}  
		
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	
	 //Panel for section & control
	$wp_customize->add_panel( 'grace_news_panel_area', array(
		'priority' => null,
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => __( 'Theme Options Panel', 'grace-news' ),		
	) );
	
	//Layout Options
	$wp_customize->add_section('grace_news_layout_option',array(
		'title' => __('Site Layout','grace-news'),			
		'priority' => 1,
		'panel' => 	'grace_news_panel_area',          
	));		
	
	$wp_customize->add_setting('grace_news_boxlayout',array(
		'sanitize_callback' => 'grace_news_sanitize_checkbox',
	));	 

	$wp_customize->add_control( 'grace_news_boxlayout', array(
    	'section'   => 'grace_news_layout_option',    	 
		'label' => __('Check to Box Layout','grace-news'),
		'description' => __('If you want to box layout please check the Box Layout Option.','grace-news'),
    	'type'      => 'checkbox'
     )); //Layout Section 
	
	$wp_customize->add_setting('grace_news_color_scheme',array(
		'default' => '#0088ff',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control($wp_customize,'grace_news_color_scheme',array(
			'label' => __('Color Scheme','grace-news'),			
			'description' => __('More color options in PRO Version','grace-news'),
			'section' => 'colors',
			'settings' => 'grace_news_color_scheme'
		))
	);
	
	 //News ticker
	$wp_customize->add_section('grace_news_topnews_ticker_section',array(
		'title' => __('Top News Ticker','grace-news'),		
		'priority' => null,
		'panel' => 	'grace_news_panel_area', 
	));
	
	$wp_customize->add_setting('grace_news_ticker_titletext',array(
		'default' => null,
		'sanitize_callback' => 'sanitize_text_field'	
	));
	
	$wp_customize->add_control('grace_news_ticker_titletext',array(	
		'type' => 'text',
		'label' => __('Add title text here','grace-news'),
		'section' => 'grace_news_topnews_ticker_section',
		'setting' => 'grace_news_ticker_titletext'
	)); // news ticker title Text
	
	$wp_customize->add_setting('grace_news_ticker_shortdesc',array(
		'default' => null,
		'sanitize_callback' => 'sanitize_text_field'	
	));
	
	$wp_customize->add_control('grace_news_ticker_shortdesc',array(	
		'type' => 'text',
		'label' => __('Add short description text here','grace-news'),
		'section' => 'grace_news_topnews_ticker_section',
		'setting' => 'grace_news_ticker_shortdesc'
	)); // news ticker short description
	
	$wp_customize->add_setting('grace_news_show_topticker',array(
		'default' => false,
		'sanitize_callback' => 'grace_news_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));	 
	
	$wp_customize->add_control( 'grace_news_show_topticker', array(
	   'settings' => 'grace_news_show_topticker',
	   'section'   => 'grace_news_topnews_ticker_section',
	   'label'     => __('Check To show This Section','grace-news'),
	   'type'      => 'checkbox'
	 ));//Show top ticker Section 		
	
	 //Top Header Social icons
	$wp_customize->add_section('grace_news_topheader_social_section',array(
		'title' => __('Header social icons','grace-news'),
		'description' => __( 'Add social icons link here to display icons in header.', 'grace-news' ),			
		'priority' => null,
		'panel' => 	'grace_news_panel_area', 
	));
	
	$wp_customize->add_setting('grace_news_fb_link',array(
		'default' => null,
		'sanitize_callback' => 'esc_url_raw'	
	));
	
	$wp_customize->add_control('grace_news_fb_link',array(
		'label' => __('Add facebook link here','grace-news'),
		'section' => 'grace_news_topheader_social_section',
		'setting' => 'grace_news_fb_link'
	));	
	
	$wp_customize->add_setting('grace_news_twitt_link',array(
		'default' => null,
		'sanitize_callback' => 'esc_url_raw'
	));
	
	$wp_customize->add_control('grace_news_twitt_link',array(
		'label' => __('Add twitter link here','grace-news'),
		'section' => 'grace_news_topheader_social_section',
		'setting' => 'grace_news_twitt_link'
	));
	
	$wp_customize->add_setting('grace_news_gplus_link',array(
		'default' => null,
		'sanitize_callback' => 'esc_url_raw'
	));
	
	$wp_customize->add_control('grace_news_gplus_link',array(
		'label' => __('Add google plus link here','grace-news'),
		'section' => 'grace_news_topheader_social_section',
		'setting' => 'grace_news_gplus_link'
	));
	
	$wp_customize->add_setting('grace_news_linked_link',array(
		'default' => null,
		'sanitize_callback' => 'esc_url_raw'
	));
	
	$wp_customize->add_control('grace_news_linked_link',array(
		'label' => __('Add linkedin link here','grace-news'),
		'section' => 'grace_news_topheader_social_section',
		'setting' => 'grace_news_linked_link'
	));
	
	$wp_customize->add_setting('grace_news_show_topheader_social_part',array(
		'default' => false,
		'sanitize_callback' => 'grace_news_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));	 
	
	$wp_customize->add_control( 'grace_news_show_topheader_social_part', array(
	   'settings' => 'grace_news_show_topheader_social_part',
	   'section'   => 'grace_news_topheader_social_section',
	   'label'     => __('Check To show This Section','grace-news'),
	   'type'      => 'checkbox'
	 ));//Show top header Social icons Section 	
		
	
	// main Slider Section		
	$wp_customize->add_section( 'grace_news_hdrslider_section', array(
		'title' => __('Front Page Slider', 'grace-news'),
		'priority' => null,
		'description' => __('Default image size for slider is 1400 x 766 pixel.','grace-news'), 
		'panel' => 	'grace_news_panel_area',           			
    ));
	
	$wp_customize->add_setting('grace_news_hdrslider_selectpage1',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'grace_news_sanitize_dropdown_pages'
	));
	
	$wp_customize->add_control('grace_news_hdrslider_selectpage1',array(
		'type' => 'dropdown-pages',
		'label' => __('Select page for slide one:','grace-news'),
		'section' => 'grace_news_hdrslider_section'
	));	
	
	$wp_customize->add_setting('grace_news_hdrslider_selectpage2',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'grace_news_sanitize_dropdown_pages'
	));
	
	$wp_customize->add_control('grace_news_hdrslider_selectpage2',array(
		'type' => 'dropdown-pages',
		'label' => __('Select page for slide two:','grace-news'),
		'section' => 'grace_news_hdrslider_section'
	));	
	
	$wp_customize->add_setting('grace_news_hdrslider_selectpage3',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'grace_news_sanitize_dropdown_pages'
	));
	
	$wp_customize->add_control('grace_news_hdrslider_selectpage3',array(
		'type' => 'dropdown-pages',
		'label' => __('Select page for slide three:','grace-news'),
		'section' => 'grace_news_hdrslider_section'
	));	// Slider Section	
	
	$wp_customize->add_setting('grace_news_hdrslider_readmoretext',array(
		'default' => null,
		'sanitize_callback' => 'sanitize_text_field'	
	));
	
	$wp_customize->add_control('grace_news_hdrslider_readmoretext',array(	
		'type' => 'text',
		'label' => __('Add slider Read more button name here','grace-news'),
		'section' => 'grace_news_hdrslider_section',
		'setting' => 'grace_news_hdrslider_readmoretext'
	)); // Slider Read More Button Text
	
	$wp_customize->add_setting('grace_news_show_hdrslidersection',array(
		'default' => false,
		'sanitize_callback' => 'grace_news_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));	 
	
	$wp_customize->add_control( 'grace_news_show_hdrslidersection', array(
	    'settings' => 'grace_news_show_hdrslidersection',
	    'section'   => 'grace_news_hdrslider_section',
	     'label'     => __('Check To Show This Section','grace-news'),
	   'type'      => 'checkbox'
	 ));//Show Slider Section	
	 
	 
	 // Sidebar Options
	$wp_customize->add_section('grace_news_sidebar_options', array(
		'title' => __('Sidebar Options','grace-news'),		
		'priority' => null,
		'panel' => 	'grace_news_panel_area',          
	));	
	
	$wp_customize->add_setting('grace_news_removesidebar_from_frontapge',array(
		'default' => false,
		'sanitize_callback' => 'grace_news_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));	 
	
	$wp_customize->add_control( 'grace_news_removesidebar_from_frontapge', array(
	   'settings' => 'grace_news_removesidebar_from_frontapge',
	   'section'   => 'grace_news_sidebar_options',
	   'label'     => __('Check to hide sidebar from home page','grace-news'),
	   'type'      => 'checkbox'
	 ));//sidebar hide
	 
	 
	 $wp_customize->add_setting('grace_news_hidesidebar_singlepost',array(
		'default' => false,
		'sanitize_callback' => 'grace_news_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));	 
	
	$wp_customize->add_control( 'grace_news_hidesidebar_singlepost', array(
	   'settings' => 'grace_news_hidesidebar_singlepost',
	   'section'   => 'grace_news_sidebar_options',
	   'label'     => __('Check to remove sidebar from single post','grace-news'),
	   'type'      => 'checkbox'
	 ));//single post sidebar options
	 
	 $wp_customize->add_setting('grace_news_hidethumb_blogposts',array(
		'default' => false,
		'sanitize_callback' => 'grace_news_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));	 
	
	$wp_customize->add_control( 'grace_news_hidethumb_blogposts', array(
	   'settings' => 'grace_news_hidethumb_blogposts',
	   'section'   => 'grace_news_sidebar_options',
	   'label'     => __('Check to remove thumbnail from blogpost','grace-news'),
	   'type'      => 'checkbox'
	 ));//remove features image for blog post	
	 
	 // Blog post &  single post options
	$wp_customize->add_section('grace_news_blogpost_singlepost_options', array(
		'title' => __('Blog post and Single post options','grace-news'),		
		'priority' => null,
		'panel' => 	'grace_news_panel_area',          
	));	
	
	$wp_customize->add_setting('grace_news_hide_postdate',array(
		'default' => false,
		'sanitize_callback' => 'grace_news_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));	 
	
	$wp_customize->add_control( 'grace_news_hide_postdate', array(
	   'settings' => 'grace_news_hide_postdate',
	   'section'   => 'grace_news_blogpost_singlepost_options',
	   'label'     => __('Check to hide post date','grace-news'),
	   'type'      => 'checkbox'
	 ));//hide post date
	 
	 $wp_customize->add_setting('grace_news_hide_postcomments',array(
		'default' => false,
		'sanitize_callback' => 'grace_news_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));	 
	
	$wp_customize->add_control( 'grace_news_hide_postcomments', array(
	   'settings' => 'grace_news_hide_postcomments',
	   'section'   => 'grace_news_blogpost_singlepost_options',
	   'label'     => __('Check to hide post comments','grace-news'),
	   'type'      => 'checkbox'
	 ));//hide comments
	 
	 
	 $wp_customize->add_setting('grace_news_hide_postcategory',array(
		'default' => false,
		'sanitize_callback' => 'grace_news_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));	 
	
	$wp_customize->add_control( 'grace_news_hide_postcategory', array(
	   'settings' => 'grace_news_hide_postcategory',
	   'section'   => 'grace_news_blogpost_singlepost_options',
	   'label'     => __('Check to hide post category','grace-news'),
	   'type'      => 'checkbox'
	 ));//hide category 
	 		 
	 
		 
}
add_action( 'customize_register', 'grace_news_customize_register' );

function grace_news_custom_css(){ 
?>
	<style type="text/css"> 					
        a, .recentpost_listing h2 a:hover,
        #sidebar ul li a:hover,	
		.grace_navi ul li a:hover, 
	    .grace_navi ul li.current-menu-item a,
	    .grace_navi ul li.current-menu-parent a.parent,
	    .grace_navi ul li.current-menu-item ul.sub-menu li a:hover,				
        .recentpost_listing h3 a:hover,		
        .postmeta a:hover,		
        .button:hover,			
		.services_3_column:hover h3 a,
		.welcome_content_column h3 span       				
            { color:<?php echo esc_html( get_theme_mod('grace_news_color_scheme','#0088ff')); ?>;}					 
            
        .pagination ul li .current, .pagination ul li a:hover, 
        #commentform input#submit:hover,		
        .nivo-controlNav a.active,				
        .learnmore,
		a.blogreadmore,
		.welcome_content_column .btnstyle1,		
		.nivo-caption .slide_morebtn,													
        #sidebar .search-form input.search-submit,				
        .wpcf7 input[type='submit'],	
		nav.pagination .page-numbers:hover,			
        nav.pagination .page-numbers.current,
		.blogpost_cat a,
        .toggle a	
            { background-color:<?php echo esc_html( get_theme_mod('grace_news_color_scheme','#0088ff')); ?>;}
			
		.nivo-caption .slide_morebtn:hover,		
		.tagcloud a:hover,		
		.welcome_content_column p,		
		blockquote	        
            { border-color:<?php echo esc_html( get_theme_mod('grace_news_color_scheme','#0088ff')); ?>;}
			
		button:focus,
		input[type="button"]:focus,
		input[type="reset"]:focus,
		input[type="submit"]:focus,
		input[type="text"]:focus,
		input[type="email"]:focus,
		input[type="url"]:focus,
		input[type="password"]:focus,
		input[type="search"]:focus,
		input[type="number"]:focus,
		input[type="tel"]:focus,
		input[type="range"]:focus,
		input[type="date"]:focus,
		input[type="month"]:focus,
		input[type="week"]:focus,
		input[type="time"]:focus,
		input[type="datetime"]:focus,
		input[type="datetime-local"]:focus,
		input[type="color"]:focus,
		textarea:focus,
		a:focus	        
            { border-color:<?php echo esc_html( get_theme_mod('grace_news_color_scheme','#0088ff')); ?>;}			
			
         	
    </style> 
<?php                  
}
         
add_action('wp_head','grace_news_custom_css');	 

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function grace_news_customize_preview_js() {
	wp_enqueue_script( 'grace_news_customizer', get_template_directory_uri() . '/js/customize-preview.js', array( 'customize-preview' ), '20191002', true );
}
add_action( 'customize_preview_init', 'grace_news_customize_preview_js' );