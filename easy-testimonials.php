<?php
/*
Plugin Name: Easy Testimonials
Plugin URI: http://illuminatikarate.com/easy-testimonials/
Description: Easy Testimonials - Provides custom post type, shortcode, sidebar widget, and other functionality for testimonials.
Author: Illuminati Karate
Version: 1.3
Author URI: http://illuminatikarate.com

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
along with Easy Testimonials .  If not, see <http://www.gnu.org/licenses/>.
*/

//add Testimonial CSS to header
function ik_setup_css() {
	wp_register_style( 'easy_testimonial_style', plugins_url('css/style.css', __FILE__) );
	wp_register_style( 'easy_testimonial_dark_style', plugins_url('css/dark_style.css', __FILE__) );
	wp_register_style( 'easy_testimonial_light_style', plugins_url('css/light_style.css', __FILE__) );
	wp_register_style( 'easy_testimonial_blue_style', plugins_url('css/blue_style.css', __FILE__) );
	wp_register_style( 'easy_testimonial_no_style', plugins_url('css/no_style.css', __FILE__) );
	
    switch(get_option('testimonials_style')){
		case 'dark_style':
			wp_enqueue_style( 'easy_testimonial_dark_style' );
			break;
		case 'light_style':
			wp_enqueue_style( 'easy_testimonial_light_style' );
			break;
		case 'blue_style':
			wp_enqueue_style( 'easy_testimonial_blue_style' );
			break;
		case 'no_style':
			//wp_enqueue_style( 'easy_testimonial_no_style' );
			break;
		case 'default_style':
		default:
			wp_enqueue_style( 'easy_testimonial_style' );
			break;
	}
}

if(!function_exists('word_trim')):
	function word_trim($string, $count, $ellipsis = FALSE)
	{
		$words = explode(' ', $string);
		if (count($words) > $count)
		{
			array_splice($words, $count);
			$string = implode(' ', $words);
			// trim of punctionation
			$string = rtrim($string, ',;.');	

			// add ellipsis if needed
			if (is_string($ellipsis)) {
				$string .= $ellipsis;
			} elseif ($ellipsis) {
				$string .= '&hellip;';
			}			
		}
		return $string;
	}
endif;

//setup custom post type for testimonials
function ik_setup_testimonials(){
	//include custom post type code
	include('include/ik-custom-post-type.php');
	//include options code
	include('include/easy_testimonial_options.php');	
	$easy_testimonial_options = new easyTestimonialOptions();
			
	//setup post type for testimonials
	$postType = array('name' => 'Testimonial', 'plural' =>'Testimonials', 'slug' => 'testimonial' );
	$fields = array(); 
	$fields[] = array('name' => 'client', 'title' => 'Client Name', 'description' => "Name of the Client giving the testimonial.  Appears below the Testimonial.", 'type' => 'text'); 
	$fields[] = array('name' => 'position', 'title' => 'Position / Location / Other', 'description' => "The information that appears below the client's name.", 'type' => 'text');  
	$myCustomType = new ikTestimonialsCustomPostType($postType, $fields);
	
	//add featured image support
	add_theme_support( 'post-thumbnails', array( 'testimonial') );
	
	//for the testimonial thumb images
	add_image_size( 'easy_testimonial_thumb', 50, 50, true );
}

