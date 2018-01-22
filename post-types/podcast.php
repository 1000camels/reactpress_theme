<?php

function podcast_init() {
	register_post_type( 'podcast', array(
		'labels'            => array(
			'name'                => __( 'Podcasts', 'twentyseventeen' ),
			'singular_name'       => __( 'Podcast', 'twentyseventeen' ),
			'all_items'           => __( 'All Podcasts', 'twentyseventeen' ),
			'new_item'            => __( 'New Podcast', 'twentyseventeen' ),
			'add_new'             => __( 'Add New', 'twentyseventeen' ),
			'add_new_item'        => __( 'Add New Podcast', 'twentyseventeen' ),
			'edit_item'           => __( 'Edit Podcast', 'twentyseventeen' ),
			'view_item'           => __( 'View Podcast', 'twentyseventeen' ),
			'search_items'        => __( 'Search Podcasts', 'twentyseventeen' ),
			'not_found'           => __( 'No Podcasts found', 'twentyseventeen' ),
			'not_found_in_trash'  => __( 'No Podcasts found in trash', 'twentyseventeen' ),
			'parent_item_colon'   => __( 'Parent Podcast', 'twentyseventeen' ),
			'menu_name'           => __( 'Podcasts', 'twentyseventeen' ),
		),
		'public'            => true,
		'hierarchical'      => false,
		'show_ui'           => true,
		'show_in_nav_menus' => true,
		'supports'          => array( 'title', 'editor' ),
		'has_archive'       => true,
		'rewrite'           => true,
		'query_var'         => true,
		'menu_icon'         => 'dashicons-admin-post',
		'show_in_rest'      => true,
		'rest_base'         => 'podcast',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
	) );

}
add_action( 'init', 'podcast_init' );

function podcast_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['podcast'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => sprintf( __('Podcast updated. <a target="_blank" href="%s">View Podcast</a>', 'twentyseventeen'), esc_url( $permalink ) ),
		2 => __('Custom field updated.', 'twentyseventeen'),
		3 => __('Custom field deleted.', 'twentyseventeen'),
		4 => __('Podcast updated.', 'twentyseventeen'),
		/* translators: %s: date and time of the revision */
		5 => isset($_GET['revision']) ? sprintf( __('Podcast restored to revision from %s', 'twentyseventeen'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Podcast published. <a href="%s">View Podcast</a>', 'twentyseventeen'), esc_url( $permalink ) ),
		7 => __('Podcast saved.', 'twentyseventeen'),
		8 => sprintf( __('Podcast submitted. <a target="_blank" href="%s">Preview Podcast</a>', 'twentyseventeen'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		9 => sprintf( __('Podcast scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Podcast</a>', 'twentyseventeen'),
		// translators: Publish box date format, see http://php.net/date
		date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		10 => sprintf( __('Podcast draft updated. <a target="_blank" href="%s">Preview Podcast</a>', 'twentyseventeen'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'podcast_updated_messages' );

flush_rewrite_rules( false );
