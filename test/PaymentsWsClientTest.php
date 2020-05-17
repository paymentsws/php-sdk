<?php

namespace PaymentsWs;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;

class PaymentsWsClientTest extends TestCase
{
    public function testClient()
    {
        $mock = new MockHandler(
            [
            new Response(200, ['X-Foo' => 'Bar'], "{\"foo\":\"bar\"}")
            ]
        );

        $container = [];
        $history = Middleware::history($container);
        $stack = HandlerStack::create($mock);
        $stack->push($history);

        $http_client = new Client(['handler' => $stack]);
        $apikeyTest = 'APIKEY_TEST123';
        $client = new PaymentsWsClient($apikeyTest);
        $client->setClient($http_client);

        $client->post('testEndpoint', ['Field1' => 'Test']);

        foreach ($container as $transaction) {
            // print_r($transaction);
            $authHeader = $transaction['request']->getHeaders()['Authorization'][0];
            $acceptHeader = $transaction['request']->getHeaders()['Accept'][0];
            $contentTypeHeader = $transaction['request']->getHeaders()['Content-Type'][0];
            $this->assertTrue($authHeader == "Bearer " . $apikeyTest);
            $this->assertTrue($acceptHeader == "application/json");
            $this->assertTrue($contentTypeHeader == "application/json");

        }
    }
}