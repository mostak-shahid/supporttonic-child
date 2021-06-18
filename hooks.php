<?php
function add_slug_body_class( $classes ) {
    global $post;
    if ( isset( $post ) AND $post->post_type == 'page' ) {
        $classes[] = $post->post_type . '-' . $post->post_name;
    } else {
        $classes[] = $post->post_type . '-archive';
    }
    return $classes;
}
add_filter( 'body_class', 'add_slug_body_class' );

//add_action( 'astra_template_parts_content', 'mos_author_details_func', 14 );
function mos_author_details_func(){
    if(is_single()) :
    ?>
    <div class="post-autor-details">
        <div class="img-part"><?php echo get_avatar(get_the_author_meta('ID'),120) ?></div>
        <div class="text-part">
            <h4 class="author-name" itemprop="name"><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')) ?>" title="View all posts by <?php echo get_the_author() ?>" rel="author" class="url fn n" itemprop="url"><?php echo get_the_author() ?></a></h4>
            <div class="author-description" itemprop="name"><?php echo get_the_author_meta('description') ?></div>
        </div>
    </div>
    <?php
    endif;
}
add_action('astra_primary_content_bottom','mos_related_posts_func');
function mos_related_posts_func(){
    if(is_single() && get_post_type() == 'post'):
        $term_ids = [];
        $categories = get_the_category(get_the_ID());
        foreach($categories as $category){
            $term_ids[] = $category->term_id;
        }
        //var_dump(implode(',',$term_ids));
        $args = array(
            'posts_per_page' => 6,
            'cat' => implode(',',$term_ids),
            'post__not_in' => array(get_the_ID())
        );
        // The Query
        $the_query = new WP_Query( $args );

        // The Loop
        if ( $the_query->have_posts() ) : ?>
        <div class="related-post">
            <h2 class="section-title"><?php echo __('Related Posts') ?></h2>
            
            <div class="related-post-wrapper">
                <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

                    <div class="post-content">
                        <div class="post-wrapper">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="ast-blog-featured-section post-thumb">
                                    <div class="post-thumb-img-content post-thumb"><a href="<?php echo get_the_permalink() ?>"><img width="373" height="210" src="<?php echo aq_resize(get_the_post_thumbnail_url('','full'), 384, 210, true) ?>" class="attachment-373x250 size-373x250 wp-post-image" alt="office cleaning safety tips - janitorial leads pro" loading="lazy" itemprop="image"></a></div>
                                </div>
                            <?php endif;?>
                            <div class="related-entry-header">
                                <h4 class="related-entry-title" itemprop="headline"><a href="<?php echo get_the_permalink() ?>" rel="bookmark"><?php echo get_the_title() ?></a></h4>
                            </div>
                        </div>
                    </div>       
               
                <?php endwhile; ?>
            </div>
        </div>
        <?php endif;
        /* Restore original Post Data */
        wp_reset_postdata();        
    endif;
}

/**
 * Detect plugin. For use on Front End only.
 */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
 
// check for plugin using plugin name
if ( !is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
    function is_shop(){
        return false;
    }
}

add_action('astra_header_after', 'custom_page_title');
function custom_page_title () {
    $site_post_title = get_post_meta(get_the_ID(), 'site-post-title', true); 
    if($site_post_title != 'disabled'): 
    ?>
        <header id="mos-page-header" class="page-header">
            <h1 class="page-title" itemprop="headline">
                <?php if (is_home()) : ?>
                    <?php echo get_the_title(get_option( 'page_for_posts' )) ?>
                <?php elseif (is_shop()) : ?>
                    <?php echo get_the_title(get_option( 'woocommerce_shop_page_id' )) ?>
                <?php elseif (is_single() || is_page()) : ?>
                    <?php echo get_the_title(get_the_ID()) ?>
                    <?php if (get_post_type() == 'post') : ?>
                    <?php 
                        $astra_options = get_option('astra-settings', true);
                        if (sizeof($astra_options['blog-single-meta'])) {
                            echo '<span class="mos-post-meta header-meta">';
                            foreach($astra_options['blog-single-meta'] as $meta) {
                                echo '<span class="meta-unit meta-'.$meta.'">';
                                //comments/category/author/read-time/date/tag/
                                if ($meta == 'comments') {
                                    comments_number('No Comments', '1 Comment', '% Comments');
                                } elseif ($meta == 'category') {
                                    $categories = get_the_category();
                                    if ( ! empty( $categories ) ) {
                                        $n = 0;
                                        foreach($categories as $category) {
                                            if ($n) echo ', ';
                                            echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a>';
                                            //echo esc_html( $category->name );
                                            $n++;                                                    
                                        }
                                    }
                                    
                                } elseif ($meta == 'author') {
                                    $author_id = get_post_field ('post_author', get_the_ID());
                                    $author_display_name = get_the_author_meta( 'display_name' , $author_id ); 
                                    
                                    echo 'By <a href="'.get_author_posts_url($author_id).'" title="View all posts by '.$author_display_name.'" rel="author" class="url fn n" itemprop="url">'.$author_display_name.'</a>';
                                } elseif ($meta == 'read-time') {
                                    echo mos_calculate_reading_time(get_the_ID());
                                } elseif ($meta == 'date') {
                                    echo '<span class="published">'.get_the_date().'</span>';
                                    echo '<span class="updated">'.get_the_modified_date().'</span>';
                                } elseif ($meta == 'tag') {
                                    $post_tags = get_the_tags(); 
                                    if ( $post_tags ) {
                                        $n = 0;
                                        foreach( $post_tags as $tag ) {        
                                            if ($n) echo ', ';
                                            echo esc_html( $tag->name );
                                            $n++;
                                        }
                                    }  
                                }
                                echo '</span>';
                            }
                            echo '</span>';
                        }
                    ?>
                    <?php endif?>
                <?php elseif (is_author()) : ?>
                    Author Archive: <?php echo get_the_author()?>
                <?php elseif (is_category()) : ?>
                    Category Archive: <?php single_cat_title(); ?>
                <?php elseif (is_tag()) : ?>
                    Tag Archive: <?php single_tag_title(); ?>
                <?php elseif (is_search()) : ?>
                    Search Result for <?php echo get_search_query(); ?>
                <?php elseif (is_404()) : ?>
                    404 Page
                <?php else : ?>
                    Archive Page
                <?php endif;?>
            </h1>
        </header>
    <?php 
    endif;
}

if ( ! function_exists( 'mos_post_classes' ) ) {
	function mos_post_classes( $classes ) {

		if ( is_archive() || is_home() || is_search() ) {
			$classes[] = 'mos-post-block';
		}

		return $classes;
	}
}
add_filter( 'post_class', 'mos_post_classes' );

add_action( 'wp_head', 'add_mos_additional_coding', 999 );
function add_mos_additional_coding() {
    echo carbon_get_theme_option( 'mos_additional_coding' );
}