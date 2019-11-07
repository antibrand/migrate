<?php
/**
 * Migrate
 *
 * @package     Migrate
 * @version     1.0.0
 * @author      Greg Sweet <greg@ccdzine.com>
 * @copyright   Copyright © 2019, Greg Sweet
 * @link        https://github.com/ControlledChaos/unbranded-migrate
 *
 * Plugin Name:  migrate
 * Plugin URI:   https://github.com/ControlledChaos/unbranded-migrate
 * Description:  Migrate to your website management system.
 * Version:      1.0.0
 * Author:       Controlled Chaos Design
 * Author URI:   http://ccdzine.com/
 * Text Domain:  unbranded
 * Domain Path:  /languages
 * Tested up to: 5.2.3
 */

/**
 * Renaming the plugin
 *
 * First change the name of this file to reflect the directory name of your plugin.
 *
 * Next change the information above in the plugin header, and either change
 * the plugin name in the License & Warranty notice or remove it.
 *
 * Following is a list of strings to find and replace in all plugin files.
 *
 * 1. Plugin name & namespace
 *    Find `Migrate` and replace with your plugin name, include
 *    underscores between words. This will change the primary plugin class name
 *    and the package name in file headers.
 *
 * 2. Text domain
 *    Find unbranded and replace with the new name of your
 *    primary plugin file (this file).
 *
 * 3. Constants prefix
 *    Find `UBM` and replace with something unique to your plugin name. Use
 *    only uppercase letters.
 *
 * 4. General prefix
 *    Find `ubm__` and replace with something unique to your plugin name. Use
 *    only lowercase letters. This will change the prefix of all filters and
 *    settings, and the prefix of functions outside of a class.
 *
 * 5. Author
 *    Find `Greg Sweet <greg@ccdzine.com>` and replace with your name and
 *    email address or those of your organization.
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The core plugin class
 *
 * Defines constants, gets the initialization class file
 * plus the activation and deactivation classes.
 *
 * @since  1.0.0
 * @access public
 */

