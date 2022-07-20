<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Grace News
 */
 
?>

<div class="footer-wrapper"> 
        <div class="footer-copyright"> 
            <div class="container">
                <div class="powerby">
				  <?php bloginfo('name'); ?> - <?php esc_html_e('Proudly Powered by WordPress','grace-news'); ?>               
                </div>	
                <div class="design-by"><?php esc_html_e('Theme by Grace Themes','grace-news'); ?></div>
                <div class="clear"></div>
                
                
               
                
                
             </div><!--end .container-->             
        </div><!--end .footer-copyright-->  
                     
     </div><!--end #footer-wrapper-->
</div><!--#end site_layout-->

<?php wp_footer(); ?>
</body>
</html>