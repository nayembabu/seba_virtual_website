<?php

// Get passport_no and dob from query parameters
$passport_no = isset($_GET['passport']) ? $_GET['passport'] : null;
$dob = isset($_GET['dob']) ? $_GET['dob'] : null;

// Validate if both parameters are provided
if (!$passport_no || !$dob) {
    echo 'Error: Missing passport number or date of birth.';
    exit;
}

// API URL
$url = 'https://api2.pilgrimdb.org:8092/pilgrim/v2/passport-verify';

// Data to be sent via POST
$data = [
    'passport_no' => $passport_no,  // Use the passed passport number
    'passport_type' => 'E-PASSPORT',  // You can adjust this if needed
    'dob' => $dob,  // Use the passed date of birth
    'hash_key' => '7coyONnesSQjX3Mo_qBhiM0ISLrG41dt11YYRFOKKLkbCzrrP-rGEbq87S4CL9zert8YR_Qu445PSFcarOa66g',
];

// cURL initialization
$ch = curl_init($url);

// Prepare the payload for POST request
$payload = http_build_query($data);

// Headers
$headers = [
    'Content-Type: application/x-www-form-urlencoded; charset=utf-8',
    'User-Agent: Dart/3.4 (dart:io)',
    'Apiauthorization: Bearer eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJZVDZIUnl0V1Z4OUlIbGZNMjQzLThmemNPelgzelh2cnFRZmUxdkJydTdNIn0.eyJleHAiOjE3MzkyNDkyNjIsImlhdCI6MTcyODg4MTM3MSwiYXV0aF90aW1lIjoxNzI4ODgxMjYyLCJqdGkiOiIwMGQ3NDQwMC0wMTM4LTQ2NTMtYmYxZC04MjhhOGRhODc5YjciLCJpc3MiOiJodHRwczovL2lkcHYyLm9zcy5uZXQuYmQvcmVhbG1zL2hhamoiLCJhdWQiOlsiYXBpLWdhdGV3YXkiLCJhY2NvdW50Il0sInN1YiI6ImYyNTJiNmJkLWYxNzMtNGE1Mi04MWRlLTFjOGQ5ZjQ5MWM1NyIsInR5cCI6IkJlYXJlciIsImF6cCI6ImhhamotcHJvZC1tb2JpbGUtYXBwIiwic2Vzc2lvbl9zdGF0ZSI6IjBhOWU5MzJhLWJhYWMtNGU3Mi05MTY1LWNhNWEzNGRmYTM3MSIsImFjciI6IjEiLCJhbGxvd2VkLW9yaWdpbnMiOlsiKiJdLCJyZWFsbV9hY2Nlc3MiOnsicm9sZXMiOlsiZGVmYXVsdC1yb2xlcy1oYWpqIiwib2ZmbGluZV9hY2Nlc3MiLCJ1bWFfYXV0aG9yaXphdGlvbiJdfSwicmVzb3VyY2VfYWNjZXNzIjp7ImFwaS1nYXRld2F5Ijp7InJvbGVzIjpbIkFQSV9VU0VSIl19LCJhY2NvdW50Ijp7InJvbGVzIjpbIm1hbmFnZS1hY2NvdW50IiwibWFuYWdlLWFjY291bnQtbGlua3MiLCJ2aWV3LXByb2ZpbGUiXX19LCJzY29wZSI6Im9wZW5pZCBjdXN0b21fYXBpX2NsaWVudF9zY29wZSBwcm9maWxlIGRhdGVfdGltZSB2ZXJpZmllZF9mcm9tIG1vYmlsZSBlbWFpbCBzZWNyZXRfa2V5Iiwic2lkIjoiMGE5ZTkzMmEtYmFhYy00ZTcyLTkxNjUtY2E1YTM0ZGZhMzcxIiwic2VjcmV0X2tleSI6ImtVVDVRbnBkZG02QnpraldLV1QwNGtUZFRqbitUMW93YzF0MVhYc3lJSUFqbGNLZVJhRkJ2MFgweXV0cXRMNHFLRkdoWGpJbGtqYWZyRUp3WDRqcU56M2o5NS9HbFQ3OUNEYys0ZmlYMkRRYUlKZnRTNGpVd2IzTHdNaldEc0lZIiwiZW1haWxfdmVyaWZpZWQiOmZhbHNlLCJkYXRlX3RpbWUiOiIyMDI0LTEwLTE0IDA5OjU4OjU0IiwidmVyaWZpZWRfZnJvbSI6Im1vYmlsZSIsIm5hbWUiOiJzaGFrIHNhemFuIiwibW9iaWxlIjoiODgwMTk4Mzk1MzA1NiIsInNzb19jbGllbnQiOiJzc28taGFqai1jbGllbnQiLCJjbGllbnRfdHlwZSI6InNzb19jbGllbnQiLCJwcmVmZXJyZWRfdXNlcm5hbWUiOiJvc3NwaWRfb3RwXzg4MDE5ODM5NTMwNTYiLCJnaXZlbl9uYW1lIjoic2hhayIsImZhbWlseV9uYW1lIjoic2F6YW4iLCJlbWFpbCI6InNrc2F6YW44ODVAZ21haWwuY29tIn0.KtGzzUrZ7W7PWFpKswWaEzbPQ0vu4HkYtWJIWaSy9Z9UR91aZ9rmsKxyWG2z21-4uClc8mHwwfcKWb-_gU9Ff3g2dUlHFnjNSCRpVbj5eUh--wEs5ByNw-bFkWaGLPQPxGlkGg6uQQMaSKBZUDiA1k5i-FeBAzkrQ5ibQFf5JVd1TmSpSvYW6gSJJLCvIqmo0lkc6OkW9UQIJl2IR-BGQE0wLTVsSIFxa5cIo_apABnxLNgj3pJXmdsbzhlKCQx_1mGvzLEgq7JAvTEXgg9A9RGqdsU1pzrMvJFNLXXTNGbPOtUs41HFjzDZEgAeovfOcYs0OLp5-3-oIg-PoDDEJg'
];

// Set cURL options
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_ENCODING, "gzip");

// Disable SSL verification (set to false) 
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

// Execute the request and get the response
$response = curl_exec($ch);

// Check for errors
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
} else {
    echo $response; // Output the response from the API
}

// Close cURL session
curl_close($ch);

?>
