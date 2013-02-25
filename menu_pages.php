<?php

add_action( 'admin_menu', 'my_remove_menu_pages' );

function my_remove_menu_pages() 
{
    remove_menu_page('index.php');              // Dashboard
	remove_menu_page('link-manager.php');       // Links
    remove_menu_page('tools.php');              // Tools
    remove_menu_page('edit-comments.php');      // Comments
    remove_menu_page('edit.php');               // Posts
}

?>