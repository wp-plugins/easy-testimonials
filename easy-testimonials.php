<?php
/*
Plugin Name: Easy Testimonials
Plugin URI: http://goldplugins.com/our-plugins/easy-testimonials-details/
Description: Easy Testimonials - Provides custom post type, shortcode, sidebar widget, and other functionality for testimonials.
Author: Gold Plugins
Version: 1.10
Author URI: http://goldplugins.com

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

global $easy_t_footer_css_output;

include('include/lib/lib.php');

//setup JS
function easy_testimonials_setup_js() {
	$disable_cycle2 = get_option('easy_t_disable_cycle2');
	$use_cycle_fix = get_option('easy_t_use_cycle_fix');

	if(!$disable_cycle2){
		wp_enqueue_script(
			'cycle2',
			plugins_url('include/js/jquery.cycle2.min.js', __FILE__),
			array( 'jquery' ),
			false,
			true
		);  
		
		if($use_cycle_fix){
			wp_enqueue_script(
				'easy-testimonials',
				plugins_url('include/js/easy-testimonials-cycle-fix.js', __FILE__),
				array( 'jquery' ),
				false,
				true
			);
		}
		
		if(isValidKey()){  
			wp_enqueue_script(
				'easy-testimonials',
				plugins_url('include/js/easy-testimonials.js', __FILE__),
				array( 'jquery' ),
				false,
				true
			);
			wp_enqueue_script(
				'rateit',
				plugins_url('include/js/jquery.rateit.min.js', __FILE__),
				array( 'jquery' ),
				false,
				true
			);
		}
	}
}

//add Testimonial CSS to header
function easy_testimonials_setup_css() {
	wp_register_style( 'easy_testimonial_style', plugins_url('include/css/style.css', __FILE__) );
	wp_register_style( 'easy_testimonial_dark_style', plugins_url('include/css/dark_style.css', __FILE__) );	
	wp_register_style( 'easy_testimonial_light_style', plugins_url('include/css/light_style.css', __FILE__) );
	wp_register_style( 'easy_testimonial_blue_style', plugins_url('include/css/blue_style.css', __FILE__) );
	wp_register_style( 'easy_testimonial_clean_style', plugins_url('include/css/clean_style.css', __FILE__) );
	wp_register_style( 'easy_testimonial_no_style', plugins_url('include/css/no_style.css', __FILE__) );
	
	if(isValidKey()){ 
		//five star ratings
		wp_register_style( 'easy_testimonial_rateit_style', plugins_url('include/css/rateit.css', __FILE__) );
		//bubble
		wp_register_style( 'easy_testimonial_bubble_style', plugins_url('include/css/bubble_style.css', __FILE__) );
		wp_register_style( 'easy_testimonial_bubble_style-brown', plugins_url('include/css/bubble_style-brown.css', __FILE__) );
		wp_register_style( 'easy_testimonial_bubble_style-pink', plugins_url('include/css/bubble_style-pink.css', __FILE__) );
		wp_register_style( 'easy_testimonial_bubble_style-blue-orange', plugins_url('include/css/bubble_style-blue-orange.css', __FILE__) );
		wp_register_style( 'easy_testimonial_bubble_style-red-grey', plugins_url('include/css/bubble_style-red-grey.css', __FILE__) );
		wp_register_style( 'easy_testimonial_bubble_style-purple-green', plugins_url('include/css/bubble_style-purple-green.css', __FILE__) );
		//left avatar, 150x150
		wp_register_style( 'easy_testimonial_avatar-left-style', plugins_url('include/css/avatar-left.css', __FILE__) );
		wp_register_style( 'easy_testimonial_avatar-left-style-blue-orange', plugins_url('include/css/avatar-left-blue-orange.css', __FILE__) );
		wp_register_style( 'easy_testimonial_avatar-left-style-brown', plugins_url('include/css/avatar-left-brown.css', __FILE__) );
		wp_register_style( 'easy_testimonial_avatar-left-style-pink', plugins_url('include/css/avatar-left-pink.css', __FILE__) );
		wp_register_style( 'easy_testimonial_avatar-left-style-purple-green', plugins_url('include/css/avatar-left-purple-green.css', __FILE__) );
		wp_register_style( 'easy_testimonial_avatar-left-style-red-grey', plugins_url('include/css/avatar-left-red-grey.css', __FILE__) );
		//left avatar, 50x50
		wp_register_style( 'easy_testimonial_avatar-left-style-50x50', plugins_url('include/css/avatar-left-50x50.css', __FILE__) );
		wp_register_style( 'easy_testimonial_avatar-left-style-50x50-blue-orange', plugins_url('include/css/avatar-left-50x50-blue-orange.css', __FILE__) );
		wp_register_style( 'easy_testimonial_avatar-left-style-50x50-brown', plugins_url('include/css/avatar-left-50x50-brown.css', __FILE__) );
		wp_register_style( 'easy_testimonial_avatar-left-style-50x50-pink', plugins_url('include/css/avatar-left-50x50-pink.css', __FILE__) );
		wp_register_style( 'easy_testimonial_avatar-left-style-50x50-purple-green', plugins_url('include/css/avatar-left-50x50-purple-green.css', __FILE__) );
		wp_register_style( 'easy_testimonial_avatar-left-style-50x50-red-grey', plugins_url('include/css/avatar-left-50x50-red-grey.css', __FILE__) );
		//right avatar, 150x150
		wp_register_style( 'easy_testimonial_avatar-right-style', plugins_url('include/css/avatar-right.css', __FILE__) );
		wp_register_style( 'easy_testimonial_avatar-right-style-blue-orange', plugins_url('include/css/avatar-right-blue-orange.css', __FILE__) );
		wp_register_style( 'easy_testimonial_avatar-right-style-brown', plugins_url('include/css/avatar-right-brown.css', __FILE__) );
		wp_register_style( 'easy_testimonial_avatar-right-style-pink', plugins_url('include/css/avatar-right-pink.css', __FILE__) );
		wp_register_style( 'easy_testimonial_avatar-right-style-purple-green', plugins_url('include/css/avatar-right-purple-green.css', __FILE__) );
		wp_register_style( 'easy_testimonial_avatar-right-style-red-grey', plugins_url('include/css/avatar-right-red-grey.css', __FILE__) );
		//right avatar, 50x50
		wp_register_style( 'easy_testimonial_avatar-right-style-50x50', plugins_url('include/css/avatar-right-50x50.css', __FILE__) );
		wp_register_style( 'easy_testimonial_avatar-right-style-50x50-blue-orange', plugins_url('include/css/avatar-right-50x50-blue-orange.css', __FILE__) );
		wp_register_style( 'easy_testimonial_avatar-right-style-50x50-brown', plugins_url('include/css/avatar-right-50x50-brown.css', __FILE__) );
		wp_register_style( 'easy_testimonial_avatar-right-style-50x50-pink', plugins_url('include/css/avatar-right-50x50-pink.css', __FILE__) );
		wp_register_style( 'easy_testimonial_avatar-right-style-50x50-purple-green', plugins_url('include/css/avatar-right-50x50-purple-green.css', __FILE__) );
		wp_register_style( 'easy_testimonial_avatar-right-style-50x50-red-grey', plugins_url('include/css/avatar-right-50x50-red-grey.css', __FILE__) );
	}
	
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
		case 'clean_style':
			wp_enqueue_style( 'easy_testimonial_clean_style' );
			break;
		case 'no_style':
			//wp_enqueue_style( 'easy_testimonial_no_style' );
			break;
		//bubble
		case 'bubble_style':
			if(isValidKey()){
				wp_enqueue_style( 'easy_testimonial_bubble_style' );
			}
			break;
		case 'bubble_style-brown':
			if(isValidKey()){
				wp_enqueue_style( 'easy_testimonial_bubble_style-brown' );
			}
			break;
		case 'bubble_style-pink':
			if(isValidKey()){
				wp_enqueue_style( 'easy_testimonial_bubble_style-pink' );
			}
			break;
		case 'bubble_style-blue-orange':
			if(isValidKey()){
				wp_enqueue_style( 'easy_testimonial_bubble_style-blue-orange' );
			}
			break;
		case 'bubble_style-red-grey':
			if(isValidKey()){
				wp_enqueue_style( 'easy_testimonial_bubble_style-red-grey' );
			}
			break;
		case 'bubble_style-purple-green':
			if(isValidKey()){
				wp_enqueue_style( 'easy_testimonial_bubble_style-purple-green' );
			}
			break;
		//left avatar, 150x150
		case 'avatar-left-style':
			if(isValidKey()){
				wp_enqueue_style( 'easy_testimonial_avatar-left-style' );
			}
			break;
		case 'avatar-left-style-blue-orange':
			if(isValidKey()){
				wp_enqueue_style( 'easy_testimonial_avatar-left-style-blue-orange' );
			}
			break;
		case 'avatar-left-style-pink':
			if(isValidKey()){
				wp_enqueue_style( 'easy_testimonial_avatar-left-style-pink' );
			}
			break;
		case 'avatar-left-style-brown':
			if(isValidKey()){
				wp_enqueue_style( 'easy_testimonial_avatar-left-style-brown' );
			}
			break;
		case 'avatar-left-style-red-grey':
			if(isValidKey()){
				wp_enqueue_style( 'easy_testimonial_avatar-left-style-red-grey' );
			}
			break;
		case 'avatar-left-style-purple-green':
			if(isValidKey()){
				wp_enqueue_style( 'easy_testimonial_avatar-left-style-purple-green' );
			}
			break;
		//left avatar, 50x50
		case 'avatar-left-style-50x50':
			if(isValidKey()){
				wp_enqueue_style( 'easy_testimonial_avatar-left-style-50x50' );
			}
			break;
		case 'avatar-left-style-50x50-blue-orange':
			if(isValidKey()){
				wp_enqueue_style( 'easy_testimonial_avatar-left-style-50x50-blue-orange' );
			}
			break;
		case 'avatar-left-style-50x50-brown':
			if(isValidKey()){
				wp_enqueue_style( 'easy_testimonial_avatar-left-style-50x50-brown' );
			}
			break;
		case 'avatar-left-style-50x50-pink':
			if(isValidKey()){
				wp_enqueue_style( 'easy_testimonial_avatar-left-style-50x50-pink' );
			}
			break;
		case 'avatar-left-style-50x50-purple-green':
			if(isValidKey()){
				wp_enqueue_style( 'easy_testimonial_avatar-left-style-50x50-purple-green' );
			}
			break;
		case 'avatar-left-style-50x50-red-grey':
			if(isValidKey()){
				wp_enqueue_style( 'easy_testimonial_avatar-left-style-50x50-red-grey' );
			}
			break;
		//right avatar, 150x150
		case 'avatar-right-style':
			if(isValidKey()){
				wp_enqueue_style( 'easy_testimonial_avatar-right-style' );
			}
			break;
		case 'avatar-right-style-blue-orange':
			if(isValidKey()){
				wp_enqueue_style( 'easy_testimonial_avatar-right-style-blue-orange' );
			}
			break;
		case 'avatar-right-style-pink':
			if(isValidKey()){
				wp_enqueue_style( 'easy_testimonial_avatar-right-style-pink' );
			}
			break;
		case 'avatar-right-style-brown':
			if(isValidKey()){
				wp_enqueue_style( 'easy_testimonial_avatar-right-style-brown' );
			}
			break;
		case 'avatar-right-style-red-grey':
			if(isValidKey()){
				wp_enqueue_style( 'easy_testimonial_avatar-right-style-red-grey' );
			}
			break;
		case 'avatar-right-style-purple-green':
			if(isValidKey()){
				wp_enqueue_style( 'easy_testimonial_avatar-right-style-purple-green' );
			}
			break;
		//left avatar, 50x50
		case 'avatar-right-style-50x50':
			if(isValidKey()){
				wp_enqueue_style( 'easy_testimonial_avatar-right-style-50x50' );
			}
			break;
		case 'avatar-right-style-50x50-blue-orange':
			if(isValidKey()){
				wp_enqueue_style( 'easy_testimonial_avatar-right-style-50x50-blue-orange' );
			}
			break;
		case 'avatar-right-style-50x50-brown':
			if(isValidKey()){
				wp_enqueue_style( 'easy_testimonial_avatar-right-style-50x50-brown' );
			}
			break;
		case 'avatar-right-style-50x50-pink':
			if(isValidKey()){
				wp_enqueue_style( 'easy_testimonial_avatar-right-style-50x50-pink' );
			}
			break;
		case 'avatar-right-style-50x50-purple-green':
			if(isValidKey()){
				wp_enqueue_style( 'easy_testimonial_avatar-right-style-50x50-purple-green' );
			}
			break;
		case 'avatar-right-style-50x50-red-grey':
			if(isValidKey()){
				wp_enqueue_style( 'easy_testimonial_avatar-right-style-50x50-red-grey' );
			}
			break;
		case 'default_style':
		default:
			wp_enqueue_style( 'easy_testimonial_style' );
			break;
	}
	
	//five star rating CSS file
	if(isValidKey()){
		wp_enqueue_style( 'easy_testimonial_rateit_style' );
	}
}

function easy_t_send_notification_email(){
	//get e-mail address from post meta field
	$email_address = get_option('easy_t_submit_notification_address', get_bloginfo('admin_email'));
 
	$subject = "New Easy Testimonial Submission on " . get_bloginfo('name');
	$body = "You have received a new submission with Easy Testimonials on your site, " . get_bloginfo('name') . ".  Login and see what they had to say!";
 
	//use this to set the From address of the e-mail
	$headers = 'From: ' . get_bloginfo('name') . ' <'.get_bloginfo('admin_email').'>' . "\r\n";
 
	if(wp_mail($email_address, $subject, $body, $headers)){
		//mail sent!
	} else {
		//failure!
	}
}
	
function easy_t_check_captcha() {
	$captcha = new ReallySimpleCaptcha();
	// This variable holds the CAPTCHA image prefix, which corresponds to the correct answer
	$captcha_prefix = $_POST['captcha_prefix'];
	// This variable holds the CAPTCHA response, entered by the user
	$captcha_code = $_POST['captcha_code'];
	// This variable will hold the result of the CAPTCHA validation. Set to 'false' until CAPTCHA validation passes
	$captcha_correct = false;
	// Validate the CAPTCHA response
	$captcha_check = $captcha->check( $captcha_prefix, $captcha_code );
	// Set to 'true' if validation passes, and 'false' if validation fails
	$captcha_correct = $captcha_check;
	// clean up the tmp directory
	$captcha->remove($captcha_prefix);
	$captcha->cleanup();
	
	return $captcha_correct;
}	
	
function easy_t_outputCaptcha(){
	// Instantiate the ReallySimpleCaptcha class, which will handle all of the heavy lifting
	$captcha = new ReallySimpleCaptcha();
	 
	// ReallySimpleCaptcha class option defaults.
	// Changing these values will hav no impact. For now, these are here merely for reference.
	// If you want to configure these options, see "Set Really Simple CAPTCHA Options", below
	$captcha_defaults = array(
		'chars' => 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789',
		'char_length' => '4',
		'img_size' => array( '72', '24' ),
		'fg' => array( '0', '0', '0' ),
		'bg' => array( '255', '255', '255' ),
		'font_size' => '16',
		'font_char_width' => '15',
		'img_type' => 'png',
		'base' => array( '6', '18'),
	);
	 
	/**************************************
	* All configurable options are below  *
	***************************************/
	 
	//Set Really Simple CAPTCHA Options
	$captcha->chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
	$captcha->char_length = '4';
	$captcha->img_size = array( '100', '50' );
	$captcha->fg = array( '0', '0', '0' );
	$captcha->bg = array( '255', '255', '255' );
	$captcha->font_size = '16';
	$captcha->font_char_width = '15';
	$captcha->img_type = 'png';
	$captcha->base = array( '6', '18' );
	 
	/********************************************************************
	* Nothing else to edit.  No configurable options below this point.  *
	*********************************************************************/
	 
	// Generate random word and image prefix
	$captcha_word = $captcha->generate_random_word();
	$captcha_prefix = mt_rand();
	// Generate CAPTCHA image
	$captcha_image_name = $captcha->generate_image($captcha_prefix, $captcha_word);
	// Define values for CAPTCHA fields
	$captcha_image_url =  get_bloginfo('wpurl') . '/wp-content/plugins/really-simple-captcha/tmp/';
	$captcha_image_src = $captcha_image_url . $captcha_image_name;
	$captcha_image_width = $captcha->img_size[0];
	$captcha_image_height = $captcha->img_size[1];
	$captcha_field_size = $captcha->char_length;
	// Output the CAPTCHA fields
	?>
	<div class="easy_t_field_wrap">
		<img src="<?php echo $captcha_image_src; ?>"
		 alt="captcha"
		 width="<?php echo $captcha_image_width; ?>"
		 height="<?php echo $captcha_image_height; ?>" /><br/>
		<label for="captcha_code"><?php echo get_option('easy_t_captcha_field_label','Captcha'); ?></label><br/>
		<input id="captcha_code" name="captcha_code"
		 size="<?php echo $captcha_field_size; ?>" type="text" />
		<p class="easy_t_description"><?php echo get_option('easy_t_captcha_field_description','Enter the value in the image above into this field.'); ?></p>
		<input id="captcha_prefix" name="captcha_prefix" type="hidden"
		 value="<?php echo $captcha_prefix; ?>" />
	</div>
	<?php
}

