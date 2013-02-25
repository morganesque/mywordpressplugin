<?php

include_once( TOM_PATH . 'meta-class.php');

class AllProjects extends TM_MetaBox {

    private $slug = 'all_projects';
    
    public function __construct()
    {
        add_action('add_meta_boxes', array(&$this, 'init_meta_box'));
    }
    
    public function init_meta_box()
    {       
        $slug       = $this->slug; //slug / html ID
        $boxlabel  = 'Other Projects'; // label of the box
        $callback   = array(&$this, 'render_meta_box'); // callback function
        $posttype  = 'portfolio'; // which post-type to show it on
        $where      = 'side'; // where in the ui ('normal','advanced','side')
        $priority   = 'high'; // priority ('high','low')

        add_meta_box($slug,$boxlabel,$callback,$posttype,$where,$priority);
    }
    
    public function render_meta_box($post)
    {
        $data = get_posts(array(''
           ,'post_type' => 'portfolio'
           ,'posts_per_page' => 100
           ,'orderby' => 'menu_order'
           ,'order' => 'ASC'
        ));
        
        echo '<select onchange="window.location.href = (this.value);">';
        foreach($data as $d)
        {
            $s = ''; if ($d->ID == $post->ID) $s = ' selected="selected"';
            echo '<option value="post.php?post='.$d->ID.'&action=edit"'.$s.'>'.$d->post_title.'</option>';
        }
        echo '</select>';
    }
}

$pju = new AllProjects();

?>