<?php
/*
    Remove a load of things from pages and posts which I don't need.
*/
add_action('init', 'change_post_type_supports');
function change_post_type_supports()
{
    remove_post_type_support('post', 'excerpt');
    remove_post_type_support('post', 'author');
    remove_post_type_support('post', 'trackbacks');
    remove_post_type_support('post', 'custom-fields');
    remove_post_type_support('post', 'comments');
    remove_post_type_support('post', 'revisions');
    
    remove_post_type_support('page', 'author');
    remove_post_type_support('page', 'custom-fields');
    remove_post_type_support('page', 'comments');
    remove_post_type_support('page', 'revisions');
}
?>