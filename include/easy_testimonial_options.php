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
along with The Easy Testimonials.  If not, see <http://www.gnu.org/licenses/>.
*/

class easyTestimonialOptions
{
	var $textdomain = '';
	
	function __construct(){
		//may be running in non WP mode (for example from a notification)
		if(function_exists('add_action')){
			//add a menu item
			add_action('admin_menu', array($this, 'add_admin_menu_item'));		
		}
	}
	
	function add_admin_menu_item(){
		$title = "Easy Testimonial Settings";
		$page_title = "Easy Testimonials Settings";
		
		//create new top-level menu
		add_menu_page($page_title, $title, 'administrator', __FILE__, array($this, 'settings_page'));

		//call register settings function
		add_action( 'admin_init', array($this, 'register_settings'));	
	}


	function register_settings(){
		//register our settings
		register_setting( 'easy-testimonials-settings-group', 'testimonials_link' );
		register_setting( 'easy-testimonials-settings-group', 'testimonials_image' );
		register_setting( 'easy-testimonials-settings-group', 'meta_data_position' );
		register_setting( 'easy-testimonials-settings-group', 'easy_t_custom_css' );
		register_setting( 'easy-testimonials-settings-group', 'easy_t_disable_cycle2' );
		register_setting( 'easy-testimonials-settings-group', 'easy_t_use_cycle_fix' );
		register_setting( 'easy-testimonials-settings-group', 'easy_t_apply_content_filter' );
		register_setting( 'easy-testimonials-settings-group', 'easy_t_mystery_man' );
		register_setting( 'easy-testimonials-settings-group', 'easy_t_image_size' );
		
		register_setting( 'easy-testimonials-settings-group', 'easy_t_registered_name' );
		register_setting( 'easy-testimonials-settings-group', 'easy_t_registered_first_name' );
		register_setting( 'easy-testimonials-settings-group', 'easy_t_registered_last_name' );
		register_setting( 'easy-testimonials-settings-group', 'easy_t_registered_url' );
		register_setting( 'easy-testimonials-settings-group', 'easy_t_registered_key' );
		
		register_setting( 'easy-testimonials-style-settings-group', 'testimonials_style' );
		
		register_setting( 'easy-testimonials-submission_form_options-settings-group', 'easy_t_title_field_label' );
		register_setting( 'easy-testimonials-submission_form_options-settings-group', 'easy_t_title_field_description' );
		register_setting( 'easy-testimonials-submission_form_options-settings-group', 'easy_t_name_field_label' );
		register_setting( 'easy-testimonials-submission_form_options-settings-group', 'easy_t_name_field_description' );
		register_setting( 'easy-testimonials-submission_form_options-settings-group', 'easy_t_position_web_other_field_label' );
		register_setting( 'easy-testimonials-submission_form_options-settings-group', 'easy_t_position_web_other_field_description' );
		register_setting( 'easy-testimonials-submission_form_options-settings-group', 'easy_t_body_content_field_label' );
		register_setting( 'easy-testimonials-submission_form_options-settings-group', 'easy_t_body_content_field_description' );
		register_setting( 'easy-testimonials-submission_form_options-settings-group', 'easy_t_submit_button_label' );
		register_setting( 'easy-testimonials-submission_form_options-settings-group', 'easy_t_submit_success_message' );
		register_setting( 'easy-testimonials-submission_form_options-settings-group', 'easy_t_submit_notification_address' );
		register_setting( 'easy-testimonials-submission_form_options-settings-group', 'easy_t_hide_position_web_other_field' );
		register_setting( 'easy-testimonials-submission_form_options-settings-group', 'easy_t_hide_name_field' );		
		register_setting( 'easy-testimonials-submission_form_options-settings-group', 'easy_t_use_captcha' );	
		register_setting( 'easy-testimonials-submission_form_options-settings-group', 'easy_t_captcha_field_label' );
		register_setting( 'easy-testimonials-submission_form_options-settings-group', 'easy_t_captcha_field_description' );	
	}
	
	//function to produce tabs on admin screen
	function easy_t_admin_tabs( $current = 'homepage' ) {
	
		$tabs = array( 'basic_options' => __('Basic Options', $this->textdomain), 'style_theme_options' => __('Style & Theming Options', $this->textdomain), 'submission_form_options' => __('Submission Form Options', $this->textdomain));
		echo '<div id="icon-themes" class="icon32"><br></div>';
		echo '<h2 class="nav-tab-wrapper">';
			foreach( $tabs as $tab => $name ){
				$class = ( $tab == $current ) ? ' nav-tab-active' : '';
				echo "<a class='nav-tab$class' href='?page=easy-testimonials/include/easy_testimonial_options.php&tab=$tab'>$name</a>";
			}
		echo '</h2>';
	}
	