//handle file upload for image in front end submission form
function easy_t_upload_user_file( $file = array(), $post_id ) {
    
    require_once( ABSPATH . 'wp-admin/includes/admin.php' );
    
    $file_return = wp_handle_upload( $file, array('test_form' => false ) );
    
	// Set an array containing a list of acceptable formats
	$allowed_file_types = array('image/jpg','image/jpeg','image/gif','image/png');
	
    if( isset( $file_return['error'] ) || isset( $file_return['upload_error_handler'] ) ) {
        return false;
    } else {
	
		//only uploaded file types that are allowed
		if(in_array($file_return['type'], $allowed_file_types)) {
        
			$filename = $file_return['file'];
			
			$attachment = array(
				'post_mime_type' => $file_return['type'],
				'post_title' => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
				'post_content' => '',
				'post_status' => 'inherit',
				'guid' => $file_return['url']
			);
			
			$attachment_id = wp_insert_attachment( $attachment, $file_return['url'] );
			
			require_once (ABSPATH . 'wp-admin/includes/image.php' );
			$attachment_data = wp_generate_attachment_metadata( $attachment_id, $filename );
			wp_update_attachment_metadata( $attachment_id, $attachment_data );
			
			if( 0 < intval( $attachment_id ) ) {
				//make this the testimonial's featured image
				set_post_thumbnail( $post_id, $attachment_id );
				
				return $attachment_id;
			}
		} else {
			return false;
		}
    }
    
    return false;
}
	
