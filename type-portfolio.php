<?php
/*
    Portfolio custom posts.
*/
add_action('init', 'portfolio');

function portfolio() 
{
    $labels = array(
        'name' => _x('Portfolio', 'post type general name'),
        'singular_name' => _x('Project', 'post type singular name'),
        'add_new' => _x('Add New Project', 'news'),
        'add_new_item' => __('Add New Project'),
        'edit_item' => __('Edit Project'),
        'new_item' => __('New Project'),
        'view_item' => __('View Project'),
        'search_items' => __('Search Portfolio'),
        'not_found' =>  __('No Project found'),
        'not_found_in_trash' => __('No Project in Trash'), 
        'parent_item_colon' => ''
      );
      
	$args = array(
    	'labels' => $labels,
    	'public' => true,
    	'show_ui' => true,
    	'capability_type' => 'post',
    	'hierarchical' => true,
        'query_var' => true,
        '_builtin' => false,
    	'supports' => array('title','editor','excerpt','page-attributes','thumbnail'),
    	'taxonomies' => array('post_tag')
    );

	register_post_type( 'portfolio' , $args );
}
/*
    // - end - Portfolio custom posts.
*/
?>