<?php

include_once( TOM_PATH . 'meta-class.php');

class ProjectURL extends TM_MetaBox {

    private $slug = 'project_url';
    
    public function __construct()
    {
        add_action('add_meta_boxes', array(&$this, 'init_meta_box'));
        add_action('save_post', array(&$this, 'save_meta_box')); 
    }
    
    public function init_meta_box()
    {       
        $slug       = $this->slug; //slug / html ID
        $boxlabel  = 'URL of the website'; // label of the box
        $callback   = array(&$this, 'render_meta_box'); // callback function
        $posttype  = 'portfolio'; // which post-type to show it on
        $where      = 'normal'; // where in the ui ('normal','advanced','side')
        $priority   = 'high'; // priority ('high','low')

        add_meta_box($slug,$boxlabel,$callback,$posttype,$where,$priority);
    }
    
    public function render_meta_box($post)
    {
    	$custom = get_post_custom($post->ID);
    	$data = $custom[$this->slug][0];

        wp_nonce_field( plugin_basename(__FILE__), $this->slug.'_nonce' ); // Use nonce for verification
        ?>
        <p><input name="<?php echo $this->slug; ?>" type="text" style="width:100%; height:2em; font-family:inherit; font-size:2em" value="<?php echo $data;?>"/></p>
        <?php
    }
    
    public function save_meta_box($post_id)
    {   
        if ( !wp_verify_nonce( $_POST[$this->slug.'_nonce'], plugin_basename(__FILE__) )) return $post_id;

        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;

        if ( !current_user_can( 'edit_post', $post_id ) ) return $post_id;

        $this->saveMeta($this->slug,$post_id); // see custom-functions.php
    }
}

$pju = new ProjectURL();

?>