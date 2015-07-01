<?php
/*
This file is part of Easy Testimonials.

Easy Testimonials is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Easy Testimonials is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Easy Testimonials.  If not, see <http://www.gnu.org/licenses/>.

Shout out to http://www.makeuseof.com/tag/how-to-create-wordpress-widgets/ for the help
*/

class randomTestimonialWidget extends WP_Widget
{
	function randomTestimonialWidget(){
		$widget_ops = array('classname' => 'randomTestimonialWidget', 'description' => 'Displays a random Testimonial.' );
		$this->WP_Widget('randomTestimonialWidget', 'Easy Random Testimonial', $widget_ops);
	}

	function form($instance){
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'use_excerpt' => 0, 'count' => 1, 'show_title' => 0, 'category' => '', 'show_rating' => false, 'show_date' => false, 'width' => false ) );
		$title = $instance['title'];
		$count = $instance['count'];
		$show_title = $instance['show_title'];
		$show_rating = $instance['show_rating'];
		$show_date = $instance['show_date'];
		$use_excerpt = $instance['use_excerpt'];
		$category = $instance['category'];
		$width = $instance['width'];
				
		$testimonial_categories = get_terms( 'easy-testimonial-category', 'orderby=title&hide_empty=0' );
		?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('count'); ?>">Count: <input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo esc_attr($count); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('show_title'); ?>">Show Testimonial Title: </label><input class="widefat" id="<?php echo $this->get_field_id('show_title'); ?>" name="<?php echo $this->get_field_name('show_title'); ?>" type="checkbox" value="1" <?php if($show_title){ ?>checked="CHECKED"<?php } ?>/></p>
			<p><label for="<?php echo $this->get_field_id('use_excerpt'); ?>">Use Testimonial Excerpt: </label><input class="widefat" id="<?php echo $this->get_field_id('use_excerpt'); ?>" name="<?php echo $this->get_field_name('use_excerpt'); ?>" type="checkbox" value="1" <?php if($use_excerpt){ ?>checked="CHECKED"<?php } ?>/></p>
			<p><label for="<?php echo $this->get_field_id('show_date'); ?>">Show Testimonial Date: </label><input class="widefat" id="<?php echo $this->get_field_id('show_date'); ?>" name="<?php echo $this->get_field_name('show_date'); ?>" type="checkbox" value="1" <?php if($show_date){ ?>checked="CHECKED"<?php } ?>/></p>
			<p><label for="<?php echo $this->get_field_id('width'); ?>">Width: <input class="widefat" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo esc_attr($width); ?>" /></label><br/><em>(e.g. 100px or 25%)</em></p>
			
			<p><label for="<?php echo $this->get_field_id('category'); ?>">Category:</label></p>
			<p><select name="<?php echo $this->get_field_name('category'); ?>" id="<?php echo $this->get_field_id('category'); ?>">
				<option value="" <?php if(esc_attr($category) == ""): echo 'selected="SELECTED"'; endif; ?>>All Categories</option>
				<?php foreach($testimonial_categories as $cat):?>
				<option value="<?php echo $cat->slug; ?>" <?php if(esc_attr($category) == $cat->slug): echo 'selected="SELECTED"'; endif; ?>><?php echo htmlentities($cat->name); ?></option>
				<?php endforeach; ?>
			</select></p>
			
			<p><label for="<?php echo $this->get_field_id('show_rating'); ?>">Show Rating: </label></p>
			<p><select name="<?php echo $this->get_field_name('show_rating'); ?>" id="<?php echo $this->get_field_id('show_rating'); ?>">	
				<option value="before" <?php if(esc_attr($show_rating) == "before"): echo 'selected="SELECTED"'; endif; ?>>Before Testimonial</option>
				<option value="after" <?php if(esc_attr($show_rating) == "after"): echo 'selected="SELECTED"'; endif; ?>>After Testimonial</option>
				<option value="stars" <?php if(esc_attr($show_rating) == "stars"): echo 'selected="SELECTED"'; endif; ?>>As Stars</option>
				<option value="" <?php if(esc_attr($show_rating) == ""): echo 'selected="SELECTED"'; endif; ?>>Do Not Show</option>
			</select></p>
		<?php
	}

	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['count'] = $new_instance['count'];
		$instance['show_title'] = $new_instance['show_title'];
		$instance['use_excerpt'] = $new_instance['use_excerpt'];
		$instance['category'] = $new_instance['category'];
		$instance['show_rating'] = $new_instance['show_rating'];
		$instance['show_date'] = $new_instance['show_date'];
		$instance['width'] = $new_instance['width'];
		return $instance;
	}

	function widget($args, $instance){
		extract($args, EXTR_SKIP);

		echo $before_widget;
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		$count = empty($instance['count']) ? 1 : $instance['count'];
		$show_title = empty($instance['show_title']) ? 0 : $instance['show_title'];
		$use_excerpt = empty($instance['use_excerpt']) ? 0 : $instance['use_excerpt'];
		$category = empty($instance['category']) ? '' : $instance['category'];
		$show_rating = empty($instance['show_rating']) ? false : $instance['show_rating'];
		$show_date = empty($instance['show_date']) ? false : $instance['show_date'];
		$width = empty($instance['width']) ? false : $instance['width'];

		if (!empty($title)){
			echo $before_title . $title . $after_title;;
		}
		
		echo outputRandomTestimonial(array('testimonials_link' => get_option('testimonials_link'), 'count' => $count, 'show_title' => $show_title, 'category' => $category, 'use_excerpt' => $use_excerpt, 'show_rating' => $show_rating, 'show_date' => $show_date, 'width' => $width));

		echo $after_widget;
	} 
}
?>