<?php
/**
 * Astra Child Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Astra Child
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define( 'CHILD_THEME_ASTRA_CHILD_VERSION', '1.0.0' );


require_once('theme-init/plugin-update-checker.php');
$themeInit = Puc_v4_Factory::buildUpdateChecker(
	'https://raw.githubusercontent.com/mostak-shahid/update/master/supporttonic-child.json',
	__FILE__,
	'supporttonic-child'
);
/**
 * Enqueue styles
 */
function child_enqueue_styles() {
    wp_enqueue_script('jquery');
    wp_enqueue_style( 'fancybox', get_stylesheet_directory_uri() . '/plugins/fancybox/jquery.fancybox.min.css' );
    wp_enqueue_script('fancybox', get_stylesheet_directory_uri() . '/plugins/fancybox/jquery.fancybox.min.js', 'jquery');
    
    wp_enqueue_style( 'BeerSlider', get_stylesheet_directory_uri() . '/plugins/BeerSlider/BeerSlider.css' );
    wp_enqueue_script('BeerSlider', get_stylesheet_directory_uri() . '/plugins/BeerSlider/BeerSlider.js', 'jquery');
    
    wp_enqueue_script('jquery.waypoints.min', get_stylesheet_directory_uri() . '/plugins/jquery.counterup/jquery.waypoints.min.js', 'jquery');
    wp_enqueue_script('jquery.counterup', get_stylesheet_directory_uri() . '/plugins/jquery.counterup/jquery.counterup.js', 'jquery');
    
    wp_enqueue_style( 'font-awesome.min', get_stylesheet_directory_uri() . '/fonts/font-awesome-4.7.0/css/font-awesome.min.css' );
    
	wp_enqueue_style( 'fonts-theme-css', get_stylesheet_directory_uri() . '/fonts/fonts.css');
	wp_enqueue_style( 'astra-child-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css','fonts-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all' );
    wp_enqueue_script('script', get_stylesheet_directory_uri() . '/script.js', 'jquery');

}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );
function mos_calculate_reading_time( $post_id ) {

    $post_content       = get_post_field( 'post_content', $post_id );
    $stripped_content   = strip_shortcodes( $post_content );
    $strip_tags_content = wp_strip_all_tags( $stripped_content );
    $word_count         = count( preg_split( '/\s+/', $strip_tags_content ) );
    $reading_time       = ceil( $word_count / 220 );

    return $reading_time .' minutes of reading';
}
require_once 'aq_resizer.php';
require_once 'astra-custom.php';
require_once 'hooks.php';
require_once 'shortcodes.php';
require_once 'carbon-fields.php';
require_once 'woo-functions.php';