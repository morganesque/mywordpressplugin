<?php

add_action( 'admin_menu', 'change_post_menu_label' );
function change_post_menu_label() 
{
    global $menu;
    global $submenu;

    $menu[5][0] = 'Blog';
    $submenu['edit.php'][5][0] = 'Posts';
    $submenu['edit.php'][10][0] = 'Add Post';

    $tmp = $menu[20]; unset($menu[20]); $menu[4] = $tmp;
    $tmp = $menu[26]; unset($menu[26]); $menu[6] = $tmp;
    $tmp = $menu[101]; unset($menu[101]); $menu[1] = $tmp;

    $categories = array(
        'Categories'
        ,'manage_categories'
        ,'edit-tags.php?taxonomy=category'
        ,''
        ,'open-if-no-js menu-top menu-icon-generic'
        );

    $menu[9] = $categories;

    // PreDump($submenu);die;
    echo '';
}

add_action( 'admin_menu', 'my_remove_menu_pages' );
function my_remove_menu_pages() 
{
    remove_menu_page('index.php');              // Dashboard
    remove_menu_page('link-manager.php');       // Links
    remove_menu_page('tools.php');              // Tools
    remove_menu_page('edit-comments.php');      // Comments
    remove_menu_page('themes.php');             // Appearance
    remove_menu_page('plugins.php');             // Appearance
    // remove_menu_page('edit.php');            // Posts
}

/*
// Change the Posts to be called News.
add_action( 'admin_menu', 'change_post_menu_label' );
function change_post_menu_label() {
	global $menu;
	global $submenu;
	$menu[5][0] = 'News';
	$submenu['edit.php'][5][0] = 'News';
	$submenu['edit.php'][10][0] = 'Add News';
    unset($submenu['edit.php'][15]); 
    unset($submenu['edit.php'][16]); //[0] = 'News Tags';
	echo '';
}

// Change the Posts to be called News.
add_action( 'init', 'change_post_object_label' );
function change_post_object_label() {
	global $wp_post_types;
	$labels = &$wp_post_types['post']->labels;
	$labels->name = 'News';
	$labels->singular_name = 'News';
	$labels->add_new = 'Add News';
	$labels->add_new_item = 'Add News';
	$labels->edit_item = 'Edit News';
	$labels->new_item = 'News';
	$labels->view_item = 'View News';
	$labels->search_items = 'Search News';
	$labels->not_found = 'No News found';
	$labels->not_found_in_trash = 'No News found in Trash';
}
*/

?>