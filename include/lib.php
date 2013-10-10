<?php
include("etkg.php");

function isValidKey(){
	$email = get_option('easy_t_registered_name');
	$webaddress = get_option('easy_t_registered_url');
	$key = get_option('easy_t_registered_key');
	
	$keygen = new ETKG();
	$computedKey = $keygen->computeKey($webaddress, $email);

	// check the posted key against the computed key
	if ($key == $computedKey) {
		// valid key!
		return true;
	} 
	else {
		// invalid key!
		return false;
	}

}
?>