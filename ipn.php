<?php

// STEP 1: Read POST data



// reading posted data from directly from $_POST causes serialization 

// issues with array data in POST

// reading raw POST data from input stream instead. 

$raw_post_data = file_get_contents('php://input');

$raw_post_array = explode('&', $raw_post_data);

$myPost = array();

foreach ($raw_post_array as $keyval) {

  $keyval = explode ('=', $keyval);

  if (count($keyval) == 2)

     $myPost[$keyval[0]] = urldecode($keyval[1]);

}

// read the post from PayPal system and add 'cmd'

$req = 'cmd=_notify-validate';

if(function_exists('get_magic_quotes_gpc')) {

   $get_magic_quotes_exists = true;

} 

foreach ($myPost as $key => $value) {        

   if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) { 

        $value = urlencode(stripslashes($value)); 

   } else {

        $value = urlencode($value);

   }

   $req .= "&$key=$value";

}



 

// STEP 2: Post IPN data back to paypal to validate

$ch = curl_init('https://www.paypal.com/cgi-bin/webscr');

curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

curl_setopt($ch, CURLOPT_POST, 1);

curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);

curl_setopt($ch, CURLOPT_POSTFIELDS, $req);

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);

curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);

curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));



// In wamp like environments that do not come bundled with root authority certificates,

// please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set the directory path 

// of the certificate as shown below.

// curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');

if( !($res = curl_exec($ch)) ) {

    // error_log("Got " . curl_error($ch) . " when processing IPN data");

    curl_close($ch);

    exit;

}

curl_close($ch);

// STEP 3: Inspect IPN validation result and act accordingly



if (strcmp ($res, "VERIFIED") == 0) {

	

    // check whether the payment_status is Completed

    // check that txn_id has not been previously processed

    // check that receiver_email is your Primary PayPal email

    // check that payment_amount/payment_currency are correct

    // process payment



    // assign posted variables to local variables

    $item_name = $_POST['item_name'];

    $item_number = $_POST['item_number'];

    $payment_status = $_POST['payment_status'];

    $payment_amount = $_POST['mc_gross'];

    $payment_currency = $_POST['mc_currency'];

    $txn_id = $_POST['txn_id'];

    $receiver_email = $_POST['receiver_email'];

    $payer_email = $_POST['payer_email'];
	
	$name		=	$_POST['first_name'];

	$site_url	=	get_bloginfo('wpurl');





	 

	$subject	=	get_option('email_subject');

	$from	=	get_option('from_email');
	
	$message	=	get_option('email_message');
	
	if($message){
	
	$message	=	str_replace('[item_name]',$item_name,$message);

	$message	=	str_replace('[txn_id]',$txn_id,$message);

	$message	=	str_replace(' [mc_gross]',$payment_amount,$message);

	$message	=	str_replace('[mc_currency]',$payment_currency,$message);

	$message	=	str_replace('[receiver_email]',$receiver_email,$message);

	$message	=	str_replace('[payer_email]',$payer_email,$message);
	
	$message	=	str_replace('[name]',$name,$message);
	
	$message	=	str_replace('[site_url]',$site_url,$message);

	}else{
		
		$message	=	'Dear '.$name.',

						Thank you for your purchase from '.$site_uel.'. The details of your purchase are below.

						Transaction ID: '.$txn_id.'
						Item Name: '.$item_name.'
						Payment Amount: '.$payment_amount.'
						Paid to: '.$receiver_email.'

						Thanks and Enjoy!
						~Enigma Digital';	
	}

	

		if($payment_status=='Completed'){ 

			global $wpdb;

			$table			 =	$wpdb->prefix . "paypal_transactions";

			$txn_id_check	 = 	$wpdb->get_results("SELECT * FROM $table WHERE txn_id ='$txn_id'");

			if(!$txn_id_check){ 

			$data	=	array(

				'product_name' 				=> $item_name,

				'product_price' 			=> $payment_amount,

				'txn_id' 					=> $txn_id,

				'payer_email' 				=> $payer_email,

			);

			$wpdb->insert($table,$data) or die(mysql_error());
			$headers = 'From: ' .$from. "\r\n" .
    		'Reply-To: ' .$from . "\r\n";
			//mail to buyer
			 mail( $payer_email, $subject, $message, $headers );
			

		}

		}

	}