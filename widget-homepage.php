<?php

add_action('widgets_init', homepage_load_widgets);

function homepage_load_widgets() {
	register_widget( 'Homepage_Page' );
}

class Homepage_Page extends WP_Widget {

	function Homepage_Page() 
	{
		$widget_ops = array( 
		      'classname' => 'homepagepage', 
		      'description' => __('Displays a featured page with thumbnail and excerpt.','solostream')
		      );
		$control_ops = array(
		      'width' => 300, 
		      'height' => 350, 
		      'id_base' => 'homepage-page' 
		      );
		$this->WP_Widget(
		      'homepage-page', 
		      __('HomePage Page', 'solostream'), 
		      $widget_ops, 
		      $control_ops
		      );
	}

	function widget($args, $instance) {
	
		extract($args);
		
		$instance = wp_parse_args( (array)$instance, array(
			'title' => ''
		));

		echo $before_widget;

		$featured_page = new WP_Query(array('page_id' => $instance['page_id']));
		if($featured_page->have_posts()) : while($featured_page->have_posts()) : $featured_page->the_post(); ?>

					<?php 
					if ( function_exists('get_the_image')) 
					{
						if (get_option('solostream_default_thumbs') == 'yes') { $defthumb = get_bloginfo('stylesheet_directory') . '/images/def-thumb.jpg'; } else { $defthumb == 'false'; }
						
						$solostream_img = get_the_image(array(
							'meta_key' => 'thumbnail',
							'size' => 'medium',
							'image_class' => 'thumbnail',
							'default_image' => $defthumb,
							'format' => 'array',
							'image_scan' => true,
							'link_to_post' => false, ));
							
						if ( $solostream_img['url'] && get_option('solostream_show_thumbs') == 'yes' && get_post_meta( $post->ID, 'remove_thumb', true ) != 'Yes' ) {

							$the_img_url = $solostream_img[url];
							
							if(!empty($the_img_url)) { 
								$the_img_url = get_network_image_path($the_img_url); 
							} 
						} 
					} 
					?>

			<a href="<?php the_permalink();?>" class="post clearfix" style="background-image:url(<?php echo $the_img_url; ?>);">				
			     <h2><?php the_title(); ?></h2>
			</a>
					
		<?php endwhile; endif;
		
		echo $after_widget;
		wp_reset_query();
	}

	function update($new_instance, $old_instance) {
		return $new_instance;
	}

	function form($instance) { 
		
		$instance = wp_parse_args( (array)$instance, array(
			'title' => ''
		) );
		
    ?>
        <p><label for="<?php echo $this->get_field_id('page_id'); ?>"><?php _e('Page', 'solostream'); ?>:</label>
        <?php wp_dropdown_pages(array('name' => $this->get_field_name('page_id'), 'selected' => $instance['page_id'])); ?></p>    
    <?php 
	}
}

?>