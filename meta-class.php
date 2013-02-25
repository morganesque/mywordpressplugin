<?php

class TM_MetaBox {
    
    function __construct()
    {
        
    }
    
    /*
        Useful function for Custom Meta Boxes.
    */
    function saveMeta($mkey,$post_id)
    {
        $data = $_POST[$mkey];    
        if (is_array($data)) $data = base64_encode(serialize($data));
        $this->saveMetaData($mkey,$post_id,$data);
    }
    /*
        Used by the above fuction saveMeta();
    */
    function saveMetaData($mkey,$post_id,$data)
    {       
        if (get_post_meta($post_id, $mkey) == "")

            return array('add',add_post_meta($post_id, $mkey , $data));

        elseif ($data != get_post_meta($post_id, $mkey, true))  

            return array('update',update_post_meta($post_id, $mkey, $data));  

        elseif ($data == "")  

            return array('delete',delete_post_meta($post_id, $mkey, get_post_meta($post_id, $mkey, true)));

        return array('none',true);
    }
    
}

?>