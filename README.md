
GoUrl Cryptocoin Payment Gateway PHP
-----------------------------------------

Introduction
----------------

PHP Cryptocoin Payment Gateway is a simple PHP/MySQL script / Wordpress Plugin which you can easily integrate into your own website in minutes.

Start accepting payments on your website, including all major cryptocoins, and start selling online in minutes. No application process.

The big benefit of Cryptocoin Payment Box is that it fully integrated on your website, no external payment pages opens (as other payment gateways offer). 

Your website will receive full user payment information immediately after cryptocoin payment is made and you can process it in automatic mode.


# ![Payment-Box](https://gourl.io/images/white_label_box.png)


Installation
----------------------------
* [Free Register](https://gourl.io/view/registration/New_User_Registration.html) or [Login](https://gourl.io/info/memberarea/My_Account.html) on the website and [create new payment box](https://gourl.io/editrecord/coin_boxes/0)
* Edit file [cryptobox_config.php](https://github.com/cryptoapi/Payment-Gateway/blob/master/lib/cryptobox.config.php), add your db details and your private key only of each coin in $cryptobox_private_keys ([screenshot](https://gourl.io/images/instruction-config1.png))
* Run [SQL query](https://github.com/cryptoapi/Payment-Gateway#mysql-table) in your database to create new table crypto_payments
* Copy your payment box public/private keys of each coin and placed in $all_keys array in example_basic.php

MySQL Table
-----------------

Please also run MySQL query below which will create MySQL
table where all the cryptocoin payments made to you will 
be stored.
You can have multiple crypto boxes on site, all of them
relates to your different crypto boxes and will be stored
in that one table :


	CREATE TABLE `crypto_payments` (
	  `paymentID` int(11) unsigned NOT NULL AUTO_INCREMENT,
	  `boxID` int(11) unsigned NOT NULL DEFAULT '0',
	  `boxType` enum('paymentbox','captchabox') NOT NULL,
	  `orderID` varchar(50) NOT NULL DEFAULT '',
	  `userID` varchar(50) NOT NULL DEFAULT '',
	  `countryID` varchar(3) NOT NULL DEFAULT '',
	  `coinLabel` varchar(6) NOT NULL DEFAULT '',
	  `amount` double(20,8) NOT NULL DEFAULT '0.00000000',
	  `amountUSD` double(20,8) NOT NULL DEFAULT '0.00000000',
	  `unrecognised` tinyint(1) unsigned NOT NULL DEFAULT '0',
	  `addr` varchar(34) NOT NULL DEFAULT '',
	  `txID` char(64) NOT NULL DEFAULT '',
	  `txDate` datetime DEFAULT NULL,
	  `txConfirmed` tinyint(1) unsigned NOT NULL DEFAULT '0',
	  `txCheckDate` datetime DEFAULT NULL,
	  `processed` tinyint(1) unsigned NOT NULL DEFAULT '0',
	  `processedDate` datetime DEFAULT NULL,
	  `recordCreated` datetime DEFAULT NULL,
	  PRIMARY KEY (`paymentID`),
	  KEY `boxID` (`boxID`),
	  KEY `boxType` (`boxType`),
	  KEY `userID` (`userID`),
	  KEY `countryID` (`countryID`),
	  KEY `orderID` (`orderID`),
	  KEY `amount` (`amount`),
	  KEY `amountUSD` (`amountUSD`),
	  KEY `coinLabel` (`coinLabel`),
	  KEY `unrecognised` (`unrecognised`),
	  KEY `addr` (`addr`),
	  KEY `txID` (`txID`),
	  KEY `txDate` (`txDate`),
	  KEY `txConfirmed` (`txConfirmed`),
	  KEY `txCheckDate` (`txCheckDate`),
	  KEY `processed` (`processed`),
	  KEY `processedDate` (`processedDate`),
	  KEY `recordCreated` (`recordCreated`),
	  KEY `key1` (`boxID`,`orderID`),
	  KEY `key2` (`boxID`,`orderID`,`userID`),
	  UNIQUE KEY `key3` (`boxID`, `orderID`, `userID`, `txID`, `amount`, `addr`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
