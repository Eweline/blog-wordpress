<?php
/**
 * Buttercream functions and definitions
 *
 * @package Buttercream
 * @since Buttercream 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Buttercream 1.0
 */
if ( ! isset( $content_width ) )
	$content_width = 740; /* pixels */

if ( ! function_exists( 'buttercream_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since Buttercream 1.0
 */
function buttercream_setup() {

	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );

	/**
	 * Custom functions that act independently of the theme templates
	 */
	require( get_template_directory() . '/inc/tweaks.php' );

	/**
	 * Custom Theme Options
	 */
	require( get_template_directory() . '/inc/theme-options/theme-options.php' );

	/**
	 * WordPress.com-specific functions and definitions
	 */
	//require( get_template_directory() . '/inc/wpcom.php' );

	/* Jetpack Infinite Scroll */
	add_theme_support( 'infinite-scroll', array(
		'container'  => 'content',
		'footer'     => 'page',
		'footer_widgets' => true //Buttercream's custom menu resides at the bottom of the screen, therefore we will not scroll infinitely
	) );

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on Buttercream, use a find and replace
	 * to change 'buttercream' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'buttercream', get_template_directory() . '/languages' );

	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'headermenu' => __( 'Header Menu', 'buttercream' ),
	) );

	/**
	 * Add support for Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', 'gallery', 'image', 'audio', 'video', 'status', 'quote', 'link', 'chat' ) );

	/**
	* Add support for editor style
	*/
	add_editor_style();

	/**
	* Add support for post thumbs
	*/
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 300, 300, true );

	/**
	 * Add support for custom backgrounds
	 */
	$args = array(
		'default-color' => '',
		'default-image' => get_template_directory_uri() . '/img/background.png',
	);

	$args = apply_filters( 'buttercream_custom_background_args', $args );

	if ( function_exists( 'wp_get_theme' ) ) {
		add_theme_support( 'custom-background', $args );
	}
	else {
		define( 'BACKGROUND_COLOR', $args['default-color'] );
		define( 'BACKGROUND_IMAGE', $args['default-image'] );
		add_custom_background();
	}

}
endif; // buttercream_setup
add_action( 'after_setup_theme', 'buttercream_setup' );

/* Filter to add author credit to Infinite Scroll footer */
function buttercream_footer_credits( $credit ) {
	$credit = sprintf( __( '%3$s | Theme: %1$s by %2$s.', 'buttercream' ), 'Buttercream', '<a href="http://carolinemoore.net/" rel="designer">Caroline Moore</a>', '<a href="http://wordpress.org/" title="' . esc_attr( __( 'A Semantic Personal Publishing Platform', 'buttercream' ) ) . '" rel="generator">Proudly powered by WordPress</a>' );
	return $credit;
}
add_filter( 'infinite_scroll_credit', 'buttercream_footer_credits' );

/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since Buttercream 1.0
 */
