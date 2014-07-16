<?php
include("etkg.php");

function isValidKey(){
	$email = get_option('easy_t_registered_name');
	$webaddress = get_option('easy_t_registered_url');
	$first_name = get_option('easy_t_registered_first_name');
	$last_name = get_option('easy_t_registered_last_name');
	$key = get_option('easy_t_registered_key');
	
	$keygen = new ETKG();
	$computedKey = $keygen->computeKey($webaddress, $email);
	$computedKeyEJ = $keygen->computeKeyEJ($email);

	if ($key == $computedKey || $key == $computedKeyEJ) {
		return true;
	} else {
		$plugin = "easy-testimonials-pro/easy-testimonials-pro.php";
		
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		
		if(is_plugin_active($plugin)){
			return true;
		}
		else {
			return false;
		}
	}
}

function isValidMSKey(){
	$plugin = "easy-testimonials-pro/easy-testimonials-pro.php";
	
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	
	if(is_plugin_active($plugin)){
		return true;
	}
	else {
		return false;
	}
}
?>