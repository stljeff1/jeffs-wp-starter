<?php


class JW_Site extends Timber\Site {

	public function __construct() {

		add_action( 'after_setup_theme', array( $this, 'theme_supports' ) );
		add_action( 'init', array( $this, 'register_post_types'));

		$this->hooks();

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

	public function site_scripts_and_styles() {

		$build_dir = '/build/';
		$styles = (WP_ENV == 'production') ? 'site.min.css' : 'site.css';
		$site_css_time = 'v' . filemtime(THEME_DIR . $build_dir . $styles);

		debug_print(array($build_dir, $styles));


		wp_enqueue_style('site', THEME_URI . $build_dir . $styles, array(), $site_css_time);

		wp_enqueue_script( 'site-js', get_stylesheet_directory_uri() . '/build/main.js', array( 'jquery' ), '', true );


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
