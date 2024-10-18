<?php

namespace App\UseCase\Contracts\Gateways;

use Psr\Http\Message\ResponseInterface;

interface IHttpClient
{
    /**
     * Realiza requisição get
     *
     * @param string $uri
     * @param array  $options
     * @return ResponseInterface
     */
    public function get(string $uri, array $options = []): ResponseInterface;

    /**
     * Realiza requisição post
     *
     * @param       $uri
     * @param array $options
     * @return ResponseInterface
     */
    public function post($uri, array $options = []): ResponseInterface;
}
