<?php

require('../vendor/autoload.php');

// Set your secret key: remember to change this to your live secret key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys
\Stripe\Stripe::setApiKey("sk_test_kQ6aqDMPIjzADYwTnFFe0n65");

// Get the credit card details submitted by the form
$customerStripeID = $_POST['customerStripeID'];
$customerStripePlanID = $_POST['customerStripePlanID'];
$newPlan = $_POST['newPlan'];
 
echo "change plan";


//Create a Customer
try{
	
$subscription = \Stripe\Subscription::retrieve($customerStripePlanID);
$subscription->plan = $newPlan;
$subscription->save();

	));
	
     $response = array( 'status'=> 'Success', 'message'=>'Plan has been updated!', 'planEnd'=> $customerStripeID->subscriptions->data[0]->current_period_end);

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


