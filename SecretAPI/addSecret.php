<?php
require_once 'SecretController.php';
require_once 'SecretRepository.php';
require_once 'ResponseFormatter.php';

// Retrieve the request parameters
$data = json_decode(file_get_contents('php://input'), true);
$secretText = $data['secretText'] ?? 'Empty';
$expireAfterViews = $data['expireViews'] ?? 0;
$expireAfter = $data['expireTime'] ?? 0;

// Instantiate the SecretController and SecretRepository classes
$secretRepository = new SecretRepository();
$secretController = new SecretController($secretRepository);

// Call the addSecret method of the SecretController class
if(!$response = $secretController->addSecret($secretText, $expireAfterViews, $expireAfter)){
    // If fails
    echo('Adding Secret Failed');
    return 0;
}

// Retrieve the Accept header
$acceptHeader = $_SERVER['HTTP_ACCEPT'] ?? '';

// Instantiate the ResponseFormatter class
$responseFormatter = new ResponseFormatter($acceptHeader);

// Format the response based on the Accept header
$formattedResponse = $responseFormatter->formatResponse($response);

// Set the response headers
header('Content-Type: ' . $acceptHeader);
// Return the formatted response
echo $formattedResponse;
?>