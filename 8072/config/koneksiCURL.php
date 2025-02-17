<?php
$jsonData = json_encode($dataPOST);

$headers = array(
    'Content-Type: application/json',
    'Authorization: Basic ' . base64_encode($usernameAPI . ':' . $passwordAPI)
);

$ch = curl_init();

$reqtypeX = (isset($reqtype)) ? $reqtype : "POST";

curl_setopt($ch, CURLOPT_URL, $urlAPI);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $reqtypeX);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

$response = curl_exec($ch);

if ($response === false) {
    echo 'Error: ' . curl_error($ch);
}


// taruh file :

// file_put_contents($file_in_name,$response);

$responseData = json_decode($response, true);

//die(var_dump($responseData));

curl_close($ch);
// die(var_dump($response));
// Process the API response
if ($response) {
    $responseData = json_decode($response, true);
    // Process the data returned by the API
} else {
    // Handle the case when there is no response or an error occurred
    echo 'Error: No response from the API.';
}
