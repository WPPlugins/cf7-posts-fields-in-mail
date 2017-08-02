<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
class VTD_Cf_Posts_Fields_Library {
  
  public $lib_path;
  
  public $lib_url;
  
  public $php_lib_path;
  
  public $php_lib_url;
  
  public $jquery_lib_path;
  
  public $jquery_lib_url;

	public function __construct() {
	  global $VTD_Cf_Posts_Fields;
	  
	  $this->lib_path = $VTD_Cf_Posts_Fields->plugin_path . 'lib/';

    $this->lib_url = $VTD_Cf_Posts_Fields->plugin_url . 'lib/';
    
    $this->php_lib_path = $this->lib_path . 'php/';
    
    $this->php_lib_url = $this->lib_url . 'php/';
    
    $this->jquery_lib_path = $this->lib_path . 'jquery/';
    
    $this->jquery_lib_url = $this->lib_url . 'jquery/';
	}
	
	/**
	 * PHP WP fields Library
	 */
	public function load_wp_fields() {
	  global $VTD_Cf_Posts_Fields;
	  if ( ! class_exists( 'VTD_WP_Fields' ) )
	    require_once ($this->php_lib_path . 'class-vtd-wp-fields.php');
	  $VTD_WP_Fields = new VTD_WP_Fields(); 
	  return $VTD_WP_Fields;
	}
	
	/**
	 * Jquery qTip library
	 */
	public function load_qtip_lib() {
	  global $VTD_Cf_Posts_Fields;
	  wp_enqueue_script('qtip_js', $this->jquery_lib_url . 'qtip/qtip.js', array('jquery'), $VTD_Cf_Posts_Fields->version, true);
		wp_enqueue_style('qtip_css',  $this->jquery_lib_url . 'qtip/qtip.css', array(), $VTD_Cf_Posts_Fields->version);
	}
	
	/**
	 * WP Media library
	 */
	public function load_upload_lib() {
	  global $VTD_Cf_Posts_Fields;
	  wp_enqueue_media();
	  wp_enqueue_script('upload_js', $this->jquery_lib_url . 'upload/media-upload.js', array('jquery'), $VTD_Cf_Posts_Fields->version, true);
	  wp_enqueue_style('upload_css',  $this->jquery_lib_url . 'upload/media-upload.css', array(), $VTD_Cf_Posts_Fields->version);
	}
	
	/**
	 * WP ColorPicker library
	 */
	public function load_colorpicker_lib() {
	  global $VTD_Cf_Posts_Fields;
	  wp_enqueue_script( 'wp-color-picker' );
    wp_enqueue_script( 'colorpicker_init', $this->jquery_lib_url . 'colorpicker/colorpicker.js', array( 'jquery', 'wp-color-picker' ), $VTD_Cf_Posts_Fields->version, true );
    wp_enqueue_style( 'wp-color-picker' );
	}
	
	
}
