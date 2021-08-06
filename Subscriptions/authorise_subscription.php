<?php
session_start();
include("access_token.php");

$data = '{
    "note": "Charging as the balance reached the limit",
    "capture_type": "OUTSTANDING_BALANCE",
    "amount":{
        "currency_code": "USD",
        "value": "100"
        }
  
  }';


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.sandbox.paypal.com/v1/billing/subscriptions/".$_SESSION['sub_id']."/capture",
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

}