//load testimonials into an array and output a random one
function outputRandomTestimonial($atts){	
	//load shortcode attributes into an array
	extract( shortcode_atts( array(
		'testimonials_link' => get_option('testimonials_link'),
		'word_limit' => false,
		'body_class' => 'testimonial_body',
		'author_class' => 'testimonial_author',
		'short_version' => false,
	), $atts ) );
	
	$show_thumbs = get_option('testimonials_image');
	
	//load testimonials into an array
	$i = 0;
	$loop = new WP_Query(array( 'post_type' => 'testimonial','posts_per_page' => '-1'));
	while($loop->have_posts()) : $loop->the_post();
		$postid = get_the_ID();
		$testimonials[$i]['content'] = get_post_meta($postid, '_ikcf_short_content', true); 		

		//if nothing is set for the short content, use the long content
		if(strlen($testimonials[$i]['content']) < 2){
			$testimonials[$i]['content'] = get_the_content($postid); 
		}
		
		if ($word_limit) {
			$testimonials[$i]['content'] = word_trim($testimonials[$i]['content'], 65, TRUE);
		}
		
		if ($show_thumbs) {
			$testimonials[$i]['image'] = get_the_post_thumbnail($postid, 'easy_testimonial_thumb');
		}
		
		$testimonials[$i]['client'] = get_post_meta($postid, '_ikcf_client', true); 	
		$testimonials[$i]['position'] = get_post_meta($postid, '_ikcf_position', true); 	
		$i++;
	endwhile;
	wp_reset_query();
	
	$rand = rand(0, $i-1);
	
	ob_start();
	
	if(!$short_version){	
		?><blockquote class="easy_testimonial">		
			<?php if ($show_thumbs) {
				echo $testimonials[$rand]['image'];
			} ?>
			
			<?php if(get_option('meta_data_position')): ?>
				<?php if(strlen($testimonials[$rand]['client'])>0 || strlen($testimonials[$rand]['position'])>0 ): ?>
				<p class="<?=$author_class?>">
					<cite><?=$testimonials[$rand]['client'];?><br/><?=$testimonials[$rand]['position'];?></cite>
				</p>	
				<? endif; ?>
			<?php endif; ?>
			<p class="<?=$body_class?>">
				<?=$testimonials[$rand]['content'];?>
				<?php if(strlen($testimonials_link)>2):?><a href="<?php echo $testimonials_link; ?>">Read More</a><?php endif; ?>
			</p>			
			<?php if(!get_option('meta_data_position')): ?>	
				<?php if(strlen($testimonials[$rand]['client'])>0 || strlen($testimonials[$rand]['position'])>0 ): ?>
				<p class="<?=$author_class?>">
					<cite><?=$testimonials[$rand]['client'];?><br/><?=$testimonials[$rand]['position'];?></cite>
				</p>	
				<? endif; ?>
			<?php endif; ?>
		</blockquote><?php
	} else {
		echo $testimonials[$rand]['content'];
	}
	
	$content = ob_get_contents();
	ob_end_clean();
	
	return $content;
}

//output all testimonials
function outputTestimonials($atts){ 
	
	//load shortcode attributes into an array
	extract( shortcode_atts( array(
		'testimonials_link' => get_option('testimonials_link')
	), $atts ) );
	
	$show_thumbs = get_option('testimonials_image');
	
	ob_start();
	
	//load testimonials into an array
	$loop = new WP_Query(array( 'post_type' => 'testimonial','posts_per_page' => '-1'));
	while($loop->have_posts()) : $loop->the_post();
		$postid = get_the_ID();
		$testimonial['content'] = get_post_meta($postid, '_ikcf_short_content', true); 		

		//if nothing is set for the short content, use the long content
		if(strlen($testimonial['content']) < 2){
			$testimonial['content'] = get_the_content($postid); 
		}
		
		if ($show_thumbs) {
			$testimonial['image'] = get_the_post_thumbnail($postid, 'easy_testimonial_thumb');
		}
		
		$testimonial['client'] = get_post_meta($postid, '_ikcf_client', true); 	
		$testimonial['position'] = get_post_meta($postid, '_ikcf_position', true); 
	
		?><blockquote class="easy_testimonial">			
			<?php if ($show_thumbs) {
				echo $testimonial['image'];
			} ?>	
			<?php if(get_option('meta_data_position')): ?>
				<?php if(strlen($testimonial['client'])>0 || strlen($testimonial['position'])>0 ): ?>
				<p>
					<cite><?=$testimonial['client'];?><br/><?=$testimonial['position'];?></cite>
				</p>	
				<?php endif; ?>
			<?php endif; ?>
			<p>
				<?=$testimonial['content'];?>
				<?php if(strlen($testimonials_link)>2):?><a href="<?php echo $testimonials_link; ?>">Read More</a><?php endif; ?>
			</p>	
			<?php if(!get_option('meta_data_position')): ?>			
				<?php if(strlen($testimonial['client'])>0 || strlen($testimonial['position'])>0 ): ?>
				<p>
					<cite><?=$testimonial['client'];?><br/><?=$testimonial['position'];?></cite>
				</p>	
				<?php endif; ?>
			<?php endif; ?>
		</blockquote><?php 	
	endwhile;	
	wp_reset_query();
	
	$content = ob_get_contents();
	ob_end_clean();	
	
	return $content;
}

//register any widgets here
function easy_testimonials_register_widgets() {
	include('random_testimonial_widget.php');

	register_widget( 'randomTestimonialWidget' );
}

//create shortcodes
add_shortcode('random_testimonial', 'outputRandomTestimonial');
add_shortcode('testimonials', 'outputTestimonials');

//add CSS
add_action( 'wp_head', 'ik_setup_css' );

//register sidebar widgets
add_action( 'widgets_init', 'easy_testimonials_register_widgets' );

//do stuff
add_action( 'after_setup_theme', 'ik_setup_testimonials' );
?>