// First check for other classes with the same name.
if ( ! class_exists( 'Migrate' ) ) :
	final class Migrate {

		/**
		 * Instance of the class
		 *
		 * @since  1.0.0
		 * @access public
		 * @return object Returns the instance.
		 */
		public static function instance() {

			// Varialbe for the instance to be used outside the class.
			static $instance = null;

			if ( is_null( $instance ) ) {

				// Set variable for new instance.
				$instance = new self;

				// Define plugin constants.
				$instance->constants();

				// Require the core plugin class files.
				$instance->dependencies();

			}

			// Return the instance.
			return $instance;

		}

		/**
		 * Constructor method
		 *
		 * @since  1.0.0
		 * @access private
		 * @return self
		 */
		private function __construct() {}

		/**
		 * Define plugin constants
		 *
		 * Change the prefix and the text domain to that
		 * which suits the needs of your website.
		 *
		 * Change the version as appropriate.
		 *
		 * @since  1.0.0
		 * @access private
		 * @return void
		 */
		private function constants() {

			/**
			 * Plugin version
			 *
			 * Keeping the version at 1.0.0 as this is a starter plugin but
			 * you may want to start counting as you develop for your use case.
			 *
			 * @since  1.0.0
			 * @return string Returns the latest plugin version.
			 */
			if ( ! defined( 'UBM_VERSION' ) ) {
				define( 'UBM_VERSION', '1.0.0' );
			}

			/**
			 * Text domain
			 *
			 * @since  1.0.0
			 * @return string Returns the text domain of the plugin.
			 */
			if ( ! defined( 'UBM_DOMAIN' ) ) {
				define( 'UBM_DOMAIN', 'unbranded' );
			}

			/**
			 * Plugin folder path
			 *
			 * @since  1.0.0
			 * @return string Returns the filesystem directory path (with trailing slash)
			 *                for the plugin __FILE__ passed in.
			 */
			if ( ! defined( 'UBM_PATH' ) ) {
				define( 'UBM_PATH', plugin_dir_path( __FILE__ ) );
			}

			/**
			 * Plugin folder URL
			 *
			 * @since  1.0.0
			 * @return string Returns the URL directory path (with trailing slash)
			 *                for the plugin __FILE__ passed in.
			 */
			if ( ! defined( 'UBM_URL' ) ) {
				define( 'UBM_URL', plugin_dir_url( __FILE__ ) );
			}

			/**
			 * Universal slug
			 *
			 * This URL slug is used for various plugin admin & settings pages.
			 *
			 * The prefix will change in your search & replace in renaming the plugin.
			 * Change the second part of the define(), here as 'unbranded',
			 * to your preferred page slug.
			 *
			 * @since  1.0.0
			 * @return string Returns the URL slug of the admin pages.
			 */
			if ( ! defined( 'UBM_ADMIN_SLUG' ) ) {
				define( 'UBM_ADMIN_SLUG', 'unbranded' );
			}

			/**
			 * Current management system
			 *
			 * @since  1.0.0
			 * @return string Returns the name of the current management system.
			 */
			if ( ! defined( 'UBM_CURRENT' ) ) {

				// If ClassicPress is the current management system.
				if ( function_exists( 'classicpress_version' ) ) {
					define( 'UBM_CURRENT', 'ClassicPress' );

				// If calmPress is the current management system.
				} elseif ( defined( 'ABSPATH' ) && file_exists( ABSPATH . 'wp-includes/calmpress/autoloader.php' ) ) {
					define( 'UBM_CURRENT', 'calmPress' );

				// Check for an "unbranded" or white-labeled management system.
				} elseif ( defined( 'ABSPATH' ) && defined( 'APP_NAME' ) ) {
					define( 'UBM_CURRENT', APP_NAME );

				// Presume that WordPress is the current management system.
				} elseif ( defined( 'ABSPATH' ) ) {
					define( 'UBM_CURRENT', 'WordPress' );

				// Otherwise leave empty.
				} else {
					define( 'UBM_CURRENT', '' );
				}
			}

		}

		/**
		 * Throw error on object clone.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return void
		 */
		public function __clone() {

			// Cloning instances of the class is forbidden.
			_doing_it_wrong( __FUNCTION__, __( 'This is not allowed.', 'unbranded' ), '1.0.0' );

		}

		/**
		 * Disable unserializing of the class.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return void
		 */
		public function __wakeup() {

			// Unserializing instances of the class is forbidden.
			_doing_it_wrong( __FUNCTION__, __( 'This is not allowed.', 'unbranded' ), '1.0.0' );

		}

		/**
		 * Require the core plugin class files
		 *
		 * @since  1.0.0
		 * @access private
		 * @return void Gets the file which contains the plugin initiation class.
		 */
		private function dependencies() {

			// The hub of all other dependency files.
			require_once UBM_PATH . 'includes/class-init.php';

			// Include the activation class.
			require_once UBM_PATH . 'includes/class-activate.php';

			// Include the deactivation class.
			require_once UBM_PATH . 'includes/class-deactivate.php';

		}

	}
	// End core plugin class.

	/**
	 * Put an instance of the plugin class into a function
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object Returns the instance of the `Migrate` class.
	 */
	function ubm_plugin() {

		return Migrate::instance();

	}

	// Begin plugin functionality.
	ubm_plugin();

// End the check for the plugin class.
endif;

// Bail out now if the core class was not run.
if ( ! function_exists( 'ubm_plugin' ) ) {
	return;
}

/**
 * Register the activaction & deactivation hooks.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
register_activation_hook( __FILE__, '\ubm_activate_plugin' );
register_deactivation_hook( __FILE__, '\ubm_deactivate_plugin' );

/**
 * The code that runs during plugin activation.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function ubm_activate_plugin() {

	// Run the activation class.
	ubm_activate();

}

/**
 * The code that runs during plugin deactivation.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function ubm_deactivate_plugin() {

	// Run the deactivation class.
	ubm_deactivate();

}