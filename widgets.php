<?php
function tom_Register_Widgets()
{
    // default set of settings (I want them all the same)
    $settings = array(
        'name' => 'Home Top Left',
        'id' => 'home_top_left',
        'before_widget' => '<div class="widget">',
        'after_widget' => '</div>',
        'before_title' => '<h2>',
        'after_title' => '</h2>',
    );

    // different widget areas which I want to register.
    $widgets = array(
        'Home Top Left'
        ,'Home Bottom Left'
        ,'Home Top Middle'
        ,'Home Bottom Middle'
        ,'Home Top Right'
        ,'Home Bottom Right'
    );

    // whizz through and register all the widget areas.
    foreach($widgets as $w)
    {
        $name = $w;
        $id = str_replace(' ','_',strtolower($w));
        $settings['name'] = $name;
        $settings['id'] = $id;
        register_sidebar($settings);
    }    
}
add_action( 'widgets_init','tom_Register_Widgets');

function tomWidget_Remove_Unwanted()
{
    unregister_widget( 'WP_Widget_Archives' );
    unregister_widget( 'WP_Widget_Calendar' );
    unregister_widget( 'WP_Widget_Categories' );
    unregister_widget( 'WP_Nav_Menu_Widget' );
    unregister_widget( 'WP_Widget_Links' );
    unregister_widget( 'WP_Widget_Meta' );
    unregister_widget( 'WP_Widget_Pages' );
    unregister_widget( 'WP_Widget_Recent_Comments' );
    unregister_widget( 'WP_Widget_Recent_Posts' );
    unregister_widget( 'WP_Widget_RSS' );
    unregister_widget( 'WP_Widget_Search' );
    unregister_widget( 'WP_Widget_Tag_Cloud' );
    // unregister_widget( 'WP_Widget_Text' );
}
add_action( 'widgets_init','tomWidget_Remove_Unwanted);

?>