//submit testimonial shortcode
function submitTestimonialForm($atts){     
		ob_start();
		
        // process form submissions
        $inserted = false;
       
        if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] )) {
			if(isValidKey()){  
				$do_not_insert = false;
				
				if (isset ($_POST['the-title']) && strlen($_POST['the-title']) > 0) {
						$title =  $_POST['the-title'];
				} else {
						echo '<p class="easy_t_error">Please enter a ' . get_option('easy_t_title_field_label','title') . '.</p>';
						$do_not_insert = true;
				}
			   
				if (isset ($_POST['the-body']) && strlen($_POST['the-body']) > 0) {
						$body = $_POST['the-body'];
				} else {
						echo '<p class="easy_t_error">Please enter the ' . get_option('easy_t_body_content_field_label','body content') . '.</p>';
						$do_not_insert = true;
				}			
				
				if(class_exists('ReallySimpleCaptcha') && get_option('easy_t_use_captcha',0)){ 
					$correct = easy_t_check_captcha(); 
					if(!$correct){
						echo '<p class="easy_t_error">Captcha did not match.</p>';
						$do_not_insert = true;
					}
				}
			   
				if(!$do_not_insert){
					//snag custom fields
					$the_other = $the_name = '';					
					if (isset ($_POST['the-other'])) {
						$the_other = $_POST['the-other'];
					}
					if (isset ($_POST['the-name'])) {
						$the_name = $_POST['the-name'];
					}
					if (isset ($_POST['the-rating'])) {
						$the_rating = $_POST['the-rating'];
					}
					
					$tags = array();
				   
					$post = array(
						'post_title'    => $title,
						'post_content'  => $body,
						'post_category' => array(1),  // custom taxonomies too, needs to be an array
						'tags_input'    => $tags,
						'post_status'   => 'pending',
						'post_type'     => 'testimonial'
					);
				
					$new_id = wp_insert_post($post);
				   
					update_post_meta( $new_id, '_ikcf_client', $the_name );
					update_post_meta( $new_id, '_ikcf_position', $the_other );
					update_post_meta( $new_id, '_ikcf_rating', $the_rating );
				   
					$inserted = true;

					// do the wp_insert_post action to insert it
					do_action('wp_insert_post', 'wp_insert_post'); 
					
					//if the user has submitted a photo with their testimonial, handle the upload
					if( ! empty( $_FILES ) ) {
						foreach( $_FILES as $file ) {
							if( is_array( $file ) ) {
								$attachment_id = easy_t_upload_user_file( $file, $new_id );
							}
						}
					}
				}
			} else {
				echo "You must have a valid key to perform this action.";
            }
        }       
       
        $content = '';
       
        if(isValidKey()){ 		
			if($inserted){
				echo '<p class="easy_t_submission_success_message">' . get_option('easy_t_submit_success_message','Thank You For Your Submission!') . '</p>';
				easy_t_send_notification_email();
			} else { ?>
			<!-- New Post Form -->
			<div id="postbox">
					<form id="new_post" class="easy-testimonials-submission-form" name="new_post" method="post" enctype="multipart/form-data" >
							<div class="easy_t_field_wrap">
								<label for="the-title"><?php echo get_option('easy_t_title_field_label','Title'); ?></label><br />
								<input type="text" id="the-title" value="" tabindex="1" size="20" name="the-title" />
								<p class="easy_t_description"><?php echo get_option('easy_t_title_field_description','This is for internal reference, when viewing the Testimonials in the Dashboard.  This may also be displayed.'); ?></p>
							</div>
							<?php if(!get_option('easy_t_hide_name_field',false)): ?>
							<div class="easy_t_field_wrap">
								<label for="the-name"><?php echo get_option('easy_t_name_field_label','Name'); ?></label><br />
								<input type="text" id="the-name" value="" tabindex="2" size="20" name="the-name" />
								<p class="easy_t_description"><?php echo get_option('easy_t_name_field_description','This is the name of the entity leaving the Testimonial.  This will be displayed, along with Body Content and Other.'); ?></p>
							</div>
							<?php endif; ?>
							<?php if(!get_option('easy_t_hide_position_web_other_field',false)): ?>
							<div class="easy_t_field_wrap">
								<label for="the-other"><?php echo get_option('easy_t_position_web_other_field_label','Position / Web Address / Other'); ?></label><br />
								<input type="text" id="the-other" value="" tabindex="3" size="20" name="the-other" />
								<p class="easy_t_description"><?php echo get_option('easy_t_position_web_other_field_description','This is other identifying information of the entity leaving the Testimonial.  This will be displayed, along with Body Content and Name.'); ?></p>
							</div>
							<?php endif; ?>
							<?php if(get_option('easy_t_use_rating_field',false)): ?>
							<div class="easy_t_field_wrap">
								<label for="the-rating"><?php echo get_option('easy_t_rating_field_label','Your Rating'); ?></label><br />
								<select id="the-rating" tabindex="4" size="20" name="the-rating" >
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
								</select>
								<div class="rateit" data-rateit-backingfld="#the-rating" data-rateit-min="0"></div>
								<p class="easy_t_description"><?php echo get_option('easy_t_rating_field_description','1 - 5 out of 5, where 5/5 is the best and 1/5 is the worst.'); ?></p>
							</div>
							<?php endif; ?>
							<div class="easy_t_field_wrap">
								<label for="the-body"><?php echo get_option('easy_t_body_content_field_label','Body Content'); ?></label><br />
								<textarea id="the-body" name="the-body" cols="50" tabindex="5" rows="6"></textarea>
								<p class="easy_t_description"><?php echo get_option('easy_t_body_content_field_description','This is the body area of the Testimonial.'); ?></p>
							</div>							
							<?php if(get_option('easy_t_use_image_field',false)): ?>
							<div class="easy_t_field_wrap">
								<label for="the-image"><?php echo get_option('easy_t_image_field_label','Testimonial Image'); ?></label><br />
								<input type="file" id="the-image" value="" tabindex="6" size="20" name="the-image" />
								<p class="easy_t_description"><?php echo get_option('easy_t_image_field_description','You can select and upload 1 image along with your Testimonial.  Depending on the website\'s settings, this image may be cropped or resized.  Allowed file types are .gif, .jpg, .png, and .jpeg.'); ?></p>
							</div>
							<?php endif; ?>
		
							<?php if(class_exists('ReallySimpleCaptcha') && get_option('easy_t_use_captcha',0)){ easy_t_outputCaptcha(); } ?>
							
							<div class="easy_t_field_wrap"><input type="submit" value="<?php echo get_option('easy_t_submit_button_label','Submit Testimonial'); ?>" tabindex="7" id="submit" name="submit" /></div>
							<input type="hidden" name="action" value="post" />
							<?php wp_nonce_field( 'new-post' ); ?>
					</form>
			</div>
			<!--// New Post Form -->
			<?php }
		   
			$content = ob_get_contents();
			ob_end_clean(); 
        }
       
        return $content;
}

