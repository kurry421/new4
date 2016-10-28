<?php

require('../vendor/autoload.php');

// Set your secret key: remember to change this to your live secret key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys
\Stripe\Stripe::setApiKey("sk_test_kQ6aqDMPIjzADYwTnFFe0n65");

// Get the credit card details submitted by the form
$token = $_POST['stripeToken'];
$amount = $_POST['amount'];
$description = $_POST['description'];
$plan = $_POST['plan'];
$email = $_POST['email'];
$userUid = $_POST['userUid'];

 
if ($token == ""){
	
	echo "no token";
	return;
}

//Create a Customer
try{
	$customer = \Stripe\Customer::create(array(
	  "source" => $token, // obtained from Stripe.js
	  "plan" => $plan,
	  "description" => $description,
	  "email" => $email,
	  "metadata" => array("userUid" => $userUid)
		
	  //$customerId = $customer->id;
	));
     
    //$customerIdSave = $customer->id;
	
     $response = array( 'status'=> 'Success', 'message'=>'Payment has been charged!!', 'customerId'=> $customer->id, 'subscription'=> $customer->subscriptions->data[0]->id);

    // header("Content-Type: application/json");
    echo json_encode($response);
 // Use Stripe's library to make requests...
} catch(\Stripe\Error\Card $e) {
  // Since it's a decline, \Stripe\Error\Card will be caught
  $body = $e->getJsonBody();
  $err  = $body['error'];

  print('Status is:' . $e->getHttpStatus() . "\n");
  print('Type is:' . $err['type'] . "\n");
  print('Code is:' . $err['code'] . "\n");
  // param is '' in this case
  print('Param is:' . $err['param'] . "\n");
  print('Message is:' . $err['message'] . "\n");
  //print('custoerId is:' . $err['customerId'] . "\n");

  header("Content-Type: application/json");
  echo json_encode($err);
}

//   //
// // Check that it was paid:
//   if ($charge->paid == true) {
//     $response = array( 'status'=> 'Success', 'message'=>'Payment has been charged!!' );
//   } else { // Charge was not paid!
//     $response = array( 'status'=> 'Failure', 'message'=>'Your payment could NOT be processed because the payment system rejected the transaction. You can try again or use another card.' );
//   }
//   header('Content-Type: application/json');
//   echo json_encode($response);


