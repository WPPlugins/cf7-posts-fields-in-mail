<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}
if(!function_exists('get_cf_posts_fields_settings')) {
  function get_cf_posts_fields_settings($name = '', $tab = '') {
    if(empty($tab) && empty($name)) return '';
    if(empty($tab)) return get_option($name);
    if(empty($name)) return get_option("vtd_{$tab}_settings_name");
    $settings = get_option("vtd_{$tab}_settings_name");
    if(!isset($settings[$name])) return '';
    return $settings[$name];
  }
}

if(!function_exists('cf7_posts_fields_alert_notice')) { 
	function cf7_posts_fields_alert_notice() {
	?>
	<div id="message" class="error">
      <p><?php printf( __( '%sContact Form 7 Posts Fields is inactive.%s The %sContact form 7%s must be active for the Contact Form 7 Posts Fields to work. Please %sinstall & activate Contact form 7%s', VTD_CF_POSTS_FIELDS_TEXT_DOMAIN ), '<strong>', '</strong>', '<a target="_blank" href="http://wordpress.org/extend/plugins/contact-form-7/">', '</a>', '<a href="' . admin_url( 'plugins.php' ) . '">', '&nbsp;&raquo;</a>' ); ?></p>
    </div>
    <?php 	
  }
}
?>