//add Custom CSS
function easy_testimonials_setup_custom_css() {
	//use this to track if css has been output
	global $easy_t_footer_css_output;
	
	if($easy_t_footer_css_output){
		return;
	} else {
		echo '<style type="text/css" media="screen">' . get_option('easy_t_custom_css') . "</style>";
		$easy_t_footer_css_output = true;
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
function easy_testimonials_setup_testimonials(){
	//include custom post type code
	include('include/lib/ik-custom-post-type.php');
	//include options code
	include('include/easy_testimonial_options.php');	
	$easy_testimonial_options = new easyTestimonialOptions();
			
	//setup post type for testimonials
	$postType = array('name' => 'Testimonial', 'plural' =>'Testimonials', 'slug' => 'testimonial' );
	$fields = array(); 
	$fields[] = array('name' => 'client', 'title' => 'Client Name', 'description' => "Name of the Client giving the testimonial.  Appears below the Testimonial.", 'type' => 'text'); 
	$fields[] = array('name' => 'position', 'title' => 'Position / Location / Other', 'description' => "The information that appears below the client's name.", 'type' => 'text');  
	$fields[] = array('name' => 'rating', 'title' => 'Rating', 'description' => "The client's rating, if submitted along with their testimonial.  This can be displayed below the client's position, or name if the position is hidden, or it can be displayed above the testimonial text.", 'type' => 'text');  
	$myCustomType = new ikTestimonialsCustomPostType($postType, $fields);
	register_taxonomy( 'easy-testimonial-category', 'testimonial', array( 'hierarchical' => true, 'label' => __('Testimonial Category'), 'rewrite' => array('slug' => 'testimonial', 'with_front' => false) ) ); 
	
	//load list of current posts that have featured images	
	$supportedTypes = get_theme_support( 'post-thumbnails' );
	
	//none set, add them just to our type
    if( $supportedTypes === false ){
        add_theme_support( 'post-thumbnails', array( 'testimonial' ) );       
		//for the testimonial thumb images    
	}
	//specifics set, add our to the array
    elseif( is_array( $supportedTypes ) ){
        $supportedTypes[0][] = 'testimonial';
        add_theme_support( 'post-thumbnails', $supportedTypes[0] );
		//for the testimonial thumb images
    }
	//if neither of the above hit, the theme in general supports them for everything.  that includes us!
	
	add_image_size( 'easy_testimonial_thumb', 50, 50, true );
}

//from http://codex.wordpress.org/Function_Reference/get_intermediate_image_sizes
function easy_t_output_image_options(){
	global $_wp_additional_image_sizes;
	$sizes = array();
	foreach( get_intermediate_image_sizes() as $s ){
		$sizes[ $s ] = array( 0, 0 );
		if( in_array( $s, array( 'thumbnail', 'medium', 'large' ) ) ){
			$sizes[ $s ][0] = get_option( $s . '_size_w' );
			$sizes[ $s ][1] = get_option( $s . '_size_h' );
		}else{
			if( isset( $_wp_additional_image_sizes ) && isset( $_wp_additional_image_sizes[ $s ] ) )
				$sizes[ $s ] = array( $_wp_additional_image_sizes[ $s ]['width'], $_wp_additional_image_sizes[ $s ]['height'], );
		}
	}

	$current_size = get_option('easy_t_image_size');
	
	foreach( $sizes as $size => $atts ){
		$disabled = '';
		$selected = '';
		$register = '';
		
		if(!isValidKey()){
			$disabled = 'disabled="DISABLED"';
			$current_size = 'easy_testimonial_thumb';
			$register = " - Register to Enable!";
		}
		if($current_size == $size){
			$selected = 'selected="SELECTED"';
			$disabled = '';
			$register = '';
		}
		echo "<option value='".$size."' ".$disabled . " " . $selected.">" . ucwords(str_replace("-", " ", str_replace("_", " ", $size))) . ' ' . implode( 'x', $atts ) . $register . "</option>";
	}
}
 
//this is the heading of the new column we're adding to the testimonial posts list
function easy_t_column_head($defaults) {  
	$defaults = array_slice($defaults, 0, 2, true) +
    array("single_shortcode" => "Shortcode") +
    array_slice($defaults, 2, count($defaults)-2, true);
    return $defaults;  
}  

//this content is displayed in the testimonial post list
function easy_t_columns_content($column_name, $post_ID) {  
    if ($column_name == 'single_shortcode') {  
		echo "<code>[single_testimonial id={$post_ID}]</code>";
    }  
} 

//this is the heading of the new column we're adding to the testimonial category list
function easy_t_cat_column_head($defaults) {  
	$defaults = array_slice($defaults, 0, 2, true) +
    array("single_shortcode" => "Shortcode") +
    array_slice($defaults, 2, count($defaults)-2, true);
    return $defaults;  
}  

//this content is displayed in the testimonial category list
function easy_t_cat_columns_content($value, $column_name, $tax_id) {  

	$category = get_term_by('id', $tax_id, 'easy-testimonial-category');
	
	return "<code>[testimonials category='{$category->slug}']</code>"; 
} 

//load testimonials into an array and output a random one
function outputRandomTestimonial($atts){
	//load shortcode attributes into an array
	extract( shortcode_atts( array(
		'testimonials_link' => get_option('testimonials_link'),
		'count' => 1,
		'word_limit' => false,
		'body_class' => 'testimonial_body',
		'author_class' => 'testimonial_author',
		'show_title' => 0,
		'short_version' => false,
		'use_excerpt' => false,
		'category' => '',
		'show_thumbs' => '',
		'show_rating' => false
	), $atts ) );
	
	$show_thumbs = ($show_thumbs == '') ? get_option('testimonials_image') : $show_thumbs;
	
	//load testimonials into an array
	$i = 0;
	$loop = new WP_Query(array( 'post_type' => 'testimonial','posts_per_page' => '-1', 'easy-testimonial-category' => $category));
	while($loop->have_posts()) : $loop->the_post();
		$postid = get_the_ID();	

		//load rating
		//if set, append english text to it
		$testimonials[$i]['rating'] = get_post_meta($postid, '_ikcf_rating', true); 
		if(strlen($testimonials[$i]['rating'])>0){
			$testimonials[$i]['rating'] = '<span class="easy_t_ratings">' . $testimonials[$i]['rating'] . '/5 Stars.</span>';
		}	

		if($use_excerpt){
			$testimonials[$i]['content'] = get_the_excerpt();
		} else {				
			$testimonials[$i]['content'] = get_the_content();
		}
		
		//if nothing is set for the short content, use the long content
		if(strlen($testimonials[$i]['content']) < 2){
			$temp_post_content = get_post($postid); 			
			if($use_excerpt){
				$testimonials[$i]['content'] = $temp_post_content->post_excerpt;
				if($testimonials[$i]['content'] == ''){
					$testimonials[$i]['content'] = wp_trim_excerpt($temp_post_content->post_content);
				}
			} else {				
				$testimonials[$i]['content'] = $temp_post_content->post_content;
			}
		}
		
		if ($word_limit) {
			$testimonials[$i]['content'] = word_trim($testimonials[$i]['content'], 65, TRUE);
		}
			
		if(strlen($show_rating)>2){
			if($show_rating == "before"){
				$testimonials[$i]['content'] = $testimonials[$i]['rating'] . ' ' . $testimonials[$i]['content'];
			}
			if($show_rating == "after"){
				$testimonials[$i]['content'] =  $testimonials[$i]['content'] . ' ' . $testimonials[$i]['rating'];
			}
		}
		
		if ($show_thumbs) {
			$testimonial_image_size = isValidKey() ? get_option('easy_t_image_size') : "easy_testimonial_thumb";
			if(strlen($testimonial_image_size) < 2){
				$testimonial_image_size = "easy_testimonial_thumb";
			}
			
			$testimonials[$i]['image'] = get_the_post_thumbnail($postid, $testimonial_image_size);
			if (strlen($testimonials[$i]['image']) < 2 && get_option('easy_t_mystery_man')){
				$testimonials[$i]['image'] = '<img class="attachment-easy_testimonial_thumb wp-post-image" src="' . plugins_url('include/css/mystery_man.png', __FILE__) . '" />';
			}
		}
		
		$testimonials[$i]['title'] = get_the_title($postid);
		
		$testimonials[$i]['client'] = get_post_meta($postid, '_ikcf_client', true); 	
		$testimonials[$i]['position'] = get_post_meta($postid, '_ikcf_position', true); 
		
		$i++;
	endwhile;
	wp_reset_query();
	
	$randArray = UniqueRandomNumbersWithinRange(0,$i-1,$count);
	
	ob_start();
	
	foreach($randArray as $key => $rand){
		if(isset($testimonials[$rand])){
			if(!$short_version){	
				?><blockquote class="easy_testimonial">		
					
					<?php if ($show_thumbs) {
						echo $testimonials[$rand]['image'];
					} ?>
					
					<?php if ($show_title) {
						echo '<p class="easy_testimonial_title">' . $testimonials[$rand]['title'] . '</p>';
					} ?>	
					
					<?php if(get_option('meta_data_position')): ?>
						<p class="<?php echo $author_class; ?>">
							<?php if(strlen($testimonials[$rand]['client'])>0 || strlen($testimonials[$rand]['position'])>0 ): ?>
							<cite><span class="testimonial-client"><?php echo $testimonials[$rand]['client'];?></span><br/><span class="testimonial-position"><?php echo $testimonials[$rand]['position'];?></span></cite>
							<?php endif; ?>
						</p>	
					<?php endif; ?>
					<div class="<?php echo $body_class; ?>">
						<?php if(get_option('easy_t_apply_content_filter',false)): ?>
							<?php echo apply_filters('the_content',$testimonials[$rand]['content']); ?>
						<?php else:?>
							<?php echo wpautop($testimonials[$rand]['content']); ?>
						<?php endif;?>
						<?php if(strlen($testimonials_link)>2):?><a class="easy_testimonials_read_more_link" href="<?php echo $testimonials_link; ?>">Read More</a><?php endif; ?>
					</div>			
					<?php if(!get_option('meta_data_position')): ?>	
						<p class="<?php echo $author_class; ?>">
							<?php if(strlen($testimonials[$rand]['client'])>0 || strlen($testimonials[$rand]['position'])>0 ): ?>
							<cite><span class="testimonial-client"><?php echo $testimonials[$rand]['client'];?></span><br/><span class="testimonial-position"><?php echo $testimonials[$rand]['position'];?></span></cite>
							<?php endif; ?>
						</p>	
					<?php endif; ?>
				</blockquote><?php
			} else {
				echo $testimonials[$rand]['content'];
			}
		}
	}
	
	$content = ob_get_contents();
	ob_end_clean();
	
	return $content;
}

//return an array of random numbers within a given range
//credit: http://stackoverflow.com/questions/5612656/generating-unique-random-numbers-within-a-range-php
function UniqueRandomNumbersWithinRange($min, $max, $quantity) {
    $numbers = range($min, $max);
    shuffle($numbers);
    return array_slice($numbers, 0, $quantity);
}

//output specific testimonial
function outputSingleTestimonial($atts){ 
	//load shortcode attributes into an array
	extract( shortcode_atts( array(
		'testimonials_link' => get_option('testimonials_link'),
		'show_title' => 0,
		'body_class' => 'testimonial_body',
		'author_class' => 'testimonial_author',
		'id' => '',
		'use_excerpt' => false,
		'show_thumbs' => '',
		'short_version' => false,
		'word_limit' => false,
		'show_rating' => false
	), $atts ) );
	
	$show_thumbs = ($show_thumbs == '') ? get_option('testimonials_image') : $show_thumbs;
	
	ob_start();
	
	$i = 0;
	
	//load testimonials into an array
	$loop = new WP_Query(array( 'post_type' => 'testimonial','p' => $id));
	while($loop->have_posts()) : $loop->the_post();
		$postid = get_the_ID();
		
		$testimonial['client'] = get_post_meta($postid, '_ikcf_client', true); 	
		$testimonial['position'] = get_post_meta($postid, '_ikcf_position', true); 

		//load rating
		//if set, append english text to it
		$testimonial['rating'] = get_post_meta($postid, '_ikcf_rating', true); 
		if(strlen($testimonial['rating'])>0){
			$testimonial['rating'] = '<span class="easy_t_ratings">' . $testimonial['rating'] . '/5 Stars.</span>';
		}	
		
		if($use_excerpt){
			$testimonial['content'] = get_the_excerpt();
		} else {				
			$testimonial['content'] = get_the_content();
		}
		
		//if nothing is set for the short content, use the long content
		if(strlen($testimonial['content']) < 2){
			$temp_post_content = get_post($postid); 			
				$testimonial['content'] = $temp_post_content->post_excerpt;
			if($use_excerpt){
				if($testimonial['content'] == ''){
					$testimonial['content'] = wp_trim_excerpt($temp_post_content->post_content);
				}
			} else {				
				$testimonial['content'] = $temp_post_content->post_content;
			}
		}
			
		if(strlen($show_rating)>2){
			if($show_rating == "before"){
				$testimonial['content'] = $testimonial['rating'] . ' ' . $testimonial['content'];
			}
			if($show_rating == "after"){
				$testimonial['content'] =  $testimonial['content'] . ' ' . $testimonial['rating'];
			}
		}
		
		if ($show_thumbs) {		
			$testimonial_image_size = isValidKey() ? get_option('easy_t_image_size') : "easy_testimonial_thumb";
			if(strlen($testimonial_image_size) < 2){
				$testimonial_image_size = "easy_testimonial_thumb";
			}
			
			$testimonial['image'] = get_the_post_thumbnail($postid, $testimonial_image_size);
			if (strlen($testimonial['image']) < 2 && get_option('easy_t_mystery_man')){
				$testimonial['image'] = '<img class="attachment-easy_testimonial_thumb wp-post-image" src="' . plugins_url('include/css/mystery_man.png', __FILE__) . '" />';
			}
		}
		
		$testimonial['client'] = get_post_meta($postid, '_ikcf_client', true); 	
		$testimonial['position'] = get_post_meta($postid, '_ikcf_position', true); 
	
		?><blockquote class="easy_testimonial">		
			<?php if ($show_thumbs) {
				echo $testimonial['image'];
			} ?>		
			<?php if ($show_title) {
				echo '<p class="easy_testimonial_title">' . get_the_title($postid) . '</p>';
			} ?>	
			<?php if(get_option('meta_data_position')): ?>
				<p class="<?php echo $author_class; ?>">
					<?php if(strlen($testimonial['client'])>0 || strlen($testimonial['position'])>0 ): ?>
					<cite><span class="testimonial-client"><?php echo $testimonial['client'];?></span><br/><span class="testimonial-position"><?php echo $testimonial['position'];?></span></cite>
					<?php endif; ?>
				</p>	
			<?php endif; ?>
			<div class="<?php echo $body_class; ?>">
				<?php if(get_option('easy_t_apply_content_filter',false)): ?>
					<?php echo apply_filters('the_content',$testimonial['content']); ?>
				<?php else:?>
					<?php echo wpautop($testimonial['content']); ?>
				<?php endif;?>
				<?php if(strlen($testimonials_link)>2):?><a href="<?php echo $testimonials_link; ?>" class="easy_testimonials_read_more_link">Read More</a><?php endif; ?>
			</div>	
			<?php if(!get_option('meta_data_position')): ?>			
				<p class="<?php echo $author_class; ?>">
					<?php if(strlen($testimonial['client'])>0 || strlen($testimonial['position'])>0 ): ?>
					<cite><span class="testimonial-client"><?php echo $testimonial['client'];?></span><br/><span class="testimonial-position"><?php echo $testimonial['position'];?></span></cite>
					<?php endif; ?>
				</p>	
			<?php endif; ?>
		</blockquote><?php 	
			
	endwhile;	
	wp_reset_query();
	
	$content = ob_get_contents();
	ob_end_clean();	
	
	return $content;
}

//output all testimonials
function outputTestimonials($atts){ 
	
	//load shortcode attributes into an array
	extract( shortcode_atts( array(	
		'testimonials_link' => get_option('testimonials_link'),
		'show_title' => 0,
		'count' => -1,
		'body_class' => 'testimonial_body',
		'author_class' => 'testimonial_author',
		'id' => '',
		'use_excerpt' => false,
		'category' => '',
		'show_thumbs' => '',
		'short_version' => false,
		'orderby' => 'date',//'none','ID','author','title','name','date','modified','parent','rand','menu_order'
		'order' => 'ASC',//'DESC'
		'show_rating' => false
	), $atts ) );
	
	$show_thumbs = ($show_thumbs == '') ? get_option('testimonials_image') : $show_thumbs;
			
	if(!is_numeric($count)){
		$count = -1;
	}
	
	ob_start();
	
	$i = 0;
	
	//load testimonials into an array
	$loop = new WP_Query(array( 'post_type' => 'testimonial','posts_per_page' => $count, 'easy-testimonial-category' => $category, 'orderby' => $orderby, 'order' => $order, 'paged' => get_query_var( 'paged' )));
	while($loop->have_posts()) : $loop->the_post();
		$postid = get_the_ID();	
		
		if($use_excerpt){
			$testimonial['content'] = get_the_excerpt();
		} else {				
			$testimonial['content'] = get_the_content();
		}

		//load rating
		//if set, append english text to it
		$testimonial['rating'] = get_post_meta($postid, '_ikcf_rating', true); 
		if(strlen($testimonial['rating'])>0){
			$testimonial['rating'] = '<span class="easy_t_ratings">' . $testimonial['rating'] . '/5 Stars.</span>';
		}	
		
		//if nothing is set for the short content, use the long content
		if(strlen($testimonial['content']) < 2){
			$temp_post_content = get_post($postid); 			
				$testimonial['content'] = $temp_post_content->post_excerpt;
			if($use_excerpt){
				if($testimonial['content'] == ''){
					$testimonial['content'] = wp_trim_excerpt($temp_post_content->post_content);
				}
			} else {				
				$testimonial['content'] = $temp_post_content->post_content;
			}
		}
			
		if(strlen($show_rating)>2){
			if($show_rating == "before"){
				$testimonial['content'] = $testimonial['rating'] . ' ' . $testimonial['content'];
			}
			if($show_rating == "after"){
				$testimonial['content'] =  $testimonial['content'] . ' ' . $testimonial['rating'];
			}
		}
		
		if ($show_thumbs) {		
			$testimonial_image_size = isValidKey() ? get_option('easy_t_image_size') : "easy_testimonial_thumb";
			if(strlen($testimonial_image_size) < 2){
				$testimonial_image_size = "easy_testimonial_thumb";
			}
		
			$testimonial['image'] = get_the_post_thumbnail($postid, $testimonial_image_size);
			if (strlen($testimonial['image']) < 2 && get_option('easy_t_mystery_man')){
				$testimonial['image'] = '<img class="attachment-easy_testimonial_thumb wp-post-image" src="' . plugins_url('include/css/mystery_man.png', __FILE__) . '" />';
			}
		}
		
		$testimonial['client'] = get_post_meta($postid, '_ikcf_client', true); 	
		$testimonial['position'] = get_post_meta($postid, '_ikcf_position', true); 	
	
		?><blockquote class="easy_testimonial">		
			<?php if ($show_thumbs) {
				echo $testimonial['image'];
			} ?>		
			<?php if ($show_title) {
				echo '<p class="easy_testimonial_title">' . get_the_title($postid) . '</p>';
			} ?>	
			<?php if(get_option('meta_data_position')): ?>
				<p class="<?php echo $author_class; ?>">
					<?php if(strlen($testimonial['client'])>0 || strlen($testimonial['position'])>0 ): ?>
					<cite><span class="testimonial-client"><?php echo $testimonial['client'];?></span><br/><span class="testimonial-position"><?php echo $testimonial['position'];?></span></cite>
					<?php endif; ?>
				</p>	
			<?php endif; ?>
			<div class="<?php echo $body_class; ?>">
				<?php if(get_option('easy_t_apply_content_filter',false)): ?>
					<?php echo apply_filters('the_content',$testimonial['content']); ?>
				<?php else:?>
					<?php echo wpautop($testimonial['content']); ?>
				<?php endif;?>
			</div>	
			<?php if(!get_option('meta_data_position')): ?>			
				<p class="<?php echo $author_class; ?>">
					<?php if(strlen($testimonial['client'])>0 || strlen($testimonial['position'])>0 ): ?>
					<cite><span class="testimonial-client"><?php echo $testimonial['client'];?></span><br/><span class="testimonial-position"><?php echo $testimonial['position'];?></span></cite>
					<?php endif; ?>
				</p>	
			<?php endif; ?>
		</blockquote><?php 	
			
	endwhile;	
	wp_reset_query();
	
	$content = ob_get_contents();
	ob_end_clean();	
	
	return $content;
}


//output all testimonials for use in JS widget
function outputTestimonialsCycle($atts){ 
	
	//load shortcode attributes into an array
	extract( shortcode_atts( array(
		'testimonials_link' => get_option('testimonials_link'),
		'show_title' => 0,
		'count' => -1,
		'transition' => 'scrollHorz',
		'show_thumbs' => '',
		'timer' => '2000',
		'container' => false,
		'use_excerpt' => false,
		'category' => '',
		'body_class' => 'testimonial_body',
		'author_class' => 'testimonial_author',
		'random' => '',
		'orderby' => 'date',//'none','ID','author','title','name','date','modified','parent','rand','menu_order'
		'order' => 'ASC',//'DESC'
		'pager' => false,
		'show_pager_icons' => false,
		'show_rating' => false
	), $atts ) );	
	
	$show_thumbs = ($show_thumbs == '') ? get_option('testimonials_image') : $show_thumbs;
			
	if(!is_numeric($count)){
		$count = -1;
	}
	
	ob_start();
	
	$i = 0;
	
	if(!isValidKey() && !in_array($transition, array('fadeOut','fade','scrollHorz'))){
		$transition = 'fadeOut';
	}

	?>
	
	<div class="cycle-slideshow" 
		data-cycle-fx="<?php echo $transition; ?>" 
		data-cycle-timeout="<?php echo $timer; ?>"
		data-cycle-slides="> div.testimonial_slide"
		<?php if($container): ?> data-cycle-auto-height="container" <?php endif; ?>
		<?php if($random): ?> data-cycle-random="true" <?php endif; ?>
	>
	<?php
	
	$easy_t_first = true;
	
	//load testimonials into an array
	$loop = new WP_Query(array( 'post_type' => 'testimonial','posts_per_page' => '-1', 'orderby' => $orderby, 'order' => $order, 'easy-testimonial-category' => $category));
	while($loop->have_posts()) : $loop->the_post();
		if($easy_t_first){
			$testimonial_display = '';
			$easy_t_first = false;
		} else {
			$testimonial_display = 'style="display:none;"';
		}
	
		$postid = get_the_ID();

		//if nothing is set for the short content, use the long content
		if($use_excerpt){
			$testimonial['content'] = get_the_excerpt();
		} else {				
			$testimonial['content'] = get_the_content();
		}

		//load rating
		//if set, append english text to it
		$testimonial['rating'] = get_post_meta($postid, '_ikcf_rating', true); 
		if(strlen($testimonial['rating'])>0){
			$testimonial['rating'] = '<span class="easy_t_ratings">' . $testimonial['rating'] . '/5 Stars.</span>';
		}	
		
		//if nothing is set for the short content, use the long content
		if(strlen($testimonial['content']) < 2){
			$temp_post_content = get_post($postid); 			
				$testimonial['content'] = $temp_post_content->post_excerpt;
			if($use_excerpt){
				if($testimonial['content'] == ''){
					$testimonial['content'] = wp_trim_excerpt($temp_post_content->post_content);
				}
			} else {				
				$testimonial['content'] = $temp_post_content->post_content;
			}
		}
			
		if(strlen($show_rating)>2){			
			if($show_rating == "before"){
				$testimonial['content'] = $testimonial['rating'] . ' ' . $testimonial['content'];
			}
			if($show_rating == "after"){
				$testimonial['content'] =  $testimonial['content'] . ' ' . $testimonial['rating'];
			}
		}
		
		if ($show_thumbs) {		
			$testimonial_image_size = isValidKey() ? get_option('easy_t_image_size') : "easy_testimonial_thumb";
			if(strlen($testimonial_image_size) < 2){
				$testimonial_image_size = "easy_testimonial_thumb";
			}
		
			$testimonial['image'] = get_the_post_thumbnail($postid, $testimonial_image_size);
			if (strlen($testimonial['image']) < 2 && get_option('easy_t_mystery_man')){
				$testimonial['image'] = '<img class="attachment-easy_testimonial_thumb wp-post-image" src="' . plugins_url('include/css/mystery_man.png', __FILE__) . '" />';
			}
		}
		
		$testimonial['client'] = get_post_meta($postid, '_ikcf_client', true); 	
		$testimonial['position'] = get_post_meta($postid, '_ikcf_position', true); 
	
		if($i < $count || $count == -1){
	
			?><div <?php echo $testimonial_display; ?> class="testimonial_slide"><blockquote class="easy_testimonial">		
				<?php if ($show_thumbs) {
					echo $testimonial['image'];
				} ?>		
				<?php if ($show_title) {
					echo '<p class="easy_testimonial_title">' . get_the_title($postid) . '</p>';
				} ?>	
				<?php if(get_option('meta_data_position')): ?>
					<p class="<?php echo $author_class; ?>">
						<?php if(strlen($testimonial['client'])>0 || strlen($testimonial['position'])>0 ): ?>
						<cite><span class="testimonial-client"><?php echo $testimonial['client'];?></span><br/><span class="testimonial-position"><?php echo $testimonial['position'];?></span></cite>
						<?php endif; ?>
					</p>	
				<?php endif; ?>
				<div class="<?php echo $body_class; ?>">
					<?php if(get_option('easy_t_apply_content_filter',false)): ?>
						<?php echo apply_filters('the_content',$testimonial['content']); ?>
					<?php else:?>
						<?php echo wpautop($testimonial['content']); ?>
					<?php endif;?>
					<?php if(strlen($testimonials_link)>2):?><a href="<?php echo $testimonials_link; ?>" class="easy_testimonials_read_more_link">Read More</a><?php endif; ?>
				</div>	
				<?php if(!get_option('meta_data_position')): ?>			
					<p class="<?php echo $author_class; ?>">
						<?php if(strlen($testimonial['client'])>0 || strlen($testimonial['position'])>0 ): ?>
						<cite><span class="testimonial-client"><?php echo $testimonial['client'];?></span><br/><span class="testimonial-position"><?php echo $testimonial['position'];?></span></cite>
						<?php endif; ?>
					</p>	
				<?php endif; ?>
			</blockquote></div><?php 	
			
			$i ++;
		}
		
		
	endwhile;	
	wp_reset_query();
	
	//display pager icons
	if($pager || $show_pager_icons ){
		?><div class="cycle-pager"></div><?php
	}
	
	?>
	</div>
	<?php
	
	$content = ob_get_contents();
	ob_end_clean();	
	
	return $content;
}

//only do this once
function easy_testimonials_rewrite_flush() {
    easy_testimonials_setup_testimonials();
	
    flush_rewrite_rules();
}

//register any widgets here
function easy_testimonials_register_widgets() {
	include('include/widgets/random_testimonial_widget.php');
	include('include/widgets/testimonial_cycle_widget.php');

	register_widget( 'randomTestimonialWidget' );
	register_widget( 'cycledTestimonialWidget' );
}

//create shortcodes
add_shortcode('random_testimonial', 'outputRandomTestimonial');
add_shortcode('single_testimonial', 'outputSingleTestimonial');
add_shortcode('testimonials', 'outputTestimonials');
add_shortcode('submit_testimonial', 'submitTestimonialForm');
add_shortcode('testimonials_cycle' , 'outputTestimonialsCycle');

//add JS
add_action( 'wp_enqueue_scripts', 'easy_testimonials_setup_js' );

//add CSS
add_action( 'wp_head', 'easy_testimonials_setup_css' );

//add Custom CSS
add_action( 'wp_head', 'easy_testimonials_setup_custom_css');

//register sidebar widgets
add_action( 'widgets_init', 'easy_testimonials_register_widgets' );

//do stuff
add_action( 'init', 'easy_testimonials_setup_testimonials' );

add_filter('manage_testimonial_posts_columns', 'easy_t_column_head', 10);  
add_action('manage_testimonial_posts_custom_column', 'easy_t_columns_content', 10, 2); 

add_filter('manage_edit-easy-testimonial-category_columns', 'easy_t_cat_column_head', 10);  
add_action('manage_easy-testimonial-category_custom_column', 'easy_t_cat_columns_content', 10, 3); 

//flush rewrite rules - only do this once!
register_activation_hook( __FILE__, 'easy_testimonials_rewrite_flush' );
?>