<?php

add_action('widgets_init', homepage_blog_load_widgets);

function homepage_blog_load_widgets() {
	register_widget( 'Homepage_Blog' );
}

class Homepage_Blog extends WP_Widget {

	function Homepage_Blog() 
	{
		$widget_ops = array( 
		      'classname' => 'homepageblog', 
		      'description' => __('Displays the principals blog on the home page.','solostream')
		      );
		$control_ops = array(
		      'width' => 300, 
		      'height' => 350, 
		      'id_base' => 'homepage-blog' 
		      );
		$this->WP_Widget(
		      'homepage-blog', 
		      __('HomePage Blog', 'solostream'), 
		      $widget_ops, 
		      $control_ops
		      );
		      	      
	}

	function widget($args, $instance) 
	{		   
		extract($args);
		
		$instance = wp_parse_args( (array)$instance, array(
			'title' => ''
		));

		echo $before_widget;
		
    		$args = array('post_type' => 'post','category_name' => 'principals-blog','posts_per_page'=>1);
        	query_posts($args);
            if (have_posts()) : while (have_posts()) : the_post();
            ?>
            <h3 class="widgettitle"><?php echo $instance['title']; ?></h3>
            <p><?php $excerpt = get_the_excerpt(); echo  substr($excerpt,0,250);?> [&hellip;]</p>
            <p class="follow"><a href="/principals-blog/" rel="bookmark" title="Permanent Link to Principal’s Blog">Read More »</a></p>
            <?php
            endwhile; endif; wp_reset_query();
		
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
		<p><label for="<?php echo $this->get_field_name('title'); ?>">Widget Title: </label>
		<input type="text" value="<?php echo $instance['title'];?>" name="<?php echo $this->get_field_name('title'); ?>"/>		
		<?php 
	}
}

?>