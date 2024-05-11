<?php
namespace Flux;

use FluxDigital\Assets;

class Loader {
	public function __construct() {
		add_action( 'after_setup_theme', [ $this, 'setup' ] );
		add_action( 'widgets_init', [ $this, 'widgets_init' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_assets' ] );

	}

	public function setup() {
		load_theme_textdomain( 'bat-dong-san', get_template_directory() . '/languages' );

		register_nav_menus( [ 
			'primary'  => esc_html__( 'Primary Menu', 'bat-dong-san' ),
			'footer-1' => esc_html__( 'Footer 1', 'bat-dong-san' ),
			'footer-2' => esc_html__( 'Footer 2', 'bat-dong-san' ),
		] );

		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'html5', [ 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script' ] );

		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'custom-logo' );
		add_theme_support( 'responsive-embeds' );
	}

	public function widgets_init() {
		register_sidebar(
			[ 
				'name'          => esc_html__( 'Sidebar', 'bat-dong-san' ),
				'id'            => 'sidebar-1',
				'before_widget' => '<aside class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			],
		);
		register_sidebar(
			[ 
				'name'          => esc_html__( 'Footer 1', 'jymec_theme' ),
				'id'            => 'footer-1',
				'before_widget' => '<aside class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<p class="widget-title">',
				'after_title'   => '</p>',
			],
		);
		register_sidebar(
			[ 
				'name'          => esc_html__( 'Footer 2', 'jymec_theme' ),
				'id'            => 'footer-2',
				'before_widget' => '<aside class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<p class="widget-title">',
				'after_title'   => '</p>',
			],
		);
		// register_widget('\Flux\Widgets\RecentPosts');
	}

	public function enqueue_assets() {
		wp_enqueue_style( 'bat-dong-san', get_stylesheet_uri(), [], filemtime( get_template_directory() . '/style.css' ) );
		Assets::js( 'script', [ 'jquery' ] );
		Assets::js( 'filter', [ 'jquery' ], [ 'url' => admin_url( 'admin-ajax.php' ) ] );

		// Thêm style cho template
		if ( is_front_page() ) {
			Assets::css( 'home', true );
		}
		if ( is_singular( 'post' ) ) {
			Assets::css( 'single', true );
		}
		if ( is_home() || is_archive() || is_search() ) {
			Assets::css( 'archive', true );
		}
		if ( is_singular( 'nha-dat-mua-ban' ) ) {
			Assets::css( 'single-bds', true );
			Assets::css( 'lightslider', true );
			Assets::js( 'lightslider', [ 'jquery' ] );
			Assets::js( 'gallery', [ 'jquery' ] );
		}
	}

}
