<?php

require __DIR__ .'/../vendor/autoload.php';

use PaymentsWs\PaymentsWsClient;
use PaymentsWs\PaymentsWsClientModes;
use PaymentsWs\TokenService;

define('API_KEY', 'your_api_key');

$PaymentsWsClient = new PaymentsWsClient(API_KEY, PaymentsWsClientModes::SANDBOX, ['verify' => false]); // Passing verify = false to disable guzzle ssl verifications
// Enable for local development
//$PaymentsWsClient->setApiHost('localhost:port'); // Overwriting host for local deployments
$PaymentsWsClient->setApiIsHttps(false);
$tokenService = new TokenService($PaymentsWsClient);

// -----------------------------------------------------------------------------------
// Tokenization Example
// -----------------------------------------------------------------------------------

//// An string can be tokenized
$token = $tokenService->tokenize('hello');
$importantData = [
    'pan' => '4100123412341234',
    'expirationDate' => '12/22',
    'cardHolder' => 'John Doe',
];
$result = $tokenService->tokenize($importantData);

echo 'Tokenization Result' . PHP_EOL;
print_r($result);

// -----------------------------------------------------------------------------------
// Detokenization Example
// -----------------------------------------------------------------------------------

$token = $result->items->token;
$result = $tokenService->detokenize($token);

echo 'Detokenization Result' . PHP_EOL;
print_r($result);

// -----------------------------------------------------------------------------------
// Validate Token Example
// -----------------------------------------------------------------------------------

$result = $tokenService->validate($token);

echo 'Validation Result' . PHP_EOL;
print_r($result);

// -----------------------------------------------------------------------------------
// Delete Token Example
// -----------------------------------------------------------------------------------

$result = $tokenService->delete($token);

echo 'Delete Token Result' . PHP_EOL;
print_r($result);
