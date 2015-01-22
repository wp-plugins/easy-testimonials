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

class cycledTestimonialWidget extends WP_Widget
{
	function cycledTestimonialWidget(){
		$widget_ops = array('classname' => 'cycledTestimonialWidget', 'description' => 'Displays a Testimonial cycle.' );
		$this->WP_Widget('cycledTestimonialWidget', 'Easy Testimonial Cycle', $widget_ops);
	}

	function form($instance){
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'count' => 1, 'testimonials_per_slide' => 1, 'show_title' => 0, 'transition' => 'fade', 'timer' => '2000', 'category' => '', 'use_excerpt' => 0, 'show_pager_icons' => 0, 'random' => false, 'show_rating' => false ) );
		$title = $instance['title'];
		$count = $instance['count'];
		$testimonials_per_slide = $instance['testimonials_per_slide'];
		$show_title = $instance['show_title'];
		$show_rating = $instance['show_rating'];
		$random = $instance['random'];
		$use_excerpt = $instance['use_excerpt'];
		$show_pager_icons = $instance['show_pager_icons'];
		$transition = $instance['transition'];
		$timer = $instance['timer'];
		$category = $instance['category'];
		$show_date = $instance['show_date'];
				
		$testimonial_categories = get_terms( 'easy-testimonial-category', 'orderby=title&hide_empty=0' );				
		?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('count'); ?>">Count: <input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo esc_attr($count); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('testimonials_per_slide'); ?>">Testimonials Per Slide: <input class="widefat" id="<?php echo $this->get_field_id('testimonials_per_slide'); ?>" name="<?php echo $this->get_field_name('testimonials_per_slide'); ?>" type="text" value="<?php echo esc_attr($testimonials_per_slide); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('transition'); ?>">Transition: 
			<p><select name="<?php echo $this->get_field_name('transition'); ?>" id="<?php echo $this->get_field_id('transition'); ?>">	
				<option value="scrollHorz" <?php if(esc_attr($transition) == "scrollHorz"): echo 'selected="SELECTED"'; endif; ?>>Horizontal Scroll</option>
				<option <?php if(!isValidKey()): ?>disabled=DISABLED <?php endif; ?>	value="scrollVert" <?php if(esc_attr($transition) == "scrollVert"): echo 'selected="SELECTED"'; endif; ?>>Vertical Scroll<?php if(!isValidKey()): ?> - Register to Enable!<?php endif; ?></option>
				<option value="fade" <?php if(esc_attr($transition) == "fade"): echo 'selected="SELECTED"'; endif; ?>>Fade</option>
				<option <?php if(!isValidKey()): ?>disabled=DISABLED <?php endif; ?>	value="fadeout" <?php if(esc_attr($transition) == "fadeout"): echo 'selected="SELECTED"'; endif; ?>>Fade Out<?php if(!isValidKey()): ?> - Register to Enable!<?php endif; ?></option>
				<option <?php if(!isValidKey()): ?>disabled=DISABLED <?php endif; ?>	value="carousel" <?php if(esc_attr($transition) == "carousel"): echo 'selected="SELECTED"'; endif; ?>>Carousel<?php if(!isValidKey()): ?> - Register to Enable!<?php endif; ?></option>
				<option <?php if(!isValidKey()): ?>disabled=DISABLED <?php endif; ?>	value="flipHorz" <?php if(esc_attr($transition) == "flipHorz"): echo 'selected="SELECTED"'; endif; ?>>Horizontal Flip<?php if(!isValidKey()): ?> - Register to Enable!<?php endif; ?></option>
				<option <?php if(!isValidKey()): ?>disabled=DISABLED <?php endif; ?>	value="flipVert" <?php if(esc_attr($transition) == "flipVert"): echo 'selected="SELECTED"'; endif; ?>>Vertical Flip<?php if(!isValidKey()): ?> - Register to Enable!<?php endif; ?></option>
				<option <?php if(!isValidKey()): ?>disabled=DISABLED <?php endif; ?>	value="tileslide" <?php if(esc_attr($transition) == "tileslide"): echo 'selected="SELECTED"'; endif; ?>>Tile Slide<?php if(!isValidKey()): ?> - Register to Enable!<?php endif; ?></option>
				<option <?php if(!isValidKey()): ?>disabled=DISABLED <?php endif; ?>	value="none" <?php if(esc_attr($transition) == "none"): echo 'selected="SELECTED"'; endif; ?>>None<?php if(!isValidKey()): ?> - Register to Enable!<?php endif; ?></option>
			</select></p>
			<p><span class="description">Pick your desired transition.</span></label></p>
			<p><label for="<?php echo $this->get_field_id('timer'); ?>">Timer: <input class="widefat" id="<?php echo $this->get_field_id('timer'); ?>" name="<?php echo $this->get_field_name('timer'); ?>" type="text" value="<?php echo esc_attr($timer); ?>" /></label></p>
			<p><span class="description">The time between transitions.  Please Note: 1000 = 1 second.</span></label></p>
			<p><label for="<?php echo $this->get_field_id('show_pager_icons'); ?>">Show Pager Icons: </label><input class="widefat" id="<?php echo $this->get_field_id('show_pager_icons'); ?>" name="<?php echo $this->get_field_name('show_pager_icons'); ?>" type="checkbox" value="1" <?php if($show_pager_icons){ ?>checked="CHECKED"<?php } ?>/></p>	
			<p><label for="<?php echo $this->get_field_id('random'); ?>">Random Testimonial Order: </label><input class="widefat" id="<?php echo $this->get_field_id('random'); ?>" name="<?php echo $this->get_field_name('random'); ?>" type="checkbox" value="1" <?php if($random){ ?>checked="CHECKED"<?php } ?>/></p>
			<p><label for="<?php echo $this->get_field_id('show_title'); ?>">Show Testimonial Title: </label><input class="widefat" id="<?php echo $this->get_field_id('show_title'); ?>" name="<?php echo $this->get_field_name('show_title'); ?>" type="checkbox" value="1" <?php if($show_title){ ?>checked="CHECKED"<?php } ?>/></p>
			<p><label for="<?php echo $this->get_field_id('use_excerpt'); ?>">Use Testimonial Excerpt: </label><input class="widefat" id="<?php echo $this->get_field_id('use_excerpt'); ?>" name="<?php echo $this->get_field_name('use_excerpt'); ?>" type="checkbox" value="1" <?php if($use_excerpt){ ?>checked="CHECKED"<?php } ?>/></p>								
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
				<option value="" <?php if(esc_attr($show_rating) == "stars"): echo 'selected="SELECTED"'; endif; ?>>As Stars</option>
				<option value="" <?php if(esc_attr($show_rating) == ""): echo 'selected="SELECTED"'; endif; ?>>Do Not Show</option>
			<p><span class="description">Whether to show Ratings, and How.  If you are using a custom theme, make sure you follow the recommended settings here.</span></label></p>
			</select></p>
		<?php
	}

	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['count'] = $new_instance['count'];
		$instance['testimonials_per_slide'] = $new_instance['testimonials_per_slide'];
		$instance['show_title'] = $new_instance['show_title'];
		$instance['show_rating'] = $new_instance['show_rating'];
		$instance['random'] = $new_instance['random'];
		$instance['use_excerpt'] = $new_instance['use_excerpt'];
		$instance['show_pager_icons'] = $new_instance['show_pager_icons'];
		$instance['timer'] = $new_instance['timer'];
		$instance['transition'] = $new_instance['transition'];
		$instance['category'] = $new_instance['category'];
		$instance['show_date'] = $new_instance['show_date'];
		
		return $instance;
	}

	function widget($args, $instance){
		extract($args, EXTR_SKIP);

		echo $before_widget;
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		$count = empty($instance['count']) ? 1 : $instance['count'];
		$testimonials_per_slide = empty($instance['testimonials_per_slide']) ? 1 : $instance['testimonials_per_slide'];
		$show_title = empty($instance['show_title']) ? 0 : $instance['show_title'];
		$show_rating = empty($instance['show_rating']) ? false : $instance['show_rating'];
		$random = empty($instance['random']) ? 0 : $instance['random'];
		$transition = empty($instance['transition']) ? 'fade' : $instance['transition'];
		$timer = empty($instance['timer']) ? '2000' : $instance['timer'];
		$use_excerpt = empty($instance['use_excerpt']) ? 0 : $instance['use_excerpt'];
		$show_pager_icons = empty($instance['show_pager_icons']) ? 0 : $instance['show_pager_icons'];
		$category = empty($instance['category']) ? '' : $instance['category'];
		$show_date = empty($instance['show_date']) ? false : $instance['show_date'];

		if (!empty($title)){
			echo $before_title . $title . $after_title;;
		}
		
		echo outputTestimonialsCycle(array('testimonials_link' => get_option('testimonials_link'), 'count' => $count, 'testimonials_per_slide' => $testimonials_per_slide, 'show_title' => $show_title, 'transition' => $transition, 'timer' => $timer, 'container' => true, 'category' => $category, 'use_excerpt' => $use_excerpt, 'random' => $random, 'show_pager_icons' => $show_pager_icons, 'show_rating' => $show_rating, 'show_date' => $show_date));

		echo $after_widget;
	} 
}
?>