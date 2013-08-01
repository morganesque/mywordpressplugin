<?php

add_action('widgets_init', twitter_load_widgets);

function twitter_load_widgets() {
	register_widget( 'Twitter_Widget' );   // change
}

class Twitter_Widget extends WP_Widget {    // change

    private $defaults = array(              // change
        'twittername' => 'BBCNews'
        ,'number_of_tweets' => '5'
        ,'widget_title' => 'From Twitter'
    );
    
    private $slug = 'twitterwidget';
    private $desc = 'Displays the twitter feed.';
    

	function Twitter_Widget() 
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
		      'Twitter Widget', 
		      $widget_ops, 
		      $control_ops
		      );
	}

	function widget($args, $instance) 
	{		   
		extract($args);
		
		$instance = wp_parse_args( (array)$instance, $this->defaults);

		echo $before_widget;

            ?>
			<h3 class="widgettitle"><?php echo $instance['widget_title']; ?></h3>
			<?php
                $twitter = new Twitter($instance['twittername']);
                list($is_cache,$tweets) = $twitter->getTweets();

                for($i=0; $i<$instance['number_of_tweets']; $i++)
                {
                    $t = $tweets[$i];
                    echo '<p>'.$t['text'].'</p>';
                }
			?>
			<p class="follow"><a href="http://www.twitter.com/<?php echo $instance['twittername']; ?>/">Follow us on Twitter</a></p>
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
		<p><label for="<?php echo $this->get_field_name('widget_title'); ?>">Widget Title: </label>
		<input type="text" value="<?php echo $instance['widget_title'];?>" name="<?php echo $this->get_field_name('widget_title'); ?>"/>
		
		<p><label for="<?php echo $this->get_field_name('twittername'); ?>">Twitter Username: </label>
		@<input type="text" value="<?php echo $instance['twittername'];?>" name="<?php echo $this->get_field_name('twittername'); ?>"/>
		
		<p><label for="<?php echo $this->get_field_name('number_of_tweets'); ?>">Number Of Tweets: </label>
		<input type="text" value="<?php echo $instance['number_of_tweets'];?>" name="<?php echo $this->get_field_name('number_of_tweets'); ?>"/>
		<?php 
	}
}
?>