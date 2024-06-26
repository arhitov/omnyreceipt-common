<?php
/**
 * Core components for the Omnireceipt PHP fiscal receipt processing library
 *
 * @link      https://github.com/omnireceipt/common
 * @package   omnireceipt/common
 * @license   MIT
 * @copyright Copyright (c) 2024, Alexander Arhitov, clgsru@gmail.com
 */

namespace Omnireceipt\Common\Http\Request;

use Omnireceipt\Common\Contracts\Http\ClientInterface;
use Omnireceipt\Common\Contracts\Http\RequestInterface;
use Omnireceipt\Common\Exceptions\RuntimeException;
use Omnireceipt\Common\Http\Response\AbstractResponse;
use Omnireceipt\Common\Supports\ParametersTrait;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractRequest implements RequestInterface
{
    use ParametersTrait {
        initialize as initializeParameters;
    }

    /**
     * An associated ResponseInterface.
     */
    protected AbstractResponse|null $response = null;

    /**
     * Create a new Request
     *
     * @param ClientInterface $httpClient  A HTTP client to make API calls with
     * @param Request         $httpRequest A Symfony HTTP request object
     */
    public function __construct(
        protected ClientInterface $httpClient,
        protected Request $httpRequest
    ) {
        $this->initialize();
    }

    /**
     * Initialize the object with parameters.
     *
     * @see \Omnireceipt\Common\Supports\Helper::initialize()
     */
    public function initialize(array $parameters = array()): static
    {
        if (null !== $this->response) {
            throw new RuntimeException('Request cannot be modified after it has been sent!');
        }

        return $this->initializeParameters($parameters);
    }

    /**
     * Send the request
     *
     * @return AbstractResponse
     * @throws \Omnireceipt\Common\Exceptions\Parameters\ParameterValidateException
     */
    public function send(): AbstractResponse
    {
        $this->validateOrFail();

        /** @var AbstractResponse $response */
        $response = $this->sendData(
            $this->getData()
        );
        return $response;
    }

    /**
     * Get the response to this request (if the request has been sent)
     *
     * @return AbstractResponse
     */
    public function getResponse(): AbstractResponse
    {
        if (null === $this->response) {
            throw new RuntimeException('You must call send() before accessing the Response!');
        }

        return $this->response;
    }
}
