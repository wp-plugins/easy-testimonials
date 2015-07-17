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

class listTestimonialsWidget extends WP_Widget
{
	function listTestimonialsWidget(){
		$widget_ops = array('classname' => 'listTestimonialsWidget', 'description' => 'Displays a List of Testimonials.' );
		$this->WP_Widget('listTestimonialsWidget', 'Easy Testimonials List', $widget_ops);
	}

	function form($instance){
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'count' => 5, 'show_title' => 0, 'category' => '', 'use_excerpt' => 0, 'show_rating' => false, 'show_date' => false, 'width' => false, 'show_testimonial_image' => 0, 'order' => 'ASC', 'order_by' => 'date', 'show_other' => 0 ) );
		$title = $instance['title'];
		$count = $instance['count'];
		$show_title = $instance['show_title'];
		$show_rating = $instance['show_rating'];
		$use_excerpt = $instance['use_excerpt'];
		$category = $instance['category'];
		$show_date = $instance['show_date'];
		$width = $instance['width'];
		$show_testimonial_image = $instance['show_testimonial_image'];
		$order = $instance['order'];
		$order_by = $instance['order_by'];
		$show_other = $instance['show_other'];
		
		$testimonial_categories = get_terms( 'easy-testimonial-category', 'orderby=title&hide_empty=0' );				
		?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
			
			<p><label for="<?php echo $this->get_field_id('count'); ?>">Count: <input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo esc_attr($count); ?>" /></label><br/><em>The number of Testimonials to display.  Set to -1 to display All Testimonials.</em></p>
			
			<p><label for="<?php echo $this->get_field_id('order'); ?>">Order:</label><br/>
			<select id="<?php echo $this->get_field_id('order_by'); ?>" name="<?php echo $this->get_field_name('order_by'); ?>">
				<option value="title" <?php if($order_by == "title"): ?>selected="SELECTED"<?php endif; ?>>Title</option>
				<option value="rand" <?php if($order_by == "rand"): ?>selected="SELECTED"<?php endif; ?>>Random</option>
				<option value="id" <?php if($order_by == "id"): ?>selected="SELECTED"<?php endif; ?>>ID</option>
				<option value="author" <?php if($order_by == "author"): ?>selected="SELECTED"<?php endif; ?>>Author</option>
				<option value="name" <?php if($order_by == "name"): ?>selected="SELECTED"<?php endif; ?>>Name</option>
				<option value="date" <?php if($order_by == "date"): ?>selected="SELECTED"<?php endif; ?>>Date</option>
				<option value="last_modified" <?php if($order_by == "last_modified"): ?>selected="SELECTED"<?php endif; ?>>Last Modified</option>
				<option value="parent_id" <?php if($order_by == "parent_id"): ?>selected="SELECTED"<?php endif; ?>>Parent ID</option>
			</select>
			<select id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>">
				<option value="ASC" <?php if($order == "ASC"): ?>selected="SELECTED"<?php endif; ?>>Ascending (ASC)</option>
				<option value="DESC" <?php if($order == "DESC"): ?>selected="SELECTED"<?php endif; ?>>Descending (DESC)</option>
			</select></p>		

			<p><label for="<?php echo $this->get_field_id('category'); ?>">Filter By Category:</label><br/>
			
			<select id="<?php echo $this->get_field_id('category'); ?>">
				<option value="all">All Categories</option>
				<?php foreach($testimonial_categories as $cat):?>
				<option value="<?php echo $cat->slug; ?>" <?php if($category == $cat->slug):?>selected="SELECTED"<?php endif; ?>><?php echo htmlentities($cat->name); ?></option>
				<?php endforeach; ?>
			</select><br/><em><a href="<?php echo admin_url('edit-tags.php?taxonomy=easy-testimonial-category&post_type=testimonial'); ?>">Manage Categories</a></em></p>

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
		$instance['count'] = $new_instance['count'];
		$instance['show_title'] = $new_instance['show_title'];
		$instance['show_rating'] = $new_instance['show_rating'];
		$instance['use_excerpt'] = $new_instance['use_excerpt'];
		$instance['category'] = $new_instance['category'];
		$instance['show_date'] = $new_instance['show_date'];	
		$instance['width'] = $new_instance['width'];
		$instance['show_testimonial_image'] = $new_instance['show_testimonial_image'];
		$instance['order'] = $new_instance['order'];
		$instance['order_by'] = $new_instance['order_by'];
		$instance['show_other'] = $new_instance['show_other'];
		return $instance;
	}

	function widget($args, $instance){
		extract($args, EXTR_SKIP);

		echo $before_widget;
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		$count = empty($instance['count']) ? 1 : $instance['count'];
		$show_title = empty($instance['show_title']) ? 0 : $instance['show_title'];
		$show_rating = empty($instance['show_rating']) ? false : $instance['show_rating'];
		$use_excerpt = empty($instance['use_excerpt']) ? 0 : $instance['use_excerpt'];
		$category = empty($instance['category']) ? '' : $instance['category'];
		$show_date = empty($instance['show_date']) ? false : $instance['show_date'];
		$width = empty($instance['width']) ? false : $instance['width'];
		$show_testimonial_image = $instance['show_testimonial_image'];
		$order = empty($instance['order']) ? 'ASC' : $instance['order'];
		$order_by = empty($instance['order_by']) ? 'date' : $instance['order_by'];
		$show_other = empty($instance['show_other']) ? 0 : $instance['show_other'];
		$testimonials_link = empty($instance['testimonials_link']) ? get_option('testimonials_link') : $instance['testimonials_link'];

		if (!empty($title)){
			echo $before_title . $title . $after_title;;
		}
		
		echo outputTestimonials(array('testimonials_link' => $testimonials_link, 'count' => $count, 'show_title' => $show_title, 'category' => $category, 'use_excerpt' => $use_excerpt, 'show_rating' => $show_rating, 'show_date' => $show_date, 'width' => $width, 'show_other' => $show_other, 'order' => $order, 'orderby' => $order_by, 'show_thumbs' => $show_testimonial_image));

		echo $after_widget;
	} 
}
?>