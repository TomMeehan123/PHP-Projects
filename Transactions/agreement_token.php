<?php
session_start();
include("access_token.php");

$data = '{

  "description": "Billing Agreement",

  "shipping_address": {

    "line1": "1350 North First Street",

    "city": "San Jose",

    "state": "CA",

    "postal_code": "95112",

    "country_code": "US",

    "recipient_name": "John Doe"

  },

  "payer": {

    "payment_method": "PAYPAL"

  },

  "plan": {

    "type": "MERCHANT_INITIATED_BILLING",

    "merchant_preferences": {

      "return_url": "https://example.com/return",

      "cancel_url": "https://example.com/cancel",

      "notify_url": "https://example.com/notify",

      "accepted_pymt_type": "INSTANT",

      "skip_shipping_address": false,

      "immutable_shipping_address": true

    }

  }

}';

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.sandbox.paypal.com/v1/billing-agreements/agreement-tokens",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_SSL_VERIFYHOST => false,
  CURLOPT_SSL_VERIFYPEER => false,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_HEADER => false,
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json",
    "prefer:return=representation",
    "Authorization: Bearer " . $_SESSION['access_token']
  ),
 CURLOPT_POSTFIELDS => $data)
);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "<pre>cURL Error #:" . $err . "</pre>";
    echo $httpcode . $response;
  
  }else{
  
  echo "<pre>";
    print_r($response);
    $response = json_decode($response);

   $token_id = $response->token_id;
   $_SESSION['token_id'] = $token_id;
   var_dump($response->links[1]);

  }    