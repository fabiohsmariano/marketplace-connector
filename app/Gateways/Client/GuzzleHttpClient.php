<?php

namespace App\Gateways\Client;

use App\UseCase\Contracts\Gateways\IHttpClient;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class GuzzleHttpClient implements IHttpClient
{
    /**
     * O client HTTP
     *
     * @var Client|null
     */
    protected ?Client $client = null;

    /**
     * @inheritDoc
     * @throws GuzzleException
     */
    public function get(string $uri, array $options = []): ResponseInterface
    {
        return $this->getClient()->get($uri, $options);
    }

    /**
     * @inheritDoc
     * @throws GuzzleException
     */
    public function post($uri, array $options = []): ResponseInterface
    {
        return $this->getClient()->post($uri, $options);
    }

    /**
     * Retorna instância do Client
     *
     * @return Client
     */
    public function getClient(): Client
    {
        if (!isset($this->client)) {
            $this->client = new Client();
        }

        return $this->client;
    }
}
