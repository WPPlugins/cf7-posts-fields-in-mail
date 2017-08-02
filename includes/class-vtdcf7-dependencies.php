<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * CF7 Dependency Checker
 *
 */
class VTD_CF7_Dependencies {
	private static $active_plugins;
	static function init() {
		self::$active_plugins = (array) get_option( 'active_plugins', array() );
		if ( is_multisite() )
			self::$active_plugins = array_merge( self::$active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );
	}

	public static function cf7_active_check() {
		if ( ! self::$active_plugins ) self::init();		
		return in_array( 'contact-form-7/wp-contact-form-7.php', self::$active_plugins ) || array_key_exists( 'contact-form-7/wp-contact-form-7.php', self::$active_plugins );
	}
}

