<?php

namespace PaymentsWs;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;

class TokenServiceTest extends TestCase
{
    public function testTokenize()
    {
        $stub = $this->getMockBuilder('PaymentsWs\PaymentsWsClient')->disableOriginalConstructor()->getMock();
        $stub->method('post')->willReturn('tokenize');

        $tokenService = new TokenService($stub);
        $this->assertEquals('tokenize', $tokenService->tokenize([]));
    }

    public function testDetokenize()
    {
        $stub = $this->getMockBuilder('PaymentsWs\PaymentsWsClient')->disableOriginalConstructor()->getMock();
        $stub->method('post')->willReturn('detokenize');

        $tokenService = new TokenService($stub);
        $this->assertEquals('detokenize', $tokenService->detokenize([]));
    }

    public function testValidate()
    {
        $stub = $this->getMockBuilder('PaymentsWs\PaymentsWsClient')->disableOriginalConstructor()->getMock();
        $stub->method('post')->willReturn('validate');

        $tokenService = new TokenService($stub);
        $this->assertEquals('validate', $tokenService->validate('VALIDATE_TOKEN_123456'));
    }

    public function testDelete()
    {
        $stub = $this->getMockBuilder('PaymentsWs\PaymentsWsClient')->disableOriginalConstructor()->getMock();
        $stub->method('post')->willReturn('delete');

        $tokenService = new TokenService($stub);
        $this->assertEquals('delete', $tokenService->delete('DELETE_TOKEN_123456'));
    }
}
