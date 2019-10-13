<?php

class MyEnqueues {

	
	const BUILD_DIR = '/build/theme/';
	private $build_dir = self::BUILD_DIR;
	private $build_styles = self::BUILD_DIR . 'site.css';
	private $build_scripts = self::BUILD_DIR . 'main.js';

	public function __construct() {

		// SCRIPTS AND STYLES
		// add_action( 'admin_enqueue_scripts', 'add_admin_styles' );
		add_action('wp_enqueue_scripts', array($this, 'start'), 10);
	}

	public function start() {
		$this->jquery();
		$this->googleFonts();
		$this->fontawesome();
		$this->site();

	}

	function jquery() {

			wp_deregister_script('jquery');
			wp_enqueue_script('jquery', "//ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js", array(), false, true);
	}

	function googleFonts() {
		wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Open+Sans:400,600,700|Roboto+Slab:100,700');
	}

	function fontawesome() {
		wp_enqueue_style('font-awesome', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css');
	}


	function site() {


		$styles = (WP_ENV == 'production') ? 'site.min.css' : 'site.css';
		$site_css_time = 'v' . filemtime(THEME_DIR . $this->build_dir . $styles);

		//debug_print(array($build_dir, $styles));


		wp_enqueue_style('site', THEME_URI . $this->build_dir . $styles, array(), $site_css_time);

		wp_enqueue_script( 'site-js', THEME_URI . $this->build_scripts, array( 'jquery' ), '', true );



		wp_localize_script('site-js', 'wp_ajax', array(
			'url' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('ajax-nonce')
		));

	}

}

class JW_Site extends Timber\Site {

	public function __construct() {

		add_action( 'after_setup_theme', array( $this, 'theme_supports' ) );
		add_action( 'init', array( $this, 'register_post_types'));


		new MyEnqueues();

		$this->hooks();

		parent::__construct();

	}

	function hooks() {

		add_filter( 'timber/context', array( $this, 'add_to_context' ) );
		add_filter( 'timber/twig', array( $this, 'add_to_twig' ) );






	}

	function theme_supports() {

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */

		add_theme_support( 'post-thumbnails' );
		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */

		add_theme_support(
			'html5', array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		add_theme_support(
			'post-formats', array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
				'gallery',
				'audio',
			)
		);
		add_theme_support( 'menus' );
	}

	function register_post_types() {

	}

	function add_to_context($context) {

		$context['foo'] = 'bar';
		$context['container_class'] = 'grid-container';
		$context['menu'] = new Timber\Menu();
		return $context;
	}

	function add_to_twig($twig) {

		// $twig->addExtension( new Twig_Extension_StringLoader() );
		// $twig->addFilter( new Twig_SimpleFilter( 'myfoo', array( $this, 'myfoo' ) ) );
		// $twig->addFilter( new Twig_SimpleFilter( 'my_excerpt', array( $this, 'my_post_excerpt' ) ) );
		return $twig;
	}





}
