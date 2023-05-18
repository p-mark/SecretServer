<?php
require_once 'SecretController.php';
require_once 'SecretRepository.php';
require_once 'ResponseFormatter.php';

// Retrieve the secret hash from the URL parameter
$hash = $_GET['hash'] ?? '';

// Instantiate the SecretController and SecretRepository classes
$secretRepository = new SecretRepository();
$secretController = new SecretController($secretRepository);

// Call the getSecretByHash method of the SecretController class
if(!$response = $secretController->getSecretByHash($hash)){
    // If fails
    echo('Asking for Secret Failed');
    return 0;
}

// Create a new instance of ResponseFormatter with the Accept header
$responseFormatter = new ResponseFormatter($_SERVER['HTTP_ACCEPT']);

// Format the response based on the Accept header
$formattedResponse = $responseFormatter->formatResponse($response);

// Set the response header
$acceptHeader = $_SERVER['HTTP_ACCEPT'] ?? '';
header('Content-Type: ' . $acceptHeader);

// Return the formatted response
echo $formattedResponse;
?>