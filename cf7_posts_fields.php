<?php
/*
Plugin Name: Cf7 Posts Fields
Plugin URI: http://www.vtdesignz.com/
Description: This plugin is an addon for Contact Form 7 Where admin can add post fields in contact form mail like page title, page url and meta data as per plugin configuration. 
Author: Prabhakar Kumar Shaw, vaptechdesigns
Version: 1.0.0
Author URI: http://www.vtdesignz.com/
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
if ( ! class_exists( 'VTD_CF7_Dependencies' ) )
	require_once trailingslashit(dirname(__FILE__)).'includes/class-vtdcf7-dependencies.php';
require_once trailingslashit(dirname(__FILE__)).'includes/vtd-cf-posts-fields-core-functions.php';
require_once trailingslashit(dirname(__FILE__)).'config.php';
if(!defined('ABSPATH')) exit; // Exit if accessed directly
if(!defined('VTD_CF_POSTS_FIELDS_PLUGIN_TOKEN')) exit;
if(!defined('VTD_CF_POSTS_FIELDS_TEXT_DOMAIN')) exit;

if(! VTD_CF7_Dependencies::cf7_active_check()) {
  add_action( 'admin_notices', 'cf7_posts_fields_alert_notice' );
}

function cf7_post_fields_plugin_links( $links ) {	
		$plugin_links = array(
			'<a href="' . admin_url( 'admin.php?page=vtd-cf-posts-fields-setting-admin' ) . '">' . __( 'Settings', VTD_CF_POSTS_FIELDS_TEXT_DOMAIN ) . '</a>',
			'<a href="http://www.vtdesignz.com/">' . __( 'Support', VTD_CF_POSTS_FIELDS_TEXT_DOMAIN ) . '</a>',
			
		);	
		return array_merge( $plugin_links, $links );
	}
	add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'cf7_post_fields_plugin_links' );

if(!class_exists('VTD_Cf_Posts_Fields')) {
	require_once( trailingslashit(dirname(__FILE__)).'classes/class-vtd-cf-posts-fields.php' );
	global $VTD_Cf_Posts_Fields;
	$VTD_Cf_Posts_Fields = new VTD_Cf_Posts_Fields( __FILE__ );
	$GLOBALS['VTD_Cf_Posts_Fields'] = $VTD_Cf_Posts_Fields;
}
?>