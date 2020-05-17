# PaymentsWs PHP-SDK

> Official PHP bindings to the PaymentsWs API

# SDK Documentation

## Introduction

Every request happening on our systems are going to return an operationId which represents that the operation has been
processed and logged into our systems, you will be able to track each request from our back-office portal.

## Requirements

- A valid PaymentsWs APIKey provided by our service.
- PHP >= 5.6

## Getting Stared

Import the PaymentsWs PHP-SDK to your codebase.

Following you will find some examples to integrate your system with PaymentsWs. Additionally you can take a look to the
examples provided on the /examples folder of this SDK.

#### Initialize the core PaymentsWs SDK

Currently PaymentsWsClient object supports 2 different modes:

- Sandbox Mode (To be used when integrating or doing tests) (Sandbox Mode will be used by default if none informed)
- Live Mode (To be used when going live for production)

> To enable Sandbox mode manually initialize PaymentsWsClient with the following parameters:

```php
  new PaymentswsClient("YOUR_API_KEY", PaymentswsClientModes::SANDBOX);
```

> To enable Live mode (Production) initialize PaymentsWsClient with the following parameters:

```php
  new PaymentswsClient("YOUR_API_KEY", PaymentswsClientModes::LIVE);
```

##### Code Snippet

```php
use PaymentsWs\PaymentswsClient;
use PaymentsWs\PaymentswsClientModes;
use PaymentsWs\TokenService;

$PaymentsWsClient = new PaymentswsClient("YOUR_API_KEY", PaymentswsClientModes::SANDBOX);
$tokenService = new TokenService($PaymentsWsClient);
```

#### Generate a basic tokenization on SandBox environment ($tokenService->tokenize)

This method will tokenize sensible data into PaymentsWs servers.

Tokenize method accepts any kind of data (Integers, Strings, Objects, Arrays, etc).

##### Code Snippet

```php
$importantData = [
    'pan' => '4100123412341234',
    'expirationDate' => '12/22',
    'cardHolder' => 'John Doe',
];
$tokenResult = $tokenService->tokenize($importantData);
print_r($tokenResult);

// ----------------------------------------------
// Print $tokenResult example
// ----------------------------------------------
// stdClass Object
// (
//    [status] => 201
//    [message] => success
//    [operationId] => aad8d262-2537-4c8d-a687-95d2928ad67f
//    [items] => stdClass Object
//        (
//            [token] => 317f16a3-1049-44f5-94e2-e9979a7a7322
//        )
//
//)
```

#### Get the data stored by a token ($tokenService->detokenize)

This method does a request to our system to get the data stored by a given token.
A valid and existing token should be passed.

> If a bad formatted token is passed: HTTP 400 Bad Request Error will be returned.

> If the token is valid but not found in our systems: HTTP 404 error will be returned.

##### Code Snippet

```php
$result = $tokenService->detokenize("317f16a3-1049-44f5-94e2-e9979a7a7322");
print_r($result);

// ----------------------------------------------
// Print $result example
// ----------------------------------------------
// stdClass Object
// (
//     [status] => 200
//     [message] => success
//     [operationId] => 9b466ce8-1c16-4e13-8871-0a07a2be78ba
//     [items] => stdClass Object
//         (
//             [data] => stdClass Object
//                 (
//                     [pan] => 4100123412341234
//                     [expirationDate] => 12/22
//                     [cardHolder] => John Doe
//                 )
// 
//         )
// 
// )
```
#### Validate a token ($tokenService->validate)

This method allows the client to know whether a token is in our system or not.

> If the token is valid and found in our systems: HTTP 200 OK will be returned with the data field valid = 1.

> If a bad formatted token is passed: HTTP 400 Bad Request Error will be returned.

##### Code Snippet

```php
$result = $tokenService->validate("317f16a3-1049-44f5-94e2-e9979a7a7322");
print_r($result);

// ----------------------------------------------
// Print $result example
// ----------------------------------------------
// stdClass Object
// (
//     [status] => 200
//     [message] => success
//     [operationId] => 55889f50-eff8-4536-888a-6beaeec4c36c
//     [items] => stdClass Object
//         (
//             [valid] => 1
//         )
// 
// )
```

#### Delete a token ($tokenService->delete)

This method does a request to our system for a token deletion.

> If the token is valid and found in our systems: HTTP 200 OK will be returned with delete field = 1.

> If a bad formatted token is passed: HTTP 400 Bad Request Error will be returned.

##### Code Snippet

```php
$result = $tokenService->delete("317f16a3-1049-44f5-94e2-e9979a7a7322");
print_r($result);

// ----------------------------------------------
// Print $result example
// ----------------------------------------------
// stdClass Object
// (
//     [status] => 200
//     [message] => success
//     [operationId] => e9235437-4517-4140-a419-5ba83f7b71ad
//     [items] => stdClass Object
//         (
//             [deleted] => 1
//         )
// 
// )
```

## Exceptions

All exception should be handle by statusCode present at failed responses:

##### Code Snippet

```php
// stdClass Object
// (
//     [statusCode] => 404
//     [error] => Not Found
//     [message] => Cannot PUT /v1/tokens//validate
// )
```
---
PaymentsWs (c) 2020
