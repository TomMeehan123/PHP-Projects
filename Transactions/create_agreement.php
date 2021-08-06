<?php
session_start();
include("access_token.php");
//include("agreement_token.php");

$data = '{
    "token_id": "'.$_SESSION['token_id'].'"
}';

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.sandbox.paypal.com/v1/billing-agreements/agreements",
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

    $agreement_id = $response->id;
    $_SESSION['agreement_id'] = $agreement_id;
    var_dump($response->links[1]);
  
  }