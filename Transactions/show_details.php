<?php
session_start();
include("access_token.php");
//include("agreement_token.php");

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.sandbox.paypal.com/v1/billing-agreements/agreement-tokens/".$_SESSION['token_id']."",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_SSL_VERIFYHOST => false,
  CURLOPT_SSL_VERIFYPEER => false,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HEADER => false,
  CURLOPT_HTTPHEADER => array(
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
 // $response = json_decode($response);
     
   //$token_id = $response->token_id;
   //$_SESSION['token_id'] = $token_id;
  }   