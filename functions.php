<?php

/**
 * Load Styles
 */
function reactpress_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

}
add_action( 'wp_enqueue_scripts', 'reactpress_enqueue_styles' );

/**
 * Register Custom Post Types
 */
function register_custom_posts_init() {
    // Register Podcast
    $podcasts_labels = array(
        'name'               => 'Podcasts',
        'singular_name'      => 'Podcast',
        'menu_name'          => 'Podcasts'
    );
    $podcasts_args = array(
        'labels'             => $podcasts_labels,
        'public'             => true,
        'capability_type'    => 'post',
        'has_archive'        => true,
        'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' )
    );
    register_post_type('podcast', $podcasts_args);
}
//add_action('init', 'register_custom_posts_init');

include( 'post-types/podcast.php' );


/**
 * Add custom content to feed
 */
function feedContentFilter($item) {
	
	global $post;
	
	$enclosure_url = get_field('enclosure_url');
	$enclosure_length = get_field('enclosure_length');
	$enclosure_type = get_field('enclosure_type');

	if ($enclosure_url) {
		echo '<enclosure url="'.$enclosure_url.'" length="'.$enclosure_length.'" type="'.$enclosure_type.'"/>'."\n";
	} 
	return $item;
}

/**
 * Adjust RSS2 feed
 */
// function feedFilter($query) {
// 	if ($query->is_feed) {
// 		add_filter('rss2_item', 'feedContentFilter');
// 	}
// 	return $query;
// }
// add_filter('pre_get_posts','feedFilter');

// /**
//  * Add custom RSS template for Podcast.
//  */
// function reactpress_rss() {
// 	if ( 'podcast' === get_query_var( 'post_type' ) ) {
// 		get_template_part( 'feed', 'podcast' );
// 	} else {
// 		get_template_part( 'feed', 'rss2' );
// 	}
// }
// remove_all_actions( 'do_feed_rss2' );
// add_action( 'do_feed_rss2', 'reactpress_rss', 10, 1 );


/**
 * Add new feed
 */
function podcast_template() {
    add_feed( 'podcast', 'podcast_rss_render' );
}
add_action( 'init', 'podcast_template' );

/**
 * Render feed
 */
function podcast_rss_render() {
    header( 'Content-Type: application/rss+xml' );
    get_template_part( 'feed', 'podcast' );
}



/**
 * Define feed 
 */
function podcast_rss_url( $output, $show ) {
    if (in_array($show, array('rss_url', 'rss2_url', 'rss', 'rss2', '')))
    $output = site_url() . '/podcast';
    return $output; 
}
// add_filter('bloginfo_url', 'podcast_rss_url', 10, 2);
// add_filter('feed_link', 'podcast_rss_url', 10, 2);
