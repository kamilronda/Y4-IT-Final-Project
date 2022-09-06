<?php

//* Google Client

// $http = new GuzzleHttp\Client(['verify' => 'C:\MAMP\bin\php\php7.4.1\extras\ssl\cacert.pem']); //? Dylan - Use for development, FIXES cURL error 60: SSL certificate problem: unable to get local issuer certificate (LOCALHOST)
$http = new GuzzleHttp\Client(['verify' => '/Applications/MAMP/bin/php/php7.4.21/extras/ssl/cacert.pem']); //? Kamil - Use for development, FIXES cURL error 60: SSL certificate problem: unable to get local issuer certificate (LOCALHOST)

// Instantiate Google API Client for call Google API
$google_client = new Google_Client();

// $google_client->setHttpClient($http); //? Use for development

// Set the OAuth 2.0 Client ID
$google_client->setClientId('227211118668-bm021iie9ubqp974cnll3stv8pn1fc8k.apps.googleusercontent.com');

// Set the OAuth 2.0 Client Secret key
$google_client->setClientSecret('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');

// Set the OAuth 2.0 Redirect URI
// $google_client->setRedirectUri('http://localhost/College/Y4-IT-Final-Project/staff/dashboard.php'); //? Dylan - Use for development
// $google_client->setRedirectUri('http://localhost:8888/Y4-IT-Final-Project/staff/dashboard.php'); //? Kamil - Use for development
$google_client->setRedirectUri('https://closeapartproject.herokuapp.com/staff/dashboard.php'); //? Use for production

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
