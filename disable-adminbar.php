<?php

if (!is_admin())
{
    wp_deregister_script('admin-bar');
    wp_deregister_style('admin-bar');

    add_theme_support('admin-bar', array('callback' => '__return_false'));

    $c = current_theme_supports( 'admin-bar' ); // PreDump($c);

    // $r = remove_theme_support('admin-bar'); PreDump($r);

    $r = remove_action('wp_footer','wp_admin_bar_render',1000); // PreDump($r);
    remove_action('wp_head','wp_admin_bar_header',1000);
    
    //     
    // $default_header_callback = '_admin_bar_bump_cb';
    // $r = remove_action('wp_head', $default_header_callback);    
}

?>