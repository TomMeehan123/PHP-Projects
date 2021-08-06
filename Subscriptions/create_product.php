<?php
session_start();
include("access_token.php");

$data = '{

    "name": "Video Streaming Service",
  
    "description": "Video streaming service",
  
    "type": "SERVICE",
  
    "category": "SOFTWARE",
  
    "image_url": "https://example.com/streaming.jpg",
  
    "home_url": "https://example.com/home"
  
  }';


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.sandbox.paypal.com/v1/catalogs/products",
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

  $product_id = $response->id;
  $_SESSION['id'] = $product_id;
  //var_dump($response->links[1]);


} 