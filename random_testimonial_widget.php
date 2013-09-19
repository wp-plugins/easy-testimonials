<?php
/*
This file is part of IK Facebook.

IK Facebook is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

IK Facebook is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with IK Facebook.  If not, see <http://www.gnu.org/licenses/>.

Shout out to http://www.makeuseof.com/tag/how-to-create-wordpress-widgets/ for the help
*/

class randomTestimonialWidget extends WP_Widget
{
	function randomTestimonialWidget(){
		$widget_ops = array('classname' => 'randomTestimonialWidget', 'description' => 'Displays a random Testimonial.' );
		$this->WP_Widget('randomTestimonialWidget', 'Easy Random Testimonial', $widget_ops);
	}

	function form($instance){
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'count' => 1, 'show_title' => 0 ) );
		$title = $instance['title'];
		$count = $instance['count'];
		$show_title = $instance['show_title'];
		?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('count'); ?>">Count: <input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo attribute_escape($count); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('show_title'); ?>">Show Testimonial Title: </label><input class="widefat" id="<?php echo $this->get_field_id('show_title'); ?>" name="<?php echo $this->get_field_name('show_title'); ?>" type="checkbox" value="1" <?php if($show_title){ ?>checked="CHECKED"<?php } ?>/></p>
		<?php
	}

	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['count'] = $new_instance['count'];
		$instance['show_title'] = $new_instance['show_title'];
		return $instance;
	}

	function widget($args, $instance){
		extract($args, EXTR_SKIP);

		echo $before_widget;
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		$count = empty($instance['count']) ? 1 : $instance['count'];
		$show_title = empty($instance['show_title']) ? 1 : $instance['show_title'];

		if (!empty($title)){
			echo $before_title . $title . $after_title;;
		}
		
		echo outputRandomTestimonial(array('testimonials_link' => get_option('testimonials_link'), 'count' => $count, 'show_title' => $show_title));

		echo $after_widget;
	} 
}
?>