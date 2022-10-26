<?php
	//------------------- Include WordPress Functions --------------------//
	/*$scriptPath = dirname(dirname( __ FILE__));
	$path = realpath($scriptPath . '/./');
	$filepath = explode("wp-content",$path);
	define('WP_USE_THEMES', false);
	*/

require('../../../../wp-blog-header.php');
header('Access-Control-Allow-Origin: *');
header("HTTP/1.1 200 OK");

	//POST variables
	$firstname = $_POST['name'];
	$email = $_POST['email'];

	// Spam?
	if( $_POST['url'] ) {
		die;
	}

	if($name=="" || $email=="") die('Some fields are missing.');
	if(filter_var($email,FILTER_VALIDATE_EMAIL)===false) die('Invalid email address.');

	// ReCaptcha
	require_once "recaptchalib.php";
	$secret = "6Lc4H4kaAAAAALLOCzBDpW0BMyW-5jx6iMXzO-JY";
	$response = null;
	$reCaptcha = new ReCaptcha($secret);
	if ($_POST["g-recaptcha-response"]) {
	    $response = $reCaptcha->verifyResponse(
	        $_SERVER["REMOTE_ADDR"],
	        $_POST["g-recaptcha-response"]
	    );
	}

	//var_dump($response);

	if ($response != null && $response->success) {

		// signup user for email lists
		$response = bs_new_user_signup( $email,$firstname );
		//var_dump($response);
		die($response);

	}
	else die('Captcha Failed');
?>
