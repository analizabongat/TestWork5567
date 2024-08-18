<?php
/**
 * The template for displaying the country, city and temperature.
 *
 * This page template will display any functions hooked into the `homepage` action.
 * By default this includes a variety of product displays and the page content itself. To change the order or toggle these components
 * use the Homepage Control plugin.
 * https://wordpress.org/plugins/homepage-control/
 *
 * Template name: Homepage
 *
 * @package storefront
 */

get_header(); ?>
<?php do_action( 'wporg_before_settings_page_html' ); ?>
<div id="countriescitytable">
</div>
<script type="text/javascript">
	
	search();

	jQuery('#search').change(function(){
		search();
	});

	function search(){
		jQuery.post(
			my_ajax_countriescitiestable_handler.ajaxurl, 
			{
				'search': 'search'
			}, 
			function(response) {
				jQuery.html(response);
			}
		);
	}
</script>
<?php do_action( 'wporg_after_settings_page_html' );
get_footer();
