<?php
/**
 * Core components for the Omnireceipt PHP fiscal receipt processing library
 *
 * @link      https://github.com/omnireceipt/common
 * @package   omnireceipt/common
 * @license   MIT
 * @copyright Copyright (c) 2024, Alexander Arhitov, clgsru@gmail.com
 */

namespace Omnireceipt\Common\Contracts\Http;

interface RequestInterface
{
    /**
     * Initialize request with parameters
     * @param array $parameters The parameters to send
     */
    public function initialize(array $parameters = array()): static;

    /**
     * Send the request
     *
     * @return ResponseInterface
     */
    public function send(): ResponseInterface;

    /**
     * Get the response to this request (if the request has been sent)
     *
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface;

    /**
     * Get all request parameters
     *
     * @return array
     */
    public function getParameters(): array;

    /**
     * Get the raw data array for this message. The format of this varies from gateway to gateway,
     * but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return array
     */
    public function getData(): array;

    /**
     * Send the request with specified data
     *
     * @param  array $data The data to send
     * @return ResponseInterface
     */
    public function sendData(array $data): ResponseInterface;
}
