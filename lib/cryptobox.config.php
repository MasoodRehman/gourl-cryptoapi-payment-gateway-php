<?php

	define("DB_HOST", 	"localhost");	// hostname
	define("DB_USER", 	"root");		// database username
	define("DB_PASSWORD", 	"");		// database password
	define("DB_NAME", 	"cryptoapi");	// database name

	/**
	 *  ARRAY OF ALL YOUR CRYPTOBOX PRIVATE KEYS
	 *  Place values from your gourl.io signup page
	 *  array("your_privatekey_for_box1", "your_privatekey_for_box2 (otional)", "etc...");
	 */
	$cryptobox_private_keys = array(
		"25654AAo79c3Bitcoin77BTCPRV0JG7w3jg0Tc5Pfi34U8o5JE",
		"25656AAeOGaPBitcoincash77BCHPRV8quZcxPwfEc93ArGB6D",
		"25657AAOwwzoLitecoin77LTCPRV7hmp8s3ew6pwgOMgxMq81F"
	);


 	define("CRYPTOBOX_PRIVATE_KEYS", implode("^", $cryptobox_private_keys));
 	unset($cryptobox_private_keys);
?>
