<?php
/*
Plugin Name: Timer Element For Elementor
Plugin URI:
Description:
Version: 1.0
Author: LWHH
Author URI: https://hasin.me
License: GPLv2 or later
Text Domain: timerelement
Domain Path: /languages/
*/

use \Elementor\Plugin as Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	die( __( "Direct Access is not allowed", 'timerelement' ) );
}

final class TimerElementExtension {

	const VERSION = "1.0.0";
	const MINIMUM_ELEMENTOR_VERSION = "2.0.0";
	const MINIMUM_PHP_VERSION = "7.0";

	private static $_instance = null;

	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;

	}

	public function __construct() {
		add_action( 'plugins_loaded', [ $this, 'init' ] );
	}

	public function init() {
		load_plugin_textdomain( 'timerelement', false, dirname( __FILE__ ) . "/languages" );

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );

			return;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );

			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );

			return;
		}

		add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );

		add_action( "elementor/elements/categories_registered", [ $this, 'register_new_category' ] );

		add_action( "elementor/frontend/after_enqueue_styles", [ $this, 'frontend_assets_styles' ] );
		add_action( "elementor/frontend/after_enqueue_scripts", [ $this, 'frontend_assets_scripts' ] );

	}

	function frontend_assets_scripts(){
		wp_enqueue_script("flipclock-js",plugins_url("/assets/js/flipclock.min.js",__FILE__),array('jquery'),'1.0',true);
		wp_enqueue_script("timerelement-helper-js",plugins_url("/assets/js/scripts.js",__FILE__),array('jquery','flipclock-js'),time(),true);
	}



	function frontend_assets_styles() {
		wp_enqueue_style("flipclock-css",plugins_url("/assets/css/flipclock.css",__FILE__));
	}


	public function register_new_category( $manager ) {
		$manager->add_category( 'LWHH', [
			'title' => __( 'LWHH Elementor', 'timerelement' ),
			'icon'  => 'fa fa-image'
		] );

	}

	public function init_widgets() {
		require_once (__DIR__."/widgets/timer-widget.php");
		// Register widget
		Plugin::instance()->widgets_manager->register_widget_type(new Elementor_Timer_Widget());
	}


	public function admin_notice_minimum_php_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
		/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'timerelement' ),
			'<strong>' . esc_html__( 'Elementor Test Extension', 'timerelement' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'timerelement' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	public function admin_notice_minimum_elementor_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
		/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'timerelement' ),
			'<strong>' . esc_html__( 'Elementor Test Extension', 'timerelement' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'timerelement' ) . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	public function admin_notice_missing_main_plugin() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
		/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'timerelement' ),
			'<strong>' . esc_html__( 'Elementor Test Extension', 'timerelement' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'timerelement' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );


	}

	public function includes() {
	}

}

TimerElementExtension::instance();