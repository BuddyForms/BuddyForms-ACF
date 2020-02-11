<?php

/*
 * Plugin Name: BuddyForms Advanced Custom Fields
 * Plugin URI: http://buddyforms.com/downloads/buddyforms-advanced-custom-fields/
 * Description: Integrates the populare ACF Plugin with BuddyForms. Use all ACF Fields in your form like native BuddyForms Form Elements
 * Version: 1.3.0
 * Author: ThemeKraft
 * Author URI: https://themekraft.com/buddyforms/
 * License: GPLv2 or later
 * Network: false
 * Text Domain: buddyforms
 * Svn: buddyforms-acf
 *****************************************************************************
 *
 * This script is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 ****************************************************************************
 */

class BuddyFormsACF {
	/**
	 * @var string
	 */
	public static $version = '1.3.0';

	/**
	 * Initiate the class
	 *
	 * @package buddyforms acf
	 * @since 0.1
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'includes' ), 4, 1 );
		add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ) );
		add_action( 'buddyforms_admin_js_css_enqueue', array( $this, 'buddyforms_acf_admin_js' ) );
		add_action( 'init', array( $this, 'buddyforms_acf_front_js_css_enqueue' ), 2, 1 );
		$this->load_constants();
	}

	/**
	 * Get plugin version
	 *
	 * @return string
	 */
	static function getVersion() {
		return self::$version;
	}

	/**
	 * Defines constants needed throughout the plugin.
	 *
	 * These constants can be overridden in bp-custom.php or wp-config.php.
	 *
	 * @package buddyforms_acf
	 * @since 0.1
	 */
	public function load_constants() {
		if ( ! defined( 'BUDDYFORMS_ACF_PLUGIN_URL' ) ) {
			define( 'BUDDYFORMS_ACF_PLUGIN_URL', plugins_url( '/', __FILE__ ) );
		}
		if ( ! defined( 'BUDDYFORMS_ACF_INSTALL_PATH' ) ) {
			define( 'BUDDYFORMS_ACF_INSTALL_PATH', dirname( __FILE__ ) . '/' );
		}
		if ( ! defined( 'BUDDYFORMS_ACF_INCLUDES_PATH' ) ) {
			define( 'BUDDYFORMS_ACF_INCLUDES_PATH', BUDDYFORMS_ACF_INSTALL_PATH . 'includes/' );
		}
		if ( ! defined( 'BUDDYFORMS_ACF_TEMPLATE_PATH' ) ) {
			define( 'BUDDYFORMS_ACF_TEMPLATE_PATH', BUDDYFORMS_ACF_INSTALL_PATH . 'templates/' );
		}
	}

	/**
	 * Include files needed by BuddyForms
	 *
	 * @package buddyforms_acf
	 * @since 0.1
	 */
	public function includes() {
		require_once BUDDYFORMS_ACF_INCLUDES_PATH . 'form-elements.php';
	}

	/**
	 * Load the textdomain for the plugin
	 *
	 * @package buddyforms_acf
	 * @since 0.1
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( 'buddyforms', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Enqueue the needed CSS for the admin screen
	 *
	 * @package buddyforms_acf
	 * @since 0.1
	 */
	function buddyforms_acf_admin_style( $hook_suffix ) {
	}

	/**
	 * Enqueue the needed JS for the admin screen
	 *
	 * @package buddyforms_acf
	 * @since 0.1
	 */
	function buddyforms_acf_admin_js( $hook_suffix ) {
		global $post;
		if ( isset( $post ) && $post->post_type == 'buddyforms' && isset( $_GET['action'] ) && $_GET['action'] == 'edit' || isset( $post ) && $post->post_type == 'buddyforms' && $hook_suffix == 'post-new.php' || $hook_suffix == 'buddyforms_page_bf_add_ons' || $hook_suffix == 'buddyforms_page_bf_settings' ) {
			wp_enqueue_script( 'buddyforms-acf-form-builder-js', plugins_url( 'assets/admin/js/form-builder.js', __FILE__ ), array( 'jquery' ) );
		}
	}

	/**
	 * Enqueue the needed JS for the frontend
	 *
	 * @package buddyforms_acf
	 * @since 0.1
	 */
	function buddyforms_acf_front_js_css_enqueue() {
		if ( is_admin() ) {
			return;
		}

		if ( ! post_type_exists( 'acf-field-group' ) ) {
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script(
				'iris',
				admin_url( 'js/iris.min.js' ),
				array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ),
				false,
				1
			);
			wp_enqueue_script(
				'wp-color-picker',
				admin_url( 'js/color-picker.min.js' ),
				array( 'iris' ),
				false,
				1
			);
			$colorpicker_l10n = array(
				'clear'         => __( 'Clear' ),
				'defaultString' => __( 'Default' ),
				'pick'          => __( 'Select Color' ),
			);
			wp_localize_script( 'wp-color-picker', 'wpColorPickerL10n', $colorpicker_l10n );
			// dequeue wp styling
			wp_dequeue_style( array( 'colors-fresh' ) );
		}

