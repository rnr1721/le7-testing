<?php

namespace Core\Testing;

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;

class Server
{

    private ResponseFactoryInterface $responseFactory;
    private ServerRequestFactoryInterface $serverRequestFactory;

    public function __construct()
    {
        $this->serverRequestFactory = $this->getServerRequestFactory();
        $this->responseFactory = $this->getResponseFactory();
    }

    public function getServerRequest(
            string $uri,
            string $method = 'GET',
            array $data = []
    ): ServerRequestInterface
    {
        $headers = array_merge([
            'HTTP_ACCEPT' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'HTTP_ACCEPT_CHARSET' => 'ISO-8859-1,utf-8;q=0.7,*;q=0.3',
            'HTTP_ACCEPT_LANGUAGE' => 'en-US,en;q=0.8',
            'HTTP_HOST' => 'localhost',
            'HTTP_USER_AGENT' => 'le7 Framework',
            'QUERY_STRING' => '',
            'REMOTE_ADDR' => '127.0.0.1',
            'REQUEST_METHOD' => $method,
            'REQUEST_TIME' => time(),
            'REQUEST_TIME_FLOAT' => microtime(true),
            'REQUEST_URI' => '',
            'SCRIPT_NAME' => '/index.php',
            'SERVER_NAME' => 'localhost',
            'SERVER_PORT' => 80,
            'SERVER_PROTOCOL' => 'HTTP/1.1',
                ], $data);

        return $this->serverRequestFactory->createServerRequest($method, $uri, $headers);
    }

    public function getResponse(int $code, string $reasonPhrase): ResponseInterface
    {
        return $this->responseFactory->createResponse($code, $reasonPhrase);
    }

    public function getResponseFactory(): ResponseFactoryInterface
    {
        return new Psr17Factory();
    }

    public function getServerRequestFactory(): ServerRequestFactoryInterface
    {
        return new Psr17Factory();
    }

}
