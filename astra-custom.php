<?php
/**
 * Update the featured images size from Astra
 */
function update_featured_images_size_callback( $size ) {
    if(!is_single()) $size = array( 373, 250 ); // Update the 500(Width), 500(Height) as per your requirment.
	return $size;
}
//add_filter( 'astra_post_thumbnail_default_size', 'update_featured_images_size_callback' ); 
if ( ! function_exists( 'mos_post_class_blog_grid' ) ) {
	function mos_post_class_blog_grid( $classes ) {

		if ( is_archive() || is_home() || is_search() ) {
			$classes[] = 'ast-col-md-4';
		}

		return $classes;
	}
}
//add_filter( 'post_class', 'mos_post_class_blog_grid' );

// Update your custom tablet breakpoint below - like return 992;
add_filter( 'astra_tablet_breakpoint', function() {
    return 992;
});
// Update your custom mobile breakpoint below - like return 768px;
add_filter( 'astra_mobile_breakpoint', function() {
    return 768;
});


/*add_filter( 'astra_post_minute_of_reading_text', 'ast_post_minute_of_reading_text_function' );
function ast_post_minute_of_reading_text_function() {
    return __( 'Singular reading time...', 'astra-addon' );
}


add_filter( 'astra_post_minutes_of_reading_text', 'ast_post_minutes_of_reading_text_function' );
function ast_post_minutes_of_reading_text_function() {
    return __( 'Plural reading time...', 'astra-addon' );
}*/