	function settings_page(){
		$title = "Easy Testimonials Settings";
		$message = "Easy Testimonials Settings Updated.";
		
		global $pagenow;
	?>
	<div class="wrap">
		<h2><?php echo $title; ?></h2>
		<style type="text/css">
			.form-table.easy_t_options img {
				background-color: #fff;
				display: block;
				margin: 10px 0 20px;
				padding: 10px;
			}
			
			.easy-t-radio-button {
				float: left;
				height: 340px;
				margin: 0 10px 10px 0;
				width: 367px;
			}			
			
			.form-table.easy_t_options h4 {
				clear: both;
				margin: 0 0 0.5em;
				padding: 1.33em 0 0;
				text-decoration: underline;
			}
			
			.easy-t-radio-button em {
				margin-left: 20px;
			}
		</style>
		<?php if(!isValidKey()): ?>		
				<!-- Begin MailChimp Signup Form -->
				<style type="text/css">
					/* MailChimp Form Embed Code - Slim - 08/17/2011 */
					#mc_embed_signup form {display:block; position:relative; text-align:left; padding:10px 0 10px 3%}
					#mc_embed_signup h2 {font-weight:bold; padding:0; margin:15px 0; font-size:1.4em;}
					#mc_embed_signup input {border:1px solid #999; -webkit-appearance:none;}
					#mc_embed_signup input[type=checkbox]{-webkit-appearance:checkbox;}
					#mc_embed_signup input[type=radio]{-webkit-appearance:radio;}
					#mc_embed_signup input:focus {border-color:#333;}
					#mc_embed_signup .button {clear:both; background-color: #aaa; border: 0 none; border-radius:4px; color: #FFFFFF; cursor: pointer; display: inline-block; font-size:15px; font-weight: bold; height: 32px; line-height: 32px; margin: 0 5px 10px 0; padding:0; text-align: center; text-decoration: none; vertical-align: top; white-space: nowrap; width: auto;}
					#mc_embed_signup .button:hover {background-color:#777;}
					#mc_embed_signup .small-meta {font-size: 11px;}
					#mc_embed_signup .nowrap {white-space:nowrap;}     
					#mc_embed_signup .clear {clear:none; display:inline;}

					#mc_embed_signup h3 { color: #008000; display:block; font-size:19px; padding-bottom:10px; font-weight:bold; margin: 0 0 10px;}
					#mc_embed_signup .explain {
						color: #808080;
						width: 600px;
					}
					#mc_embed_signup label {
						color: #000000;
						display: block;
						font-size: 15px;
						font-weight: bold;
						padding-bottom: 10px;
					}
					#mc_embed_signup input.email {display:block; padding:8px 0; margin:0 4% 10px 0; text-indent:5px; width:58%; min-width:130px;}

					#mc_embed_signup div#mce-responses {float:left; top:-1.4em; padding:0em .5em 0em .5em; overflow:hidden; width:90%;margin: 0 5%; clear: both;}
					#mc_embed_signup div.response {margin:1em 0; padding:1em .5em .5em 0; font-weight:bold; float:left; top:-1.5em; z-index:1; width:80%;}
					#mc_embed_signup #mce-error-response {display:none;}
					#mc_embed_signup #mce-success-response {color:#529214; display:none;}
					#mc_embed_signup label.error {display:block; float:none; width:auto; margin-left:1.05em; text-align:left; padding:.5em 0;}		
					#mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; }
						#mc_embed_signup{    
								background-color: white;
								border: 1px solid #DCDCDC;
								clear: left;
								color: #008000;
								font: 14px Helvetica,Arial,sans-serif;
								margin-top: 10px;
								margin-bottom: 0px;
								max-width: 800px;
								padding: 5px 12px 0px;
					}
					#mc_embed_signup form{padding: 10px}

					#mc_embed_signup .special-offer {
						color: #808080;
						margin: 0;
						padding: 0 0 3px;
						text-transform: uppercase;
					}
					#mc_embed_signup .button {
					  background: #5dd934;
					  background-image: -webkit-linear-gradient(top, #5dd934, #549e18);
					  background-image: -moz-linear-gradient(top, #5dd934, #549e18);
					  background-image: -ms-linear-gradient(top, #5dd934, #549e18);
					  background-image: -o-linear-gradient(top, #5dd934, #549e18);
					  background-image: linear-gradient(to bottom, #5dd934, #549e18);
					  -webkit-border-radius: 5;
					  -moz-border-radius: 5;
					  border-radius: 5px;
					  font-family: Arial;
					  color: #ffffff;
					  font-size: 20px;
					  padding: 10px 20px 10px 20px;
					  line-height: 1.5;
					  height: auto;
					  margin-top: 7px;
					  text-decoration: none;
					}

					#mc_embed_signup .button:hover {
					  background: #65e831;
					  background-image: -webkit-linear-gradient(top, #65e831, #5dd934);
					  background-image: -moz-linear-gradient(top, #65e831, #5dd934);
					  background-image: -ms-linear-gradient(top, #65e831, #5dd934);
					  background-image: -o-linear-gradient(top, #65e831, #5dd934);
					  background-image: linear-gradient(to bottom, #65e831, #5dd934);
					  text-decoration: none;
					}
					#signup_wrapper {
						max-width: 800px;
						margin-bottom: 20px;
					}
					#signup_wrapper .u_to_p
					{
						font-size: 10px;
						margin: 0;
						padding: 2px 0 0 3px;				
					]
				</style>
				<div id="signup_wrapper">
					<div id="mc_embed_signup">
						<form action="http://illuminatikarate.us2.list-manage.com/subscribe/post?u=403e206455845b3b4bd0c08dc&amp;id=a70177def0" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
							<p class="special-offer">Special Offer:</p>
							<h3>Subscribe to our newsletter now, and we'll give you a discount on Easy Testimonials Pro!</h3>
							<label for="mce-EMAIL">Your Email:</label>
							<input type="email" id="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="email address" required>
							<!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
							<div style="position: absolute; left: -5000px;"><input type="text" name="b_403e206455845b3b4bd0c08dc_6ad78db648" tabindex="-1" id=""></div>
							<div class="clear"><input type="submit" value="Subscribe Now" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
							<p class="explain"><strong>What To Expect:</strong> <br/> As soon as you've confirmed your subscription, you'll receive a coupon code for a big discount on Easy Testimonials Pro. After that, you'll receive about one email from us each month, jam-packed with special offers and tips for getting the most out of WordPress. Of course, you can unsubscribe at any time.</p>
						</form>
					</div>
					<p class="u_to_p"><a href="http://goldplugins.com/our-plugins/easy-testimonials-details/">Upgrade to Easy Testimonials Pro now</a> to remove banners like this one.</p>
				</div>
				<!--End mc_embed_signup-->			
		<?php endif; ?>
		
		<?php if (isset($_GET['settings-updated']) && $_GET['settings-updated'] == 'true') : ?>
		<div id="message" class="updated fade"><p><?php echo $message; ?></p></div>
		<?php endif; ?>	
		
		<?php if ( isset ( $_GET['tab'] ) ) $this->easy_t_admin_tabs($_GET['tab']); else $this->easy_t_admin_tabs('basic_options'); ?>
		<?php 
			if ( $pagenow == 'admin.php' && $_GET['page'] == 'easy-testimonials/include/easy_testimonial_options.php' ){
				if ( isset ( $_GET['tab'] ) ) $tab = $_GET['tab'];
				else $tab = 'basic_options';
			} 			
		?>		
		
		<form method="post" action="options.php">
		
		<?php 
			switch ( $tab ){
				case 'basic_options' :	
		?>
				
			<?php settings_fields( 'easy-testimonials-settings-group' ); ?>			
			
			<h3>Basic Options</h3>
			
			<p>Use the below options to control various bits of output.</p>
			
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label>Testimonials Style</a></th>
					<td><p class="description">Our Style Options have moved!  <a href="?page=easy-testimonials/include/easy_testimonial_options.php&tab=style_theme_options">Click here to view the new tab</a>.</p></td>
				</tr>
			</table>
			
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="easy_t_custom_css">Custom CSS</a></th>
					<td><textarea name="easy_t_custom_css" id="easy_t_custom_css" style="width: 250px; height: 250px;"><?php echo get_option('easy_t_custom_css'); ?></textarea>
					<p class="description">Input any Custom CSS you want to use here.  The plugin will work without you placing anything here - this is useful in case you need to edit any styles for it to work with your theme, though.<br/> For a list of available classes, click <a href="http://goldplugins.com/documentation/easy-testimonials-documentation/html-css-information-for-easy-testimonials/" target="_blank">here</a>.</p></td>
				</tr>
			</table>
			
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="testimonials_link">Testimonials Read More Link</label></th>
					<td><input type="text" name="testimonials_link" id="testimonials_link" value="<?php echo get_option('testimonials_link'); ?>"  style="width: 250px" />
					<p class="description">This is the URL of the 'Read More' Link.  If not set, no Read More Link is output.  If set, Read More Link will be output next to testimonial that will go to this page.</p>
					</td>
				</tr>
			</table>
			
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="testimonials_image">Show Testimonial Image</label></th>
					<td><input type="checkbox" name="testimonials_image" id="testimonials_image" value="1" <?php if(get_option('testimonials_image')){ ?> checked="CHECKED" <?php } ?>/>
					<p class="description">If checked, the Image will be shown next to the Testimonial.</p>
					</td>
				</tr>
			</table>
			
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="easy_t_image_size">Testimonial Image Size</a></th>
					<td>
						<select name="easy_t_image_size" id="easy_t_image_size">	
							<?php easy_t_output_image_options(); ?>
						</select>
						<p class="description">Select which size image to display with your Testimonials.  Defaults to 50px X 50px.</p>
					</td>
				</tr>
			</table>
			
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="easy_t_mystery_man">Use Mystery Man</label></th>
					<td><input type="checkbox" name="easy_t_mystery_man" id="easy_t_mystery_man" value="1" <?php if(get_option('easy_t_mystery_man')){ ?> checked="CHECKED" <?php } ?>/>
					<p class="description">If checked, we and you are displaying Testimonial Images, the Mystery Man avatar will be used for any missing images.</p>
					</td>
				</tr>
			</table>
			
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="meta_data_position">Show Testimonial Info Above Testimonial</label></th>
					<td><input type="checkbox" name="meta_data_position" id="meta_data_position" value="1" <?php if(get_option('meta_data_position')){ ?> checked="CHECKED" <?php } ?>/>
					<p class="description">If checked, the Testimonial Custom Fields will be displayed Above the Testimonial.  Defaults to Displaying Below the Testimonial.  Note: the Testimonial Image will be displayed to the left of this information.  NOTE: Checking this may have adverse affects on certain Styles.</p>
					</td>
				</tr>
			</table>
			
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="easy_t_disable_cycle2">Disable Cycle2 Output</label></th>
					<td><input type="checkbox" name="easy_t_disable_cycle2" id="easy_t_disable_cycle2" value="1" <?php if(get_option('easy_t_disable_cycle2')){ ?> checked="CHECKED" <?php } ?>/>
					<p class="description">If checked, we won't include the Cycle2 JavaScript file.  If you suspect you are having JavaScript compatibility issues with our plugin, please try checking this box.</p>
					</td>
				</tr>
			</table>
			
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="easy_t_use_cycle_fix">Use Cycle Fix</label></th>
					<td><input type="checkbox" name="easy_t_use_cycle_fix" id="easy_t_use_cycle_fix" value="1" <?php if(get_option('easy_t_use_cycle_fix')){ ?> checked="CHECKED" <?php } ?>/>
					<p class="description">If checked, we will try and trigger Cycle2 a different way.  If you suspect you are having JavaScript compatibility issues with our plugin, please try checking this box.  NOTE: If you have Disable Cycle2 Output checked, this box will have no effect.</p>
					</td>
				</tr>
			</table>
			
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="easy_t_apply_content_filter">Apply The Content Filter</label></th>
					<td><input type="checkbox" name="easy_t_apply_content_filter" id="easy_t_apply_content_filter" value="1" <?php if(get_option('easy_t_apply_content_filter')){ ?> checked="CHECKED" <?php } ?>/>
					<p class="description">If checked, we will apply the content filter to Testimonial content.  Use this if you are experiencing problems with other plugins applying their shortcodes, etc, to your Testimonial content.</p>
					</td>
				</tr>
			</table>
			
			<?php include('registration_options.php'); ?>
						
			<?php
					break;
					case 'style_theme_options' :
			?>
			
			<?php if(!isValidKey()): ?>
				<p><a href="http://goldplugins.com/our-plugins/easy-testimonials/"><?php _e('Upgrade to Easy Testimonials Pro now');?></a> <?php _e('and get access to new features and settings.');?> </p>
			<?php endif; ?>
					
			<?php settings_fields( 'easy-testimonials-style-settings-group' ); ?>	
			
			<h3>Style &amp; Theme Options</h3>
			
			<p class="description">Select which style you want to use.  If 'No Style' is selected, only your Theme's CSS, and any Custom CSS you've added, will be used.</p>
					
			<table class="form-table easy_t_options">
				<tr valign="top">
					<td>
						<h4>Standard Styles</h4>
						<p class="easy-t-radio-button"><input type="radio" name="testimonials_style" id="default_style" value="default_style" <?php if(get_option('testimonials_style') == "default_style"): echo 'checked="CHECKED"'; endif; ?>><label for="default_style">Default Style<br/><img src="/wp-content/plugins/easy-testimonials/include/img/easy-t-default-style.png"/></label></p>
						<p class="easy-t-radio-button"><input type="radio" name="testimonials_style" id="dark_style" value="dark_style" <?php if(get_option('testimonials_style') == "dark_style"): echo 'checked="CHECKED"'; endif; ?>><label for="dark_style">Dark Style<br/><img src="/wp-content/plugins/easy-testimonials/include/img/easy-t-dark-style.png"/></label></p>
						<p class="easy-t-radio-button"><input type="radio" name="testimonials_style" id="light_style" value="light_style" <?php if(get_option('testimonials_style') == "light_style"): echo 'checked="CHECKED"'; endif; ?>><label for="light_style">Light Style<br/><img src="/wp-content/plugins/easy-testimonials/include/img/easy-t-light-style.png"/></label></p>
						<p class="easy-t-radio-button"><input type="radio" name="testimonials_style" id="clean_style" value="clean_style" <?php if(get_option('testimonials_style') == "clean_style"): echo 'checked="CHECKED"'; endif; ?>><label for="clean_style">Clean Style<br/><img src="/wp-content/plugins/easy-testimonials/include/img/easy-t-clean-style.png"/></label></p>
						<p class="easy-t-radio-button"><input type="radio" name="testimonials_style" id="no_style" value="no_style" <?php if(get_option('testimonials_style') == "no_style"): echo 'checked="CHECKED"'; endif; ?>><label for="no_style">No Style<br/><img src="/wp-content/plugins/easy-testimonials/include/img/easy-t-no-style.png"/></label></p>
						<h4>Bubble Style</h4>
						<!-- bubble style -->
						<p class="easy-t-radio-button"><input type="radio" name="testimonials_style" id="bubble_style" <?php if(!isValidKey()): ?>disabled=DISABLED <?php endif; ?>	value="bubble_style" <?php if(get_option('testimonials_style') == "bubble_style"): echo 'checked="CHECKED"'; endif; ?>><label for="bubble_style">Bubble Style - Regular<?php if(!isValidKey()): ?><br/><em>Upgrade to Enable!</em><?php endif; ?><br/><img src="/wp-content/plugins/easy-testimonials/include/img/easy-t-bubble-regular.png"/></label></p>
						<p class="easy-t-radio-button"><input type="radio" name="testimonials_style" id="bubble_style-brown" <?php if(!isValidKey()): ?>disabled=DISABLED <?php endif; ?>	value="bubble_style-brown" <?php if(get_option('testimonials_style') == "bubble_style-brown"): echo 'checked="CHECKED"'; endif; ?>><label for="bubble_style-brown">Bubble Style - Brown<?php if(!isValidKey()): ?><br/><em>Upgrade to Enable!</em><?php endif; ?><br/><img src="/wp-content/plugins/easy-testimonials/include/img/easy-t-bubble-brown.png"/></label></p>
						<p class="easy-t-radio-button"><input type="radio" name="testimonials_style" id="bubble_style-pink" <?php if(!isValidKey()): ?>disabled=DISABLED <?php endif; ?>	value="bubble_style-pink" <?php if(get_option('testimonials_style') == "bubble_style-pink"): echo 'checked="CHECKED"'; endif; ?>><label for="bubble_style-pink">Bubble Style - Pink<?php if(!isValidKey()): ?><br/><em>Upgrade to Enable!</em><?php endif; ?><br/><img src="/wp-content/plugins/easy-testimonials/include/img/easy-t-bubble-pink.png"/></label></p>
						<p class="easy-t-radio-button"><input type="radio" name="testimonials_style" id="bubble_style-blue-orange" <?php if(!isValidKey()): ?>disabled=DISABLED <?php endif; ?>	value="bubble_style-blue-orange" <?php if(get_option('testimonials_style') == "bubble_style-blue-orange"): echo 'checked="CHECKED"'; endif; ?>><label for="bubble_style-blue-orange">Bubble Style - Blue Orange<?php if(!isValidKey()): ?><br/><em>Upgrade to Enable!</em><?php endif; ?><br/><img src="/wp-content/plugins/easy-testimonials/include/img/easy-t-bubble-blue-orange.png"/></label></p>
						<p class="easy-t-radio-button"><input type="radio" name="testimonials_style" id="bubble_style-red-grey" <?php if(!isValidKey()): ?>disabled=DISABLED <?php endif; ?>	value="bubble_style-red-grey" <?php if(get_option('testimonials_style') == "bubble_style-red-grey"): echo 'checked="CHECKED"'; endif; ?>><label for="bubble_style-red-grey">Bubble Style - Red Grey<?php if(!isValidKey()): ?><br/><em>Upgrade to Enable!</em><?php endif; ?><br/><img src="/wp-content/plugins/easy-testimonials/include/img/easy-t-bubble-red-grey.png"/></label></p>
						<p class="easy-t-radio-button"><input type="radio" name="testimonials_style" id="bubble_style-purple-green" <?php if(!isValidKey()): ?>disabled=DISABLED <?php endif; ?>	value="bubble_style-purple-green" <?php if(get_option('testimonials_style') == "bubble_style-purple-green"): echo 'checked="CHECKED"'; endif; ?>><label for="bubble_style-purple-green">Bubble Style - Purple Green<?php if(!isValidKey()): ?><br/><em>Upgrade to Enable!</em><?php endif; ?><br/><img src="/wp-content/plugins/easy-testimonials/include/img/easy-t-bubble-purple-green.png"/></label></p>
						<h4>Left Avatar - 150x150</h4>
						<!-- left avatar, 150x150 -->
						<p class="easy-t-radio-button"><input type="radio" name="testimonials_style" id="avatar-left-style" <?php if(!isValidKey()): ?>disabled=DISABLED <?php endif; ?>	value="avatar-left-style" <?php if(get_option('testimonials_style') == "avatar-left-style"): echo 'checked="CHECKED"'; endif; ?>><label for="avatar-left-style">Avatar Left Style<?php if(!isValidKey()): ?><br/><em>Upgrade to Enable!</em><?php endif; ?><br/><img src="/wp-content/plugins/easy-testimonials/include/img/easy-t-avatar-left-regular.png"/></label></p>
						<p class="easy-t-radio-button"><input type="radio" name="testimonials_style" id="avatar-left-style-brown" <?php if(!isValidKey()): ?>disabled=DISABLED <?php endif; ?>	value="avatar-left-style-brown" <?php if(get_option('testimonials_style') == "avatar-left-style-brown"): echo 'checked="CHECKED"'; endif; ?>><label for="avatar-left-style-brown">Avatar Left Style - Brown<?php if(!isValidKey()): ?><br/><em>Upgrade to Enable!</em><?php endif; ?><br/><img src="/wp-content/plugins/easy-testimonials/include/img/easy-t-avatar-left-brown.png"/></label></p>
						<p class="easy-t-radio-button"><input type="radio" name="testimonials_style" id="avatar-left-style-pink" <?php if(!isValidKey()): ?>disabled=DISABLED <?php endif; ?>	value="avatar-left-style-pink" <?php if(get_option('testimonials_style') == "avatar-left-style-pink"): echo 'checked="CHECKED"'; endif; ?>><label for="avatar-left-style-pink">Avatar Left Style - Pink<?php if(!isValidKey()): ?><br/><em>Upgrade to Enable!</em><?php endif; ?><br/><img src="/wp-content/plugins/easy-testimonials/include/img/easy-t-avatar-left-pink.png"/></label></p>
						<p class="easy-t-radio-button"><input type="radio" name="testimonials_style" id="avatar-left-style-blue-orange" <?php if(!isValidKey()): ?>disabled=DISABLED <?php endif; ?>	value="avatar-left-style-blue-orange" <?php if(get_option('testimonials_style') == "avatar-left-style-blue-orange"): echo 'checked="CHECKED"'; endif; ?>><label for="avatar-left-style-blue-orange">Avatar Left Style - Blue Orange<?php if(!isValidKey()): ?><br/><em>Upgrade to Enable!</em><?php endif; ?><br/><img src="/wp-content/plugins/easy-testimonials/include/img/easy-t-avatar-left-blue-orange.png"/></label></p>
						<p class="easy-t-radio-button"><input type="radio" name="testimonials_style" id="avatar-left-style-red-grey" <?php if(!isValidKey()): ?>disabled=DISABLED <?php endif; ?>	value="avatar-left-style-red-grey" <?php if(get_option('testimonials_style') == "avatar-left-style-red-grey"): echo 'checked="CHECKED"'; endif; ?>><label for="avatar-left-style-red-grey">Avatar Left Style - Red Grey<?php if(!isValidKey()): ?><br/><em>Upgrade to Enable!</em><?php endif; ?><br/><img src="/wp-content/plugins/easy-testimonials/include/img/easy-t-avatar-left-red-grey.png"/></label></p>
						<p class="easy-t-radio-button"><input type="radio" name="testimonials_style" id="avatar-left-style-purple-green" <?php if(!isValidKey()): ?>disabled=DISABLED <?php endif; ?>	value="avatar-left-style-purple-green" <?php if(get_option('testimonials_style') == "avatar-left-style-purple-green"): echo 'checked="CHECKED"'; endif; ?>><label for="avatar-left-style-purple-green">Avatar Left Style - Purple Green<?php if(!isValidKey()): ?><br/><em>Upgrade to Enable!</em><?php endif; ?><br/><img src="/wp-content/plugins/easy-testimonials/include/img/easy-t-avatar-left-purple-green.png"/></label></p>
						<h4>Left Avatar - 50x50</h4>
						<!-- left avatar, 50x50 -->                      
						<p class="easy-t-radio-button"><input type="radio" name="testimonials_style" id="avatar-left-style-50x50" <?php if(!isValidKey()): ?>disabled=DISABLED <?php endif; ?>	value="avatar-left-style-50x50" <?php if(get_option('testimonials_style') == "avatar-left-style-50x50"): echo 'checked="CHECKED"'; endif; ?>><label for="avatar-left-style-50x50">Avatar Left Style - 50x50<?php if(!isValidKey()): ?><br/><em>Upgrade to Enable!</em><?php endif; ?><br/><img src="/wp-content/plugins/easy-testimonials/include/img/easy-t-avatar-left-small-regular.png"/></label></p>
						<p class="easy-t-radio-button"><input type="radio" name="testimonials_style" id="avatar-left-style-50x50-brown" <?php if(!isValidKey()): ?>disabled=DISABLED <?php endif; ?>	value="avatar-left-style-50x50-brown" <?php if(get_option('testimonials_style') == "avatar-left-style-50x50-brown"): echo 'checked="CHECKED"'; endif; ?>><label for="avatar-left-style-50x50-brown">Avatar Left Style - 50x50 - Brown<?php if(!isValidKey()): ?><br/><em>Upgrade to Enable!</em><?php endif; ?><br/><img src="/wp-content/plugins/easy-testimonials/include/img/easy-t-avatar-left-small-brown.png"/></label></p>
						<p class="easy-t-radio-button"><input type="radio" name="testimonials_style" id="avatar-left-style-50x50-pink" <?php if(!isValidKey()): ?>disabled=DISABLED <?php endif; ?>	value="avatar-left-style-50x50-pink" <?php if(get_option('testimonials_style') == "avatar-left-style-50x50-pink"): echo 'checked="CHECKED"'; endif; ?>><label for="avatar-left-style-50x50-pink">Avatar Left Style - 50x50 - Pink<?php if(!isValidKey()): ?><br/><em>Upgrade to Enable!</em><?php endif; ?><br/><img src="/wp-content/plugins/easy-testimonials/include/img/easy-t-avatar-left-small-pink.png"/></label></p>
						<p class="easy-t-radio-button"><input type="radio" name="testimonials_style" id="avatar-left-style-50x50-blue-orange" <?php if(!isValidKey()): ?>disabled=DISABLED <?php endif; ?>	value="avatar-left-style-50x50-blue-orange" <?php if(get_option('testimonials_style') == "avatar-left-style-50x50-blue-orange"): echo 'checked="CHECKED"'; endif; ?>><label for="avatar-left-style-50x50-blue-orange">Avatar Left Style - 50x50 - Blue Orange<?php if(!isValidKey()): ?><br/><em>Upgrade to Enable!</em><?php endif; ?><br/><img src="/wp-content/plugins/easy-testimonials/include/img/easy-t-avatar-left-small-blue-orange.png"/></label></p>
						<p class="easy-t-radio-button"><input type="radio" name="testimonials_style" id="avatar-left-style-50x50-red-grey" <?php if(!isValidKey()): ?>disabled=DISABLED <?php endif; ?>	value="avatar-left-style-50x50-red-grey" <?php if(get_option('testimonials_style') == "avatar-left-style-50x50-red-grey"): echo 'checked="CHECKED"'; endif; ?>><label for="avatar-left-style-50x50-red-grey">Avatar Left Style - 50x50 - Red Grey<?php if(!isValidKey()): ?><br/><em>Upgrade to Enable!</em><?php endif; ?><br/><img src="/wp-content/plugins/easy-testimonials/include/img/easy-t-avatar-left-small-red-grey.png"/></label></p>
						<p class="easy-t-radio-button"><input type="radio" name="testimonials_style" id="avatar-left-style-50x50-purple-green" <?php if(!isValidKey()): ?>disabled=DISABLED <?php endif; ?>	value="avatar-left-style-50x50-purple-green" <?php if(get_option('testimonials_style') == "avatar-left-style-50x50-purple-green"): echo 'checked="CHECKED"'; endif; ?>><label for="avatar-left-style-50x50-purple-green">Avatar Left Style - 50x50 - Purple Green<?php if(!isValidKey()): ?><br/><em>Upgrade to Enable!</em><?php endif; ?><br/><img src="/wp-content/plugins/easy-testimonials/include/img/easy-t-avatar-left-small-purple-green.png"/></label></p>
						<h4>Right Avatar - 150x150</h4>
						<!-- right avatar, 150x150 -->                   
						<p class="easy-t-radio-button"><input type="radio" name="testimonials_style" id="avatar-right-style" <?php if(!isValidKey()): ?>disabled=DISABLED <?php endif; ?>	value="avatar-right-style" <?php if(get_option('testimonials_style') == "avatar-right-style"): echo 'checked="CHECKED"'; endif; ?>><label for="avatar-right-style">Avatar Right Style<?php if(!isValidKey()): ?><br/><em>Upgrade to Enable!</em><?php endif; ?><br/><img src="/wp-content/plugins/easy-testimonials/include/img/easy-t-avatar-right-regular.png"/></label></p>
						<p class="easy-t-radio-button"><input type="radio" name="testimonials_style" id="avatar-right-style-brown" <?php if(!isValidKey()): ?>disabled=DISABLED <?php endif; ?>	value="avatar-right-style-brown" <?php if(get_option('testimonials_style') == "avatar-right-style-brown"): echo 'checked="CHECKED"'; endif; ?>><label for="avatar-right-style-brown">Avatar Right Style - Brown<?php if(!isValidKey()): ?><br/><em>Upgrade to Enable!</em><?php endif; ?><br/><img src="/wp-content/plugins/easy-testimonials/include/img/easy-t-avatar-right-brown.png"/></label></p>
						<p class="easy-t-radio-button"><input type="radio" name="testimonials_style" id="avatar-right-style-pink" <?php if(!isValidKey()): ?>disabled=DISABLED <?php endif; ?>	value="avatar-right-style-pink" <?php if(get_option('testimonials_style') == "avatar-right-style-pink"): echo 'checked="CHECKED"'; endif; ?>><label for="avatar-right-style-pink">Avatar Right Style - Pink<?php if(!isValidKey()): ?><br/><em>Upgrade to Enable!</em><?php endif; ?><br/><img src="/wp-content/plugins/easy-testimonials/include/img/easy-t-avatar-right-pink.png"/></label></p>
						<p class="easy-t-radio-button"><input type="radio" name="testimonials_style" id="avatar-right-style-blue-orange" <?php if(!isValidKey()): ?>disabled=DISABLED <?php endif; ?>	value="avatar-right-style-blue-orange" <?php if(get_option('testimonials_style') == "avatar-right-style-blue-orange"): echo 'checked="CHECKED"'; endif; ?>><label for="avatar-right-style-blue-orange">Avatar Right Style - Blue Orange<?php if(!isValidKey()): ?><br/><em>Upgrade to Enable!</em><?php endif; ?><br/><img src="/wp-content/plugins/easy-testimonials/include/img/easy-t-avatar-right-blue-orange.png"/></label></p>
						<p class="easy-t-radio-button"><input type="radio" name="testimonials_style" id="avatar-right-style-red-grey" <?php if(!isValidKey()): ?>disabled=DISABLED <?php endif; ?>	value="avatar-right-style-red-grey" <?php if(get_option('testimonials_style') == "avatar-right-style-red-grey"): echo 'checked="CHECKED"'; endif; ?>><label for="avatar-right-style-red-grey">Avatar Right Style - Red Grey<?php if(!isValidKey()): ?><br/><em>Upgrade to Enable!</em><?php endif; ?><br/><img src="/wp-content/plugins/easy-testimonials/include/img/easy-t-avatar-right-red-grey.png"/></label></p>
						<p class="easy-t-radio-button"><input type="radio" name="testimonials_style" id="avatar-right-style-purple-green" <?php if(!isValidKey()): ?>disabled=DISABLED <?php endif; ?>	value="avatar-right-style-purple-green" <?php if(get_option('testimonials_style') == "avatar-right-style-purple-green"): echo 'checked="CHECKED"'; endif; ?>><label for="avatar-right-style-purple-green">Avatar Right Style - Purple Green<?php if(!isValidKey()): ?><br/><em>Upgrade to Enable!</em><?php endif; ?><br/><img src="/wp-content/plugins/easy-testimonials/include/img/easy-t-avatar-right-purple-green.png"/></label></p>
						<h4>Right Avatar - 50x50</h4>
						<!-- right avatar, 50x50 -->                     
						<p class="easy-t-radio-button"><input type="radio" name="testimonials_style" id="avatar-right-style-50x50" <?php if(!isValidKey()): ?>disabled=DISABLED <?php endif; ?>	value="avatar-right-style-50x50" <?php if(get_option('testimonials_style') == "avatar-right-style-50x50"): echo 'checked="CHECKED"'; endif; ?>><label for="avatar-right-style-50x50">Avatar Right Style - 50x50<?php if(!isValidKey()): ?><br/><em>Upgrade to Enable!</em><?php endif; ?><br/><img src="/wp-content/plugins/easy-testimonials/include/img/easy-t-avatar-right-small-regular.png"/></label></p>
						<p class="easy-t-radio-button"><input type="radio" name="testimonials_style" id="avatar-right-style-50x50-brown" <?php if(!isValidKey()): ?>disabled=DISABLED <?php endif; ?>	value="avatar-right-style-50x50-brown" <?php if(get_option('testimonials_style') == "avatar-right-style-50x50-brown"): echo 'checked="CHECKED"'; endif; ?>><label for="avatar-right-style-50x50-brown">Avatar Right Style - 50x50 - Brown<?php if(!isValidKey()): ?><br/><em>Upgrade to Enable!</em><?php endif; ?><br/><img src="/wp-content/plugins/easy-testimonials/include/img/easy-t-avatar-right-small-brown.png"/></label></p>
						<p class="easy-t-radio-button"><input type="radio" name="testimonials_style" id="avatar-right-style-50x50-pink" <?php if(!isValidKey()): ?>disabled=DISABLED <?php endif; ?>	value="avatar-right-style-50x50-pink" <?php if(get_option('testimonials_style') == "avatar-right-style-50x50-pink"): echo 'checked="CHECKED"'; endif; ?>><label for="avatar-right-style-50x50-pink">Avatar Right Style - 50x50 - Pink<?php if(!isValidKey()): ?><br/><em>Upgrade to Enable!</em><?php endif; ?><br/><img src="/wp-content/plugins/easy-testimonials/include/img/easy-t-avatar-right-small-pink.png"/></label></p>
						<p class="easy-t-radio-button"><input type="radio" name="testimonials_style" id="avatar-right-style-50x50-blue-orange" <?php if(!isValidKey()): ?>disabled=DISABLED <?php endif; ?>	value="avatar-right-style-50x50-blue-orange" <?php if(get_option('testimonials_style') == "avatar-right-style-50x50-blue-orange"): echo 'checked="CHECKED"'; endif; ?>><label for="avatar-right-style-50x50-blue-orange">Avatar Right Style - 50x50 - Blue Orange<?php if(!isValidKey()): ?><br/><em>Upgrade to Enable!</em><?php endif; ?><br/><img src="/wp-content/plugins/easy-testimonials/include/img/easy-t-avatar-right-small-blue-orange.png"/></label></p>
						<p class="easy-t-radio-button"><input type="radio" name="testimonials_style" id="avatar-right-style-50x50-red-grey" <?php if(!isValidKey()): ?>disabled=DISABLED <?php endif; ?>	value="avatar-right-style-50x50-red-grey" <?php if(get_option('testimonials_style') == "avatar-right-style-50x50-red-grey"): echo 'checked="CHECKED"'; endif; ?>><label for="avatar-right-style-50x50-red-grey">Avatar Right Style - 50x50 - Red Grey<?php if(!isValidKey()): ?><br/><em>Upgrade to Enable!</em><?php endif; ?><br/><img src="/wp-content/plugins/easy-testimonials/include/img/easy-t-avatar-right-small-red-grey.png"/></label></p>
						<p class="easy-t-radio-button"><input type="radio" name="testimonials_style" id="avatar-right-style-50x50-purple-green" <?php if(!isValidKey()): ?>disabled=DISABLED <?php endif; ?>	value="avatar-right-style-50x50-purple-green" <?php if(get_option('testimonials_style') == "avatar-right-style-50x50-purple-green"): echo 'checked="CHECKED"'; endif; ?>><label for="avatar-right-style-50x50-purple-green">Avatar Right Style - 50x50 - Purple Green<?php if(!isValidKey()): ?><br/><em>Upgrade to Enable!</em><?php endif; ?><br/><img src="/wp-content/plugins/easy-testimonials/include/img/easy-t-avatar-right-small-purple-green.png"/></label></p>
						<div style="clear:both;"></div>
					</td>
				</tr>
			</table>
			<?php
					break;
					case 'submission_form_options' :	
			?>
			
			<?php if(!isValidKey()): ?>
				<p><a href="http://goldplugins.com/our-plugins/easy-testimonials/"><?php _e('Upgrade to Easy Testimonials Pro now');?></a> <?php _e('and get access to new features and settings.');?> </p>
			<?php endif; ?>
			
			<?php settings_fields( 'easy-testimonials-submission_form_options-settings-group' ); ?>		
			
			<h3>Submission Form Options</h3>
			
			<p>Use the below options to control the look and feel of the testimonial submission form.</p>
						
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="easy_t_title_field_label">"Title" Field Label</label></th>
					<td><input type="text" name="easy_t_title_field_label" id="easy_t_title_field_label" <?php if(!isValidKey()): ?>disabled="disabled"<?php endif; ?> value="<?php echo get_option('easy_t_title_field_label'); ?>"  style="width: 250px" />
					<p class="description">This is the label of the first field in the form, which defaults to "Title".  Contents of this field will be passed through to the Title field inside WordPress.</p>
					</td>
				</tr>
			</table>
						
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="easy_t_title_field_description">"Title" Field Description</label></th>
					<td><input type="text" name="easy_t_title_field_description" id="easy_t_title_field_description" <?php if(!isValidKey()): ?>disabled="disabled"<?php endif; ?> value="<?php echo get_option('easy_t_title_field_description'); ?>"  style="width: 250px" />
					<p class="description">This is the description below the first field in the form.</p>
					</td>
				</tr>
			</table>
						
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="easy_t_name_field_label">"Name" Field Label</label></th>
					<td><input type="text" name="easy_t_name_field_label" id="easy_t_name_field_label" <?php if(!isValidKey()): ?>disabled="disabled"<?php endif; ?> value="<?php echo get_option('easy_t_name_field_label'); ?>"  style="width: 250px" />
					<p class="description">This is the label of the second field in the form, which defaults to "Name."  Contents of this field will be passed through to the Name field inside WordPress.</p>
					</td>
				</tr>
			</table>
						
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="easy_t_name_field_description">"Name" Field Description</label></th>
					<td><input type="text" name="easy_t_name_field_description" id="easy_t_name_field_description" <?php if(!isValidKey()): ?>disabled="disabled"<?php endif; ?> value="<?php echo get_option('easy_t_name_field_description'); ?>"  style="width: 250px" />
					<p class="description">This is the description below the second field in the form.</p>
					</td>
				</tr>
			</table>
			
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="easy_t_hide_name_field">Disable "Name" Field Display</label></th>
					<td><input type="checkbox" name="easy_t_hide_name_field" id="easy_t_hide_name_field" <?php if(!isValidKey()): ?>disabled="disabled"<?php endif; ?> value="1" <?php if(get_option('easy_t_hide_name_field')){ ?> checked="CHECKED" <?php } ?>/>
					<p class="description">If checked, the second field in the form will not be displayed.</p>
					</td>
				</tr>
			</table>
						
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="easy_t_position_web_other_field_label">"Position / Web Address / Other" Field Label</label></th>
					<td><input type="text" name="easy_t_position_web_other_field_label" id="easy_t_position_web_other_field_label" <?php if(!isValidKey()): ?>disabled="disabled"<?php endif; ?> value="<?php echo get_option('easy_t_position_web_other_field_label'); ?>"  style="width: 250px" />
					<p class="description">This is the label of the third field in the form, which defaults to "Position / Web Address / Other."  Contents of this field will be passed through to the Position / Web Address / Other field inside WordPress.</p>
					</td>
				</tr>
			</table>
						
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="easy_t_position_web_other_field_description">"Position / Web Address / Other" Field Description</label></th>
					<td><input type="text" name="easy_t_position_web_other_field_description" id="easy_t_position_web_other_field_description" <?php if(!isValidKey()): ?>disabled="disabled"<?php endif; ?> value="<?php echo get_option('easy_t_position_web_other_field_description'); ?>"  style="width: 250px" />
					<p class="description">This is the description below the third field in the form.</p>
					</td>
				</tr>
			</table>
			
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="easy_t_hide_position_web_other_field">Disable "Position / Web Address / Other" Field Display</label></th>
					<td><input type="checkbox" name="easy_t_hide_position_web_other_field" id="easy_t_hide_position_web_other_field" <?php if(!isValidKey()): ?>disabled="disabled"<?php endif; ?> value="1" <?php if(get_option('easy_t_hide_position_web_other_field')){ ?> checked="CHECKED" <?php } ?>/>
					<p class="description">If checked, the third field in the form will not be displayed.</p>
					</td>
				</tr>
			</table>
						
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="easy_t_body_content_field_label">"Body Content" Field Label</label></th>
					<td><input type="text" name="easy_t_body_content_field_label" id="easy_t_body_content_field_label" <?php if(!isValidKey()): ?>disabled="disabled"<?php endif; ?> value="<?php echo get_option('easy_t_body_content_field_label'); ?>"  style="width: 250px" />
					<p class="description">This is the label of the fourth field in the form, a textarea, which defaults to "Body Content."  Contents of this field will be passed through to the Body field inside WordPress.</p>
					</td>
				</tr>
			</table>
						
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="easy_t_body_content_field_description">Body Content Field Description</label></th>
					<td><input type="text" name="easy_t_body_content_field_description" id="easy_t_body_content_field_description" <?php if(!isValidKey()): ?>disabled="disabled"<?php endif; ?> value="<?php echo get_option('easy_t_body_content_field_description'); ?>"  style="width: 250px" />
					<p class="description">This is the description below the fourth field in the form, a textarea.</p>
					</td>
				</tr>
			</table>
						
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="easy_t_submit_button_label">Submit Button Label</label></th>
					<td><input type="text" name="easy_t_submit_button_label" id="easy_t_submit_button_label" <?php if(!isValidKey()): ?>disabled="disabled"<?php endif; ?> value="<?php echo get_option('easy_t_submit_button_label'); ?>"  style="width: 250px" />
					<p class="description">This is the label of the submit button at the bottom of the form.</p>
					</td>
				</tr>
			</table>
						
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="easy_t_submit_success_message">Submission Success Message</label></th>
					<td><textarea name="easy_t_submit_success_message" id="easy_t_submit_success_message" <?php if(!isValidKey()): ?>disabled="disabled"<?php endif; ?>><?php echo get_option('easy_t_submit_success_message'); ?></textarea>
					<p class="description">This is the text that appears after a successful submission.</p>
					</td>
				</tr>
			</table>
						
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="easy_t_submit_notification_address">Submission Success Notification E-Mail Address</label></th>
					<td><input type="text" name="easy_t_submit_notification_address" id="easy_t_submit_notification_address" <?php if(!isValidKey()): ?>disabled="disabled"<?php endif; ?> value="<?php echo get_option('easy_t_submit_notification_address'); ?>"  style="width: 250px" />
					<p class="description">If set, we will attempt to send an e-mail notification to this address upon a succesfull submission.  If not set, submission notifications will be sent to the site's Admin E-mail address.</p>
					</td>
				</tr>
			</table>
			
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="easy_t_captcha_field_label">"Captcha" Field Label</label></th>
					<td><input type="text" name="easy_t_captcha_field_label" id="easy_t_captcha_field_label" <?php if(!isValidKey()): ?>disabled="disabled"<?php endif; ?> value="<?php echo get_option('easy_t_captcha_field_label'); ?>"  style="width: 250px" />
					<p class="description">This is the label of the first field in the form, which defaults to "Captcha".  Contents of this field will be passed through to the Captcha field inside WordPress.</p>
					</td>
				</tr>
			</table>
						
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="easy_t_captcha_field_description">"Captcha" Field Description</label></th>
					<td><input type="text" name="easy_t_captcha_field_description" id="easy_t_captcha_field_description" <?php if(!isValidKey()): ?>disabled="disabled"<?php endif; ?> value="<?php echo get_option('easy_t_captcha_field_description'); ?>"  style="width: 250px" />
					<p class="description">This is the description below the Captcha field in the form.</p>
					</td>
				</tr>
			</table>
						
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="easy_t_use_captcha">Enable Captcha on Submission Form</label></th>
					<td><input type="checkbox" name="easy_t_use_captcha" id="easy_t_use_captcha" <?php if(!isValidKey()): ?>disabled="disabled"<?php endif; ?> value="1" <?php if(get_option('easy_t_use_captcha')){ ?> checked="CHECKED" <?php } ?>/>
					<p class="description">If checked, and a compatible plugin is installed (such as <a href="https://wordpress.org/plugins/really-simple-captcha/" target="_blank">Really Simple Captcha</a>) then we will output a Captcha on the Submission Form.  This is useful if you are having SPAM problems.</p>
					</td>
				</tr>
			</table>
			
			<?php break; ?>
			<?php } ?>
			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
			</p>
		</form>
	</div>
	<?php } // end settings_page function
	
} // end class
?>