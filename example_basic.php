<?php
	DEFINE("CRYPTOBOX_PHP_FILES_PATH", "lib/");
	DEFINE("CRYPTOBOX_IMG_FILES_PATH", "images/");
	DEFINE("CRYPTOBOX_JS_FILES_PATH", "js/");
	DEFINE("CRYPTOBOX_LANGUAGE_HTMLID", "alang");
	DEFINE("CRYPTOBOX_COINS_HTMLID", "acoin");
	DEFINE("CRYPTOBOX_PREFIX_HTMLID", "acrypto_");

	/**
	 * Load database configuration.
	 * 
	 * Also create table "crypto_payments" in your database, sql code - https://github.com/cryptoapi/Payment-Gateway#mysql-table
	 */
	require_once(CRYPTOBOX_PHP_FILES_PATH . "cryptobox.class.php" );
	
	/*********************************************************/
	/****  PAYMENT BOX CONFIGURATION VARIABLES  ****/
	/*********************************************************/
	$userID 		= "1";	  			// Login user id or Unique id.
	$userFormat		= "COOKIE";       	// save userID in cookies (or you can use IPADDRESS, SESSION, MANUAL)
	$orderID		= "invoice000383";	// invoice #000383
	$amountUSD		= 0.12;			  	// invoice amount - 0.12 USD; or you can use - $amountUSD = convert_currency_live("EUR", "USD", 22.37); // convert 22.37EUR to USD
	$period			= "NOEXPIRY";	  // one time payment, not expiry
	$def_language	= "en";			  // default Language in payment box
	$def_coin		= "bitcoin";      // default Coin in payment box
	
	/**
	 * List of coins that you can accept for payments.
	 * 
	 * Create record for each your coin - https://gourl.io/editrecord/coin_boxes/0 ; and get free gourl keys
	 * Place GoUrl Public/Private keys in an array e.g $all_keys for all coins which you want to accept.
     *
	 * 1. bitcoin
	 * 2. bitcoincash
	 * 3. litecoin
	 * 4. dash
	 * 5. dogecoin
	 * 6. speedcoin
	 * 7. reddcoin
	 * 8. potcoin
	 * 9. feathercoin
	 * 10. vertcoin
	 * 11. peercoin
	 * 12. monetaryunit
	 * 13. universalcurrency
	 * 
	 * for example, you want to accept payments in bitcoin, bitcoincash and litecoin.
	 */
	$coins = array('bitcoin', 'bitcoincash', 'litecoin');
	
	/**
	 * Goto GoUrl and grab your Public/Private keys for each of coin and replaced with the following keys.
	 * 
	 * Please add only private_key to the $cryptobox_private_keys in /lib/cryptobox.config.php
	 * Note: the follwoing keys are for testing purpose only.
	 */
	$all_keys = array(
		"bitcoin" => array(
			"public_key" => "25654AAo79c3Bitcoin77BTCPUBqwIefT1j9fqqMwUtMI0huVL",  
			"private_key" => "25654AAo79c3Bitcoin77BTCPRV0JG7w3jg0Tc5Pfi34U8o5JE"
		),
		"bitcoincash" => array(
			"public_key" => "25656AAeOGaPBitcoincash77BCHPUBOGF20MLcgvHMoXHmMRx",  
			"private_key" => "25656AAeOGaPBitcoincash77BCHPRV8quZcxPwfEc93ArGB6D"
		),
		"litecoin" => array(
			"public_key" => "25657AAOwwzoLitecoin77LTCPUB4PVkUmYCa2dR770wNNstdk", 
			"private_key" => "25657AAOwwzoLitecoin77LTCPRV7hmp8s3ew6pwgOMgxMq81F"
		)
	);
	
	// Re-test - all gourl public/private keys
	$def_coin = strtolower($def_coin);
	if (!in_array($def_coin, $coins)) $coins[] = $def_coin;  
	foreach($coins as $v)
	{
		if (!isset($all_keys[$v]["public_key"]) || !isset($all_keys[$v]["private_key"])) die("Please add your public/private keys for '$v' in \$all_keys variable");
		elseif (!strpos($all_keys[$v]["public_key"], "PUB"))  die("Invalid public key for '$v' in \$all_keys variable");
		elseif (!strpos($all_keys[$v]["private_key"], "PRV")) die("Invalid private key for '$v' in \$all_keys variable");
		elseif (strpos(CRYPTOBOX_PRIVATE_KEYS, $all_keys[$v]["private_key"]) === false) 
			die("Please add your private key for '$v' in variable \$cryptobox_private_keys, file /lib/cryptobox.config.php.");
	}
	
	// Current selected coin by user
	$coinName = cryptobox_selcoin($coins, $def_coin);

	// Current Coin public/private keys
	$public_key  = $all_keys[$coinName]["public_key"];
	$private_key = $all_keys[$coinName]["private_key"];
	
	/** PAYMENT BOX **/
	$options = array(
	    "public_key"  	=> $public_key,	    // your public key from gourl.io
	    "private_key" 	=> $private_key,	// your private key from gourl.io
	    "webdev_key"  	=> "", 			    // optional, gourl affiliate key
	    "orderID"     	=> $orderID, 		// order id or product name
	    "userID"      	=> $userID, 	// unique identifier for every user
	    "userFormat"  	=> $userFormat, 	// save userID in COOKIE, IPADDRESS, SESSION  or MANUAL
	    "amount"   	  	=> 0,			    // product price in btc/bch/ltc/doge/etc OR setup price in USD below
	    "amountUSD"   	=> $amountUSD,	    // we use product price in USD
	    "period"      	=> $period, 	// payment valid period
	    "language"	  	=> $def_language    // text on EN - english, FR - french, etc
	);
	
	// Initialise Payment Class
	$box = new Cryptobox ($options);
	
	// coin name
	$coinName = $box->coin_name();
	
	// php code end :)
	
	// NOW PLACE IN FILE "lib/cryptobox.newpayment.php", function cryptobox_new_payment(..) YOUR ACTIONS -
	// WHEN PAYMENT RECEIVED (update database, send confirmation email, update user membership, etc)
	// IPN function cryptobox_new_payment(..) will automatically appear for each new payment two times - payment received and payment confirmed
	// Read more - https://gourl.io/api-php.html#ipn
	
