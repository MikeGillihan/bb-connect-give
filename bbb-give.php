<?php
/**
 * Plugin Name: Beaver Builder Bridge: Give Donations
 * Plugin URI: https://purposewp.com/
 * Description: Easily add your Give donation forms to any Beaver Builder page or post.
 * Version: 0.1.0
 * Author: PurposeWP
 * Author URI: https://purposewp.com
 * Copyright: (c) 2017 PurposeWP, LLC
 * License: GNU General Public License v2.0
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: bbb-give
 * Domain Path: /languages
 */

/**
 * WordPress resources for developers
 *
 * Codex:            https://codex.wordpress.org/
 * Plugin Handbook:  https://developer.wordpress.org/plugins/
 * Coding Standards: http://make.wordpress.org/core/handbook/coding-standards/
 * Contribute:       https://make.wordpress.org/
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'BBB_GiveWP' ) ) :
	/**
	 * Main BBB_GiveWP Class.
	 *
	 * @since 0.1.0
	 */
	final class BBB_GiveWP {
		/**
		 * @var BBB_GiveWP The one true BBB_GiveWP
		 * @since 0.1.0
		 */
		private static $instance;

		/**
		 * @var array Container array for errors
		 */
		public static $errors;

		/**
		 * Main BBB_GiveWP Instance.
		 *
		 * Insures that only one instance of BBB_GiveWP exists in memory at any one
		 * time. Also prevents needing to define globals all over the place.
		 *
		 * @since     0.1.0
		 * @static
		 * @staticvar array $instance
		 * @uses      BBB_GiveWP::define_constants() Setup the constants needed.
		 * @uses      BBB_GiveWP::load_modules() Include the required files.
		 * @uses      BBB_GiveWP::load_textdomain() load the language files.
		 * @see       BBB_GiveWP()
		 * @return object|BBB_GiveWP The one true BBB_GiveWP
		 */
		public function instance() {

			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof BBB_GiveWP ) ) {

				self::$instance = new BBB_GiveWP;
				self::$errors   = array();

				self::$instance->define_constants();
				self::$instance->init();
			}

			return self::$instance;
		}

		/**
		 * Throw error on object clone.
		 *
		 * The whole idea of the singleton design pattern is that there is a single
		 * object therefore, we don't want the object to be cloned.
		 *
		 * @since  0.1.0
		 * @access protected
		 * @return void
		 */
		public function __clone() {
			// Cloning instances of the class is forbidden.
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'bbb-give' ), '0.1.0' );
		}

		/**
		 * Disable de-serializing of the class.
		 *
		 * @since  0.1.0
		 * @access protected
		 * @return void
		 */
		public function __wakeup() {
			// de-serializing instances of the class is forbidden.
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'bbb-give' ), '0.1.0' );
		}

		/**
		 * Initialize the plugin's constants.
		 *
		 * @since 0.1.0
		 *
		 * @return void
		 */
		private static function define_constants() {

			// Plugin Folder Path.
			if ( ! defined( 'BBB_GIVE_DIR' ) ) {
				define( 'BBB_GIVE_DIR', plugin_dir_path( __FILE__ ) );
			}

			// Plugin Folder URL.
			if ( ! defined( 'BBB_GIVE_URL' ) ) {
				define( 'BBB_GIVE_URL', plugin_dir_url( __FILE__ ) );
			}

			// Plugin Root File.
			if ( ! defined( 'BBB_GIVE_FILE' ) ) {
				define( 'BBB_GIVE_FILE', __FILE__ );
			}
		}

		/**
		 * Initiate the plugins functions
		 */
		public function init() {
			add_action( 'plugins_loaded', array( $this, 'plugins_check' ) );
			add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
			add_action( 'init', array( $this, 'load_modules' ) );
		}

		/**
		 * Check if required plugins are activated
		 */
		public function plugins_check() {
			include_once ABSPATH . 'wp-admin/includes/plugin.php';

			// Exit early if required plugins are active.
			if ( class_exists( 'FLBuilder' ) && class_exists( 'Give' ) ) {
				return;
			}

			// Display notice and deactivate plugin
			if ( is_admin() && current_user_can( 'activate_plugins' ) ) {
				add_action( 'admin_notices', array( self::$instance, 'admin_notices' ) );
				add_action( 'network_admin_notices', array( self::$instance, 'admin_notices' ) );

				$plugin = plugin_basename( __FILE__ );
				deactivate_plugins( $plugin, true );

				if ( isset( $_GET['activate'] ) ) {
					unset( $_GET['activate'] );
				}
			}
		}

		/**
		 * Include required files.
		 *
		 * @access private
		 * @since  0.1.0
		 * @return void
		 */
		public function load_modules() {

			if ( ! function_exists( 'is_plugin_active' ) ) {
				include_once ABSPATH . 'wp-admin/includes/plugin.php';
			}

			$bb_lite = 'beaver-builder-lite-version/fl-builder.php';

			// Modules
			if ( class_exists( 'FLBuilder' ) || is_plugin_active( $bb_lite ) ) {
				include_once BBB_GIVE_DIR . 'modules/bbb-donation-forms/bbb-donation-forms.php';
			}
		}

		/**
		 * Loads the plugin language files.
		 *
		 * @access public
		 * @since  0.1.0
		 * @return void
		 */
		public function load_textdomain() {
			load_plugin_textdomain( 'bbb-give', false, basename( dirname( __FILE__ ) ) . '/languages/' );
		}

		/**
		 * Admin notices.
		 *
		 * @since 0.1.0
		 * @return void
		 */
		public function admin_notices() {

			if ( ! class_exists( 'Give' ) ) {
				?>
                <div class="notice notice-error">
                    <p>
						<?php
						$givewp = '<a href="https://wordpress.org/plugins/give/" target="_blank">Give - WordPress Donation Plugin</a>';
						echo sprintf( esc_html__( 'Beaver Builder Bridge: Give Donations requires the %1$s. Plugin deactivated.', 'bbb-give' ), $givewp ); ?>
                    </p>
                </div>
				<?php
			} else if ( ! class_exists( 'FLBuilder' ) ) {
				?>
                <div class="notice notice-error">
                    <p>
						<?php
						$bb_lite = '<a href="https://wordpress.org/plugins/beaver-builder-lite-version/" target="_blank">Beaver Builder</a>';
						echo sprintf( esc_html__( 'Beaver Builder Bridge: Give Donations requires the %1$s plugin. Plugin deactivated.', 'bbb-give' ), $bb_lite ); ?>
                    </p>
                </div>
				<?php
			} else if ( count( self::$errors ) ) {
				foreach ( self::$errors as $key => $msg ) {
					?>
                    <div class="notice notice-error">
                        <p><?php echo $msg; ?></p>
                    </div>
					<?php
				}
			}
		}
	}
endif;

/**
 * The main function that returns BBB_GiveWP
 *
 * The main function responsible for returning the one true BBB_GiveWP instance to functions everywhere. Use this function like you would a global variable, except without needing to declare the global.
 *
 * Example: <?php $give = BBB_Give(); ?>
 *
 * @credit Pippin Williamson - This pattern is pretty much a direct copy of Easy Digital Downloads's main wrapper.
 * @since  0.1.0
 * @return object|BBB_GiveWP one true BBB_GiveWP instance.
 */
function BBB_Give() {
	return BBB_GiveWP::instance();
}

// Get BBB_GiveWP Running.
BBB_Give();