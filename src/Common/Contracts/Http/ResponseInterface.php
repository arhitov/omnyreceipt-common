<?php

namespace Omnireceipt\Common\Contracts\Http;

interface ResponseInterface
{
    /**
     * Get the original request which generated this response
     *
     * @return RequestInterface
     */
    public function getRequest(): RequestInterface;

    /**
     * Get the response data
     *
     * @return mixed
     */
    public function getData(): mixed;

    /**
     * Get the response code
     *
     * @return mixed
     */
    public function getCode(): int;
}