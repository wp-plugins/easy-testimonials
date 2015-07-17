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

class singleTestimonialWidget extends WP_Widget
{
	function singleTestimonialWidget(){
		$widget_ops = array('classname' => 'singleTestimonialWidget', 'description' => 'Displays a Single Testimonial.' );
		$this->WP_Widget('singleTestimonialWidget', 'Easy Testimonials Single Testimonial', $widget_ops);
	}

	function form($instance){
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'testimonial_id' => '', 'use_excerpt' => 0, 'show_title' => 0, 'show_rating' => false, 'show_date' => false, 'width' => false, 'show_other' => 0, 'show_testimonial_image' => 1 ) );
		$title = $instance['title'];
		$testimonial_id = $instance['testimonial_id'];
		$show_title = $instance['show_title'];
		$show_rating = $instance['show_rating'];
		$show_date = $instance['show_date'];
		$show_other = $instance['show_other'];
		$use_excerpt = $instance['use_excerpt'];
		$show_testimonial_image = $instance['show_testimonial_image'];
		$width = $instance['width'];
				
		?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
			
			<?php $testimonials = get_posts('post_type=testimonial&posts_per_page=-1&nopaging=true'); ?>
			<label for="<?php echo $this->get_field_id('testimonial_id'); ?>">Testimonial to Display</label>
			<select id="<?php echo $this->get_field_id('testimonial_id'); ?>" name="<?php echo $this->get_field_name('testimonial_id'); ?>">
			<?php if($testimonials) : foreach ( $testimonials as $testimonial  ) : ?>
				<option value="<?php echo $testimonial->ID; ?>"  <?php if($testimonial_id == $testimonial->ID): ?> selected="SELECTED" <?php endif; ?>><?php echo $testimonial->post_title; ?></option>
			<?php endforeach; endif;?>
			 </select>
			
			<p><label for="<?php echo $this->get_field_id('show_title'); ?>">Show Testimonial Title: </label><input class="widefat" id="<?php echo $this->get_field_id('show_title'); ?>" name="<?php echo $this->get_field_name('show_title'); ?>" type="checkbox" value="1" <?php if($show_title){ ?>checked="CHECKED"<?php } ?>/></p>
			
			<p><label for="<?php echo $this->get_field_id('width'); ?>">Width: <input class="widefat" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo esc_attr($width); ?>" /></label><br/><em>(e.g. 100px or 25%)</em></p>
			
			<p><label for="<?php echo $this->get_field_id('use_excerpt'); ?>">Use Testimonial Excerpt: </label><input class="widefat" id="<?php echo $this->get_field_id('use_excerpt'); ?>" name="<?php echo $this->get_field_name('use_excerpt'); ?>" type="checkbox" value="1" <?php if($use_excerpt){ ?>checked="CHECKED"<?php } ?>/></p>	
			
			<p><label for="<?php echo $this->get_field_id('show_testimonial_image'); ?>">Show Featured Image: </label><input class="widefat" id="<?php echo $this->get_field_id('show_testimonial_image'); ?>" name="<?php echo $this->get_field_name('show_testimonial_image'); ?>" type="checkbox" value="1" <?php if($show_testimonial_image){ ?>checked="CHECKED"<?php } ?>/></p>
			
			<p><label for="<?php echo $this->get_field_id('show_date'); ?>">Show Testimonial Date: </label><input class="widefat" id="<?php echo $this->get_field_id('show_date'); ?>" name="<?php echo $this->get_field_name('show_date'); ?>" type="checkbox" value="1" <?php if($show_date){ ?>checked="CHECKED"<?php } ?>/></p
			
			<p><label for="<?php echo $this->get_field_id('show_other'); ?>">Show Location / Product Reviewed / Other" Field: </label><input class="widefat" id="<?php echo $this->get_field_id('show_other'); ?>" name="<?php echo $this->get_field_name('show_other'); ?>" type="checkbox" value="1" <?php if($show_other){ ?>checked="CHECKED"<?php } ?>/></p>
									
			<p><label for="<?php echo $this->get_field_id('show_rating'); ?>">Show Rating: </label></p>
			<p><select name="<?php echo $this->get_field_name('show_rating'); ?>" id="<?php echo $this->get_field_id('show_rating'); ?>">	
				<option value="before" <?php if(esc_attr($show_rating) == "before"): echo 'selected="SELECTED"'; endif; ?>>Before Testimonial</option>
				<option value="after" <?php if(esc_attr($show_rating) == "after"): echo 'selected="SELECTED"'; endif; ?>>After Testimonial</option>
				<option value="stars" <?php if(esc_attr($show_rating) == "stars"): echo 'selected="SELECTED"'; endif; ?>>As Stars</option>
				<option value="" <?php if(esc_attr($show_rating) == ""): echo 'selected="SELECTED"'; endif; ?>>Do Not Show</option>
			<p><span class="description">Whether to show Ratings, and How.  If you are using a custom theme, make sure you follow the recommended settings here.</span></label></p>
			</select></p>
		<?php
	}

	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['testimonial_id'] = $new_instance['testimonial_id'];
		$instance['show_title'] = $new_instance['show_title'];
		$instance['show_rating'] = $new_instance['show_rating'];
		$instance['use_excerpt'] = $new_instance['use_excerpt'];
		$instance['show_date'] = $new_instance['show_date'];	
		$instance['width'] = $new_instance['width'];
		$instance['show_testimonial_image'] = $new_instance['show_testimonial_image'];
		$instance['show_other'] = $new_instance['show_other'];
		return $instance;
	}

	function widget($args, $instance){
		extract($args, EXTR_SKIP);

		echo $before_widget;
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		$show_title = empty($instance['show_title']) ? 0 : $instance['show_title'];
		$show_rating = empty($instance['show_rating']) ? false : $instance['show_rating'];
		$use_excerpt = empty($instance['use_excerpt']) ? 0 : $instance['use_excerpt'];
		$show_date = empty($instance['show_date']) ? false : $instance['show_date'];
		$width = empty($instance['width']) ? false : $instance['width'];
		$show_testimonial_image = $instance['show_testimonial_image'];
		$show_other = empty($instance['show_other']) ? 0 : $instance['show_other'];
		$testimonials_link = empty($instance['testimonials_link']) ? get_option('testimonials_link') : $instance['testimonials_link'];
		$testimonial_id = $instance['testimonial_id'];

		if (!empty($title)){
			echo $before_title . $title . $after_title;;
		}
		
		echo outputSingleTestimonial(array('testimonials_link' => $testimonials_link, 'show_title' => $show_title, 'use_excerpt' => $use_excerpt, 'show_rating' => $show_rating, 'show_date' => $show_date, 'width' => $width, 'show_thumbs' => $show_testimonial_image, 'show_other' => $show_other, 'id' => $testimonial_id));

		echo $after_widget;
	} 
}
?>