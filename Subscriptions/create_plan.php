<?php
session_start();
include("access_token.php");

$data = '{

    "product_id": "'.$_SESSION['id'].'",
  
    "name": "Video Streaming Service Plan",
  
    "description": "Video Streaming Service basic plan",
  
    "status": "INACTIVE",
  
    "billing_cycles": [
  
      {
  
        "frequency": {
  
          "interval_unit": "MONTH",
  
          "interval_count": 1
  
        },
  
        "tenure_type": "TRIAL",
  
        "sequence": 1,
  
        "total_cycles": 2,
  
        "pricing_scheme": {
  
          "fixed_price": {
  
            "value": "3",
  
            "currency_code": "USD"
  
          }
  
        }
  
      },
  
      {
  
        "frequency": {
  
          "interval_unit": "MONTH",
  
          "interval_count": 1
  
        },
  
        "tenure_type": "TRIAL",
  
        "sequence": 2,
  
        "total_cycles": 3,
  
        "pricing_scheme": {
  
          "fixed_price": {
  
            "value": "6",
  
            "currency_code": "USD"
  
          }
  
        }
  
      },
  
      {
  
        "frequency": {
  
          "interval_unit": "MONTH",
  
          "interval_count": 1
  
        },
  
        "tenure_type": "REGULAR",
  
        "sequence": 3,
  
        "total_cycles": 12,
  
        "pricing_scheme": {
  
          "fixed_price": {
  
            "value": "10",
  
            "currency_code": "USD"
  
          }
  
        }
  
      }
  
    ],
  
    "payment_preferences": {
  
      "auto_bill_outstanding": true,
  
      "setup_fee": {
  
        "value": "10",
  
        "currency_code": "USD"
  
      },
  
      "setup_fee_failure_action": "CONTINUE",
  
      "payment_failure_threshold": 3
  
    },
  
    "taxes": {
  
      "percentage": "10",
  
      "inclusive": false
  
    }
  
  }';

    
  
  


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.sandbox.paypal.com/v1/billing/plans",
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

  $plan_id = $response->id;
  $_SESSION['plan_id'] = $plan_id;

}