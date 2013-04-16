<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * You can add an optional custom header image to header.php like so ...

	<?php $header_image = get_header_image();
	if ( ! empty( $header_image ) ) { ?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
			<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />
		</a>
	<?php } // if ( ! empty( $header_image ) ) ?>

 *
 * @package Buttercream
 * @since Buttercream 1.0
 */

/**
 * Setup the WordPress core custom header feature.
 *
 * Use add_theme_support to register support for WordPress 3.4+
 * as well as provide backward compatibility for previous versions.
 * Use feature detection of wp_get_theme() which was introduced
 * in WordPress 3.4.
 *
 * @uses buttercream_header_style()
 * @uses buttercream_admin_header_style()
 * @uses buttercream_admin_header_image()
 *
 * @package Buttercream
 */
function buttercream_custom_header_setup() {

	$options = buttercream_get_theme_options();
	$style = $options['theme_style'];

	$defaults = buttercream_get_layout_defaults();

	if( isset( $style ) && '' == $style || false == $style )
		$style = 'cupcake';

	$args = array(
		'default-image'          => $defaults['default-header-image'],
		'default-text-color'     => $defaults['default-color'],
		'width'                  => 850,
		'height'                 => 265,
		'flex-height'            => true,
		'wp-head-callback'       => 'buttercream_header_style',
		'admin-head-callback'    => 'buttercream_admin_header_style',
		'admin-preview-callback' => 'buttercream_admin_header_image',
	);

	$args = apply_filters( 'buttercream_custom_header_args', $args );

	if ( function_exists( 'wp_get_theme' ) ) {
		add_theme_support( 'custom-header', $args );
	} else {
		// Compat: Versions of WordPress prior to 3.4.
		define( 'HEADER_TEXTCOLOR',    $args['default-text-color'] );
		define( 'HEADER_IMAGE',        $args['default-image'] );
		define( 'HEADER_IMAGE_WIDTH',  $args['width'] );
		define( 'HEADER_IMAGE_HEIGHT', $args['height'] );
		add_custom_image_header( $args['wp-head-callback'], $args['admin-head-callback'], $args['admin-preview-callback'] );
	}

	// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
	register_default_headers( array(
		'cupcake' => array(
			'url'           => '%s/img/cupcake.png',
			'thumbnail_url' => '%s/img/cupcake-thumb.png',
			'description'   => __( 'Confetti', 'buttercream' )
		),
		'yellow' => array(
			'url'           => '%s/img/yellow.png',
			'thumbnail_url' => '%s/img/yellow-thumb.png',
			'description'   => __( 'Chocolate Orange', 'buttercream' )
		),
		'red' => array(
			'url'           => '%s/img/red.png',
			'thumbnail_url' => '%s/img/red-thumb.png',
			'description'   => __( 'Red Velvet', 'buttercream' )
		)
	) );
}
add_action( 'after_setup_theme', 'buttercream_custom_header_setup' );

/**
 * Shiv for get_custom_header().
 *
 * get_custom_header() was introduced to WordPress
 * in version 3.4. To provide backward compatibility
 * with previous versions, we will define our own version
 * of this function.
 *
 * @return stdClass All properties represent attributes of the curent header image.
 *
 * @package Buttercream
 * @since Buttercream 1.1
 */

if ( ! function_exists( 'get_custom_header' ) ) {
	function get_custom_header() {
		return (object) array(
			'url'           => get_header_image(),
			'thumbnail_url' => get_header_image(),
			'width'         => HEADER_IMAGE_WIDTH,
			'height'        => HEADER_IMAGE_HEIGHT,
		);
	}
}

if ( ! function_exists( 'buttercream_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see buttercream_custom_header_setup().
 *
 * @since Buttercream 1.0
 */
function buttercream_header_style() {

	// If no custom options for text are set, let's bail
	// get_header_textcolor() options: HEADER_TEXTCOLOR is default, hide text (returns 'blank') or any hex value
	if ( HEADER_TEXTCOLOR == get_header_textcolor() )
		return;
	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( 'blank' == get_header_textcolor() ) :
	?>
		.site-title,
		.site-description {
			position: absolute !important;
			clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that
		else :
	?>
		.site-title a,
		.site-description {
			color: #<?php echo get_header_textcolor(); ?> !important;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // buttercream_header_style

if ( ! function_exists( 'buttercream_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @see buttercream_custom_header_setup().
 *
 * @since Buttercream 1.0
 */
function buttercream_admin_header_style() {

	$defaults = buttercream_get_layout_defaults();

?>
	<style type="text/css">
	.appearance_page_custom-header #headimg {
		border: none;
	}
	#headimg h1,
	#desc {
	}
	#headimg h1 {
		clear: both;
		font-family: Norican, sans-serif;
		font-size: 48px;
		font-weight: normal;
		line-height: normal;
		margin: 0px;
		text-align: center;
	}
	#headimg h1 a {
		text-decoration: none;
	}
	#desc {
		clear: both;
		color: #<?php echo $defaults['default-description-color']; ?>;
		font-family: "Stint Ultra Condensed", serif;
		font-size: 30px;
		line-height: normal;
		margin: -10px 0px 20px 0px;
		text-align: center;
	}
	#headimg img {
		display: block;
		margin: 0 auto;
	}
	</style>
<?php
}
endif; // buttercream_admin_header_style

if ( ! function_exists( 'buttercream_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @see buttercream_custom_header_setup().
 *
 * @since Buttercream 1.0
 */
function buttercream_admin_header_image() { ?>
	<div id="headimg">
		<?php $header_image = get_header_image();
		if ( ! empty( $header_image ) ) : ?>
			<img src="<?php echo esc_url( $header_image ); ?>" alt="" />
		<?php endif; ?>
		<?php
		if ( 'blank' == get_theme_mod( 'header_textcolor', HEADER_TEXTCOLOR ) || '' == get_theme_mod( 'header_textcolor', HEADER_TEXTCOLOR ) )
			$style = ' style="display:none;"';
		else
			$style = ' style="color:#' . get_theme_mod( 'header_textcolor', HEADER_TEXTCOLOR ) . ';"';
		?>
		<h1><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		<div id="desc"<?php echo $style; ?>><?php bloginfo( 'description' ); ?></div>
	</div>
<?php }
endif; // buttercream_admin_header_image