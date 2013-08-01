<?php

add_action('widgets_init', facebook_load_widgets);      // change

function facebook_load_widgets() {
	register_widget( 'Facebook_Widget' );               // change
}

class Facebook_Widget extends WP_Widget {               // change
    
    private $widg = 'Facebook Widget';                  // change
    private $slug = 'facebookwidget';                   // change
    private $desc = 'Displays the facebook box.';       // change
    

	function Facebook_Widget()                          // change
	{
		$widget_ops = array( 
		      'classname' => $this->slug, 
		      'description' => $this->desc
		      );
		$control_ops = array(
		      'width' => 300, 
		      'height' => 350, 
		      'id_base' => $this->slug
		      );
		$this->WP_Widget(
		      $this->slug, 
		      $this->widg, 
		      $widget_ops, 
		      $control_ops
		      );
	}

	function widget($args, $instance) 
	{		   
		extract($args);
		
		$instance = wp_parse_args( (array)$instance, $this->defaults);

		echo $before_widget;
		
		$url = $instance['fb_url'];
		$message = $instance['fb_blurb'];

            ?>
			<h3 class="widgettitle">We're on Facebook</h3>
			<p><?php echo $message; ?></p>
			<p class="follow"><a href="<?php echo $url; ?>">Join us on Facebook</a></p>
			<?php
		
		echo $after_widget;
		wp_reset_query();
	}

	function update($new_instance, $old_instance) {
		return $new_instance;
	}

	function form($instance) 
	{ 	
		$instance = wp_parse_args( (array)$instance, $this->defaults);
		
		?>
		<p><label for="<?php echo $this->get_field_name('fb_url'); ?>">Facebook URL</label>
		<input type="text" value="<?php echo $instance['fb_url'];?>" name="<?php echo $this->get_field_name('fb_url'); ?>"/>
		
		<p><label for="<?php echo $this->get_field_name('fb_blurb'); ?>">Facebook URL</label><textarea class="widefat" rows="4" cols="8" name="<?php echo $this->get_field_name('fb_blurb'); ?>"><?php echo $instance['fb_blurb'];?>
		</textarea>
		<?php 
	}
}
?>