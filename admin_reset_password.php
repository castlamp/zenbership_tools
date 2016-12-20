<?php

/**
 * Admin Password Reset Tool
 *
 * For Zenbership
 * http://www.zenbership.com/
 *
 * More inforamtion:
 * http://documentation.zenbership.com/FAQ/How-do-I-reset-an-administrative-password%253F
 */






// -----------------------------------------------------------------------------------------------
//
//   UPDATE THE FOLLOWING VARIABLES
//

	// What is your IP?
	// You can find your IP at:
	// http://www.whatismyip.com/
	$ip = 'xxx.xxx.xxx.xxx';


	// What is the employee's username you are resetting the password for?
	$username = 'admin';


	// What would you like the new password to be?
	$newPassword = '';


// -----------------------------------------------------------------------------------------------











































if ($_SERVER['REMOTE_ADDR'] == $ip) {

	require "sd-system/config.php";

	if ($_GET['reset'] == '1' && ! empty($username) && ! empty($password)) {

		$admin_pass_salt = $db->generate_salt();

		$admin_pass_encoded = $db->encode_password($_GET['password'], $admin_pass_salt);

		$in = $db->update("
			UPDATE
				ppSD_staff
			SET
				salt='$admin_pass_salt',
				password='$admin_pass_encoded'
			WHERE
				username='" . $username . "'
			LIMIT 1
		");

		echo "<h1>DONE</h1>";
		
		echo "<p>Assuming that username \"$username\" exists, his/her password has been updated.</p>";

		echo "<p style=\"color:red;\">DELETE THIS FILE FROM YOUR SERVER IMMEDIATELY!</p>";
		
		exit;

	} else {

		echo "Failed: IP matched but you did not provide the correct parameters.";
		exit;

	}

	/*
	$get = $db->get_array("
		SELECT *
		FROM ppSD_staff
	");

	echo "<PRE>";
	print_r($get);
	echo "</PRE>";
	exit;
	*/

} else {

	echo "Failed: IP did not match.";
	exit;

}