<?php

namespace Omnireceipt\Common\Http;

use Exception;
use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Message\RequestFactory;
use Omnireceipt\Common\Exceptions\Http\NetworkException;
use Omnireceipt\Common\Exceptions\Http\RequestException;
use Omnireceipt\Common\Contracts\Http\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class Client implements ClientInterface
{

    /**
     * The Http Client which implements `public function sendRequest(RequestInterface $request)`
     * Note: Will be changed to PSR-18 when released
     */
    private HttpClient $httpClient;

    private RequestFactory $requestFactory;

    public function __construct($httpClient = null, RequestFactory $requestFactory = null)
    {
        $this->httpClient = $httpClient ?: HttpClientDiscovery::find();
        $this->requestFactory = $requestFactory ?: MessageFactoryDiscovery::find();
    }

    /**
     * @param $method
     * @param $uri
     * @param array $headers
     * @param string|array|resource|StreamInterface|null $body
     * @param string $protocolVersion
     * @return ResponseInterface
     * @throws \Http\Client\Exception
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function request(
        $method,
        $uri,
        array $headers = [],
        $body = null,
        string $protocolVersion = '1.1'
    ): ResponseInterface {
        $request = $this->requestFactory->createRequest($method, $uri, $headers, $body, $protocolVersion);

        return $this->sendRequest($request);
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws \Http\Client\Exception
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    private function sendRequest(RequestInterface $request): ResponseInterface
    {
        try {
            return $this->httpClient->sendRequest($request);
        } catch (\Http\Client\Exception\NetworkException $networkException) {
            throw new NetworkException($networkException->getMessage(), $request, $networkException);
        } catch (Exception $exception) {
            throw new RequestException($exception->getMessage(), $request, $exception);
        }
    }
}