		if ( function_exists( 'acf_form_head' ) ) {
			acf_form_head();
			global $acf;
			if ( isset( $acf ) ) {
				if ( function_exists( 'acf_get_url' ) ) {
					$version = acf_get_setting( 'version' );
					$min     = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
					wp_enqueue_script( 'acf-pro-field-group', acf_get_url( "/assets/js/acf-field-group{$min}.js" ), array( 'acf-field-group' ), $version );
				}

			}
		}

	}

}

$GLOBALS['BuddyFormsACF'] = new BuddyFormsACF();
//
// Check the plugin dependencies
//
add_action(
	'init',
	function () {
		// Only Check for requirements in the admin
		if ( ! is_admin() ) {
			return;
		}
		// Require TGM
		require dirname( __FILE__ ) . '/includes/resources/tgm/class-tgm-plugin-activation.php';
		// Hook required plugins function to the tgmpa_register action
		add_action( 'tgmpa_register', function () {
			$bf_acf_depand = false;

			if ( ! class_exists( 'acf' ) ) {
				$bf_acf_depand = true;
				// Create the required plugins array
				$plugins['advanced-custom-fields'] = array(
					'name'     => 'Advanced Custom Fields',
					'slug'     => 'advanced-custom-fields',
					'required' => true,
				);
			}


			if ( ! defined( 'BUDDYFORMS_PRO_VERSION' ) ) {
				$bf_acf_depand         = true;
				$plugins['buddyforms'] = array(
					'name'     => 'BuddyForms',
					'slug'     => 'buddyforms',
					'required' => true,
				);
			}


			if ( $bf_acf_depand ) {
				$config = array(
					'id'           => 'buddyforms-tgmpa',
					'parent_slug'  => 'plugins.php',
					'capability'   => 'manage_options',
					'has_notices'  => true,
					'dismissable'  => false,
					'is_automatic' => true,
				);
				// Call the tgmpa function to register the required plugins
				tgmpa( $plugins, $config );
			}

		} );
	},
	1,
	1
);
// Create a helper function for easy SDK access.
function buddyforms_acf_fs() {
	global $buddyforms_acf_fs;

	if ( ! isset( $buddyforms_acf_fs ) ) {
		// Include Freemius SDK.
		if ( file_exists( dirname( dirname( __FILE__ ) ) . '/buddyforms/includes/resources/freemius/start.php' ) ) {
			// Try to load SDK from parent plugin folder.
			require_once dirname( dirname( __FILE__ ) ) . '/buddyforms/includes/resources/freemius/start.php';
		} else if ( file_exists( dirname( dirname( __FILE__ ) ) . '/buddyforms-premium/includes/resources/freemius/start.php' ) ) {
			// Try to load SDK from premium parent plugin folder.
			require_once dirname( dirname( __FILE__ ) ) . '/buddyforms-premium/includes/resources/freemius/start.php';
		}

		$buddyforms_acf_fs = fs_dynamic_init( array(
			'id'             => '410',
			'slug'           => 'buddyforms-acf',
			'type'           => 'plugin',
			'public_key'     => 'pk_08c84f0b4787a8364f3bd9aa1119f',
			'is_premium'     => false,
			'has_paid_plans' => false,
			'parent'         => array(
				'id'         => '391',
				'slug'       => 'buddyforms',
				'public_key' => 'pk_dea3d8c1c831caf06cfea10c7114c',
				'name'       => 'BuddyForms',
			),
			'menu'           => array(
				'slug'       => 'edit.php?post_type=buddyforms',
				'first-path' => 'edit.php?post_type=buddyforms&page=buddyforms_welcome_screen',
				'support'    => false,
			),
			'is_live'        => true,
		) );
	}

	return $buddyforms_acf_fs;
}

function buddyforms_acf_fs_is_parent_active_and_loaded() {
	// Check if the parent's init SDK method exists.
	return function_exists( 'buddyforms_core_fs' );
}

function buddyforms_acf_fs_is_parent_active() {
	$active_plugins_basenames = get_option( 'active_plugins' );
	foreach ( $active_plugins_basenames as $plugin_basename ) {
		if ( 0 === strpos( $plugin_basename, 'buddyforms/' ) || 0 === strpos( $plugin_basename, 'buddyforms-premium/' ) ) {
			return true;
		}
	}

	return false;
}

function buddyforms_acf_fs_init() {

	if ( buddyforms_acf_fs_is_parent_active_and_loaded() ) {
		// Init Freemius.
		buddyforms_acf_fs();
		// Parent is active, add your init code here.
	} else {
		// Parent is inactive, add your error handling here.
	}

}


if ( buddyforms_acf_fs_is_parent_active_and_loaded() ) {
	// If parent already included, init add-on.
	buddyforms_acf_fs_init();
} else {

	if ( buddyforms_acf_fs_is_parent_active() ) {
		// Init add-on only after the parent is loaded.
		add_action( 'buddyforms_core_fs_loaded', 'buddyforms_acf_fs_init' );
	} else {
		// Even though the parent is not activated, execute add-on for activation / uninstall hooks.
		buddyforms_acf_fs_init();
	}

}
