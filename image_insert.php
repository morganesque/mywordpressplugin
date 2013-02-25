<?php
/*
Alters the way images are inserted when "inserted into post" 
in order to override the width and always give is a full width
*/
add_filter( 'image_send_to_editor', 'tommorgan_imageSendToEditor' , 9 , 8 );	
function tommorgan_imageSendToEditor( $html, $id, $caption, $title, $align, $url, $size, $alt ) 
{    
        $hwstring = '';
        $size = 'thumbnail'; // force the size to be thumbnail (ready for mobile).
    	list( $img_src, $width, $height ) = image_downsize($id, $size); 
		
		// grab the URL for the other two sizes too.
		list( $med_src, $tmp1, $tmp2 ) = image_downsize($id, 'medium');
		list( $lrg_src, $tmp1, $tmp2 ) = image_downsize($id, 'large');
	
		// do normal stuff with classes.
		$class = 'align' . esc_attr($align) .' size-' . esc_attr($size) . ' wp-image-' . $id;
		$class = apply_filters('get_image_tag_class', $class, $id, $align, $size);		
		
		$attrs_fields = '';
        // foreach( $attrs as $name => $attr ) {
        //  $attrs_fields .= ' '.$name.'="'.esc_attr( $attr ).'" ';
        // }
        
        // add a "mob-thumb" class
        // add two data attrs data-med and data-lrg for the two other sizes.
		$html = '<a href="'.esc_attr($lrg_src).'"><img src="' . esc_attr($img_src) . '" alt="' . esc_attr($alt) . '" title="' . esc_attr($title).'" '.$hwstring.'class="'.$class.' mob-thumb" '.$attrs_fields.' data-med="'.esc_attr($med_src).'" data-lrg="'.esc_attr($lrg_src).'" /></a>';
		return $html;
}

?>