<?php


class JW_Site extends Timber\Site {

	public function __construct() {

		add_action( 'after_setup_theme', array( $this, 'theme_supports' ) );
		add_action( 'init', array( $this, 'register_post_types'));


		parent::__construct();

	}

	function hooks() {

		add_filter( 'timber/context', array( $this, 'add_to_context' ) );
		add_filter( 'timber/twig', array( $this, 'add_to_twig' ) );



		// SCRIPTS AND STYLES
		// add_action( 'admin_enqueue_scripts', 'add_admin_styles' );
		add_action('wp_enqueue_scripts', array($this, 'site_scripts_and_styles'), 10);



	}

	function theme_supports() {

	}

	function register_post_types() {

	}

	function add_to_context() {

	}

	function add_to_twig() {
		
	}

	function site_scripts_and_styles() {

		$build_dir = THEME . '/build/';
		$styles = (WP_ENV == 'production') ? 'site.min.css' : 'site.css';
		$site_css_time = 'v' . filemtime($build_dir . $styles);


		wp_enqueue_style('site', $build_dir . $styles, array(), $site_css_time);

		//wp_enqueue_script( 'site-js', get_stylesheet_directory_uri() . '/dist/site.js', array( 'jquery' ), '', true );


		if(!is_admin()) {
			wp_deregister_script('jquery');
			wp_enqueue_script('jquery', "//ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js", array(), false, true);
		}



		wp_localize_script('site-js', 'wp_ajax', array(
			'url' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('ajax-nonce')
		));

	}



}
