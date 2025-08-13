<?php
$url = "https://reqres.in/api/users";

// Data to Send
$data = array(
    "name" => "Udayveer",
    "job" => "Web Developer"
);

// Convert to JSON
$payload = json_encode($data);

// Initialize cURL
$ch = curl_init($url);

// cURL Options for POST JSON
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute cURL Request
$response = curl_exec($ch);

// Close cURL
curl_close($ch);

// Decode JSON response
$data = json_decode($response, true);

// Output the result
echo "<pre>";
print_r($data);
echo "</pre>";
?>