?>
        	
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <title>Payment Box</title>


    <!-- Bootstrap4 CSS - -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" crossorigin="anonymous">   
      
    <!-- Note - If your website not use Bootstrap4 CSS as main style, please use custom css style below and delete css line above. 
    It isolate Bootstrap CSS to a particular class 'bootstrapiso' to avoid css conflicts with your site main css style -->
    <!-- <link rel="stylesheet" href="css/bootstrapcustom.min.css" crossorigin="anonymous"> -->

	                       
    <!-- JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.9/js/all.js" crossorigin="anonymous"></script>
    <script src="<?php echo CRYPTOBOX_JS_FILES_PATH; ?>support.min.js" crossorigin="anonymous"></script> 

    <!-- CSS for Payment Box -->
    <style>
            html { font-size: 14px; }
            @media (min-width: 768px) { html { font-size: 16px; } .tooltip-inner { max-width: 350px; } }
            .mncrpt .container { max-width: 980px; }
            .mncrpt .box-shadow { box-shadow: 0 .25rem .75rem rgba(0, 0, 0, .05); }
            img.radioimage-select { padding: 7px; border: solid 2px #ffffff; margin: 7px 1px; cursor: pointer; box-shadow: none; }
            img.radioimage-select:hover { border: solid 2px #a5c1e5; }
            img.radioimage-select.radioimage-checked { border: solid 2px #7db8d9; background-color: #f4f8fb; }
    </style>
  </head>

  <body>

  <?php
  
    // Text above payment box
    $custom_text  = "<p class='lead'>Demo Text - Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>";
    $custom_text .= "<p class='lead'>Please contact us for any questions on aaa@example.com</p>";
     
    // Display payment box 	
    echo $box->display_cryptobox_bootstrap($coins, $def_coin, $def_language, $custom_text, 70, 200, true, "default", "default", 250, "", "curl", true);
    

    // You can setup method='curl' in function above and use code below on this webpage -
    // if successful bitcoin payment received .... allow user to access your premium data/files/products, etc.
    // if ($box->is_paid()) { ... your code here ... }


   ?>
  
  </body>
</html>