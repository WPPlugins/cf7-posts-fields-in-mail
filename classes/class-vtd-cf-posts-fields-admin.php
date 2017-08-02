<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
class VTD_Cf_Posts_Fields_Admin {
  
  public $settings;

	public function __construct() {
		//admin script and style
		add_action('admin_enqueue_scripts', array(&$this, 'enqueue_admin_script'));
		
		add_action('vtd_cf_posts_fields_vtdesigns_admin_footer', array(&$this, 'vaptechdesigns_admin_footer_for_vtd_cf_posts_fields'));

		$this->load_class('settings');
		$this->settings = new VTD_Cf_Posts_Fields_Settings();
	}

	function load_class($class_name = '') {
	  global $VTD_Cf_Posts_Fields;
		if ('' != $class_name) {
			require_once ($VTD_Cf_Posts_Fields->plugin_path . '/admin/class-' . esc_attr($VTD_Cf_Posts_Fields->token) . '-' . esc_attr($class_name) . '.php');
		} // End If Statement
	}// End load_class()
	
	function vaptechdesigns_admin_footer_for_vtd_cf_posts_fields() {
    global $VTD_Cf_Posts_Fields;
    ?>
    <div style="clear: both"></div>
    <div id="vtd_admin_footer">
      <?php _e('Powered by', $VTD_Cf_Posts_Fields->text_domain); ?> <a href="http://vaptech.in" target="_blank"><img src="<?php echo $VTD_Cf_Posts_Fields->plugin_url.'/assets/images/vtdesigns.png'; ?>"></a><?php _e('VTDesigns', $VTD_Cf_Posts_Fields->text_domain); ?> &copy; <?php echo date('Y');?>
    </div>
    <?php
	}

	/**
	 * Admin Scripts
	 */

	public function enqueue_admin_script() {
		global $VTD_Cf_Posts_Fields;
		$screen = get_current_screen();
		
		// Enqueue admin script and stylesheet from here
		if (in_array( $screen->id, array( 'toplevel_page_vtd-cf-posts-fields-setting-admin' ))) :   
		  $VTD_Cf_Posts_Fields->library->load_qtip_lib();		  
		  wp_enqueue_script('admin_js', $VTD_Cf_Posts_Fields->plugin_url.'assets/admin/js/admin.js', array('jquery'), $VTD_Cf_Posts_Fields->version, true);
		  wp_enqueue_style('admin_css',  $VTD_Cf_Posts_Fields->plugin_url.'assets/admin/css/admin.css', array(), $VTD_Cf_Posts_Fields->version);
	  endif;
	}
}