function buttercream_widgets_init() {

	register_sidebar( array(
		'id' => 'first-sidebar',
		'name' => __( 'First Sidebar' , 'buttercream' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>'
		)
	);

	register_sidebar( array(
		'id' => 'second-sidebar',
		'name' => __( 'Second Sidebar' , 'buttercream' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>'
		)
	);

	register_sidebar( array(
		'id' => 'third-sidebar',
		'name' => __( 'Third Sidebar' , 'buttercream' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>'
		)
	);
}
add_action( 'widgets_init', 'buttercream_widgets_init' );


/**
 * Enqueue Google fonts in admin for custom header
 */
function buttercream_admin_styles() {
	wp_enqueue_style( 'buttercream-googlefonts', 'http://fonts.googleapis.com/css?family=Norican|Alegreya:400italic,700italic,400,700|Stint+Ultra+Condensed' );
}
add_action( 'admin_enqueue_scripts', 'buttercream_admin_styles' );


/**
 * Enqueue scripts and styles
 */
function buttercream_scripts() {
	global $post;

	$buttercream_options = get_option('buttercream_theme_options');
	$buttercream_customcss = $buttercream_options['custom_css'];

	wp_enqueue_style( 'googlefonts', 'http://fonts.googleapis.com/css?family=Norican|Alegreya:400italic,700italic,400,700|Stint+Ultra+Condensed' );

	// Enqueue color and layout CSS for IE < 9 in conditional tags
	$GLOBALS['wp_styles']->add_data( 'mediaie', 'conditional', 'lt IE 9' );
	wp_enqueue_style( 'mediaie', get_template_directory_uri() . '/layouts/ie.css', 'media-css' );

	wp_enqueue_style( 'style', get_stylesheet_uri() );

	wp_enqueue_script( 'jquery' );

	wp_enqueue_script( 'small-menu', get_template_directory_uri() . '/js/small-menu.js', array( 'jquery' ), '20120206', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image( $post->ID ) ) {
		wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}

	if ( $buttercream_customcss ) {
		echo "<style type='text/css'>";
		echo $buttercream_customcss;
		echo "</style>";
	}

}
add_action( 'wp_enqueue_scripts', 'buttercream_scripts' );


//Check if any of the three default headers are being used
function buttercream_is_a_default_header() {

	$buttercream_styles = buttercream_theme_style();
	$buttercream_default_headers = array();
	$buttercream_header_image = get_header_image();

	foreach ( $buttercream_styles as $buttercream_style ) {

		$buttercream_default_headers[] = $buttercream_style['defaults']['default-header-image'];

	}

	if ( empty( $buttercream_header_image ) || ! in_array( $buttercream_header_image, $buttercream_default_headers ) )
		return false;

	return true;

}

//Add styles for the alternative default headers if we're using one

function buttercream_alternate_default_headers() {

	$buttercream_current_header = get_header_image();
	$buttercream_current_header_style = basename( $buttercream_current_header, '.png' );

	if ( isset( $buttercream_current_header_style ) && true == buttercream_is_a_default_header() ) {

	?>

<style type="text/css">
	#header-imagesm {
		background-image:url('<?php echo get_template_directory_uri(); ?>/img/<?php echo $buttercream_current_header_style; ?>-sm.png');
	}
	.bluebar {
		background-image:url('<?php echo get_template_directory_uri(); ?>/img/bar-<?php echo $buttercream_current_header_style; ?>.png');
	}

	@media only screen and (-moz-min-device-pixel-ratio: 1.5), only screen and (-o-min-device-pixel-ratio: 3/2), only screen and (-webkit-min-device-pixel-ratio: 1.5), only screen and (min-device-pixel-ratio: 1.5) {

		#header-image img {
			background-image:url('<?php echo get_template_directory_uri(); ?>/img/<?php echo $buttercream_current_header_style; ?>@2x.png');
			background-repeat: no-repeat;
			background-size: 850px 265px;
			padding-right: 9999px;
			background-position: 9999px;
			margin-left: -9999px;
		}

		#header-imagesm {
			background-image:url('<?php echo get_template_directory_uri(); ?>/img/<?php echo $buttercream_current_header_style; ?>-sm@2x.png');
			background-size: 200px auto;
		}
	}
</style>

<?php }
	else {
		$buttercream_options = buttercream_get_theme_options();
		$buttercream_style = $buttercream_options['theme_style'];
?>

	<style type="text/css">
	#header-imagesm {
		background-image:url('<?php echo get_template_directory_uri(); ?>/img/<?php echo $buttercream_style; ?>-sm.png');
	}
	.bluebar {
		background-image:url('<?php echo get_template_directory_uri(); ?>/img/bar-<?php echo $buttercream_style; ?>.png');
	}
	</style>
	<?php }

}

add_action( 'wp_head', 'buttercream_alternate_default_headers' );

function buttercream_head() { ?>

	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
	<![endif]-->

<?php
}

add_action( 'wp_head', 'buttercream_head', 1 );

/**
 * Implement the Custom Header feature
 */
require( get_template_directory() . '/inc/custom-header.php' );

/**
 * Add support for Theme Options in the Customizer
 */

function buttercream_customize_register( $wp_customize ) {

	$wp_customize->add_section( 'buttercream_theme_options', array(
		'title'		=> __( 'Theme Options', 'buttercream' ),
		'priority'	=> 35,
		'transport'	=> 'postMessage',
	) );

	$wp_customize->add_setting( 'buttercream_theme_options[theme_style]', array(
		'default'		=> 'cupcake',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
	) );

	$wp_customize->add_control( 'buttercream_theme_style', array(
		'label'		=> __( 'Theme Style', 'buttercream' ),
		'section'	=> 'buttercream_theme_options',
		'settings'	=> 'buttercream_theme_options[theme_style]',
		'type'		=> 'select',
		'choices'	=> array(
						'cupcake' => __( 'Confetti', 'buttercream' ),
						'yellow' => __( 'Chocolate Orange', 'buttercream' ),
						'red' => __( 'Red Velvet', 'buttercream' ),
						),
	) );

}

add_action( 'customize_register', 'buttercream_customize_register' );