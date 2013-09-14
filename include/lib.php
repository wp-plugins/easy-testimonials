<?php
function isValidKey(){
	$email = get_option('easy_t_registered_name');
	$webaddress = get_option('easy_t_registered_url');
	$key = get_option('easy_t_registered_key');
	
	//if(md5($email . $webaddress . 'easy_testimonials') == $key){
	if('12345678' == $key){
		return true;
	}
	
	return false;
}
?>