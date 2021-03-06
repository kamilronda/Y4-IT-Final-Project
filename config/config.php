<?php

//* Google Client

$http = new GuzzleHttp\Client(['verify' => 'C:\MAMP\bin\php\php7.4.1\extras\ssl\cacert.pem']); //? Dylan - Use for development, FIXES cURL error 60: SSL certificate problem: unable to get local issuer certificate (LOCALHOST)
// $http = new GuzzleHttp\Client(['verify' => '/Applications/MAMP/bin/php/php7.4.2/extras/ssl/cacert.pem']); //? Kamil - Use for development, FIXES cURL error 60: SSL certificate problem: unable to get local issuer certificate (LOCALHOST)

// Instantiate Google API Client for call Google API
$google_client = new Google_Client();

$google_client->setHttpClient($http); //? Use for development

// Set the OAuth 2.0 Client ID
$google_client->setClientId('694540862174-d8h21eutj9g6plcisqequrid268fq52a.apps.googleusercontent.com');

// Set the OAuth 2.0 Client Secret key
$google_client->setClientSecret('12j0bQvV5MDSblwiHcLbXLLY');

// Set the OAuth 2.0 Redirect URI
$google_client->setRedirectUri('http://localhost/College/Y4-IT-Final-Project/staff/dashboard.php'); //? Dylan - Use for development
// $google_client->setRedirectUri('http://localhost/Y4-IT-Final-Project/staff/dashboard.php'); //? Kamil - Use for development
// $google_client->setRedirectUri('https://closeapart.co/staff/dashboard.php'); //? Use for production

// View their email address
$google_client->addScope('email');

// See their personal info, including any personal info you've made publicly available
$google_client->addScope('profile');

//start session on web page
session_start();

// Localhost's DB
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = 'root';
$DB_NAME = 'closeapart';
