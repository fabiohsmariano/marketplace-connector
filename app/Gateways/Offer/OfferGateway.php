<?php

namespace App\Gateways\Offer;

use App\UseCase\Contracts\Gateways\{IHttpClient, IOfferGateway};
use Exception;
use Illuminate\Http\Response;

class OfferGateway implements IOfferGateway
{
    /**
     * URL base para busca de referências de ofertas
     *
     * @var string $baseUrl
     */
    protected string $baseUrl = 'http://host.docker.internal:3000/offers';

    /**
     * @inheritDoc
     */
    public function fetch(int $page): array
    {
        $response = with(
            app(IHttpClient::class),
            fn (IHttpClient $client) => $client->get($this->baseUrl . '?page=' . $page)
        );

        if ($response->getStatusCode() !== Response::HTTP_OK) {
            throw new Exception('Erro ao consultar as ofertas.');
        }

        $contents = json_decode($response->getBody()->getContents(), true);

        $offers = $contents['data']['offers'] ?? [];

        return $offers;
    }

    /**
     * @inheritDoc
     */
    public function fetchByRef(int $ref): array
    {
        $response = with(
            app(IHttpClient::class),
            fn (IHttpClient $client) => $client->get($this->baseUrl . '/' . $ref)
        );

        if ($response->getStatusCode() !== Response::HTTP_OK) {
            throw new Exception('Erro ao consultar os dados da oferta.');
        }

        $contents = json_decode($response->getBody()->getContents(), true);

        $offerData = $contents['data'] ?? [];

        if (blank($offerData)) {
            throw new Exception('Oferta não encontrada.', Response::HTTP_NOT_FOUND);
        }

        return $offerData;
    }

    /**
     * @inheritDoc
     */
    public function fetchImagesByRef(int $ref): array
    {
        $response = with(
            app(IHttpClient::class),
            fn (IHttpClient $client) => $client->get($this->baseUrl . '/' . $ref . '/images')
        );

        if ($response->getStatusCode() !== Response::HTTP_OK) {
            throw new Exception('Erro ao consultar as imagens da oferta.');
        }

        $contents = json_decode($response->getBody()->getContents(), true);

        $images = $contents['data']['images'] ?? [];

        return $images;
    }

    /**
     * @inheritDoc
     */
    public function fetchPriceByRef(int $ref): float
    {
        $response = with(
            app(IHttpClient::class),
            fn (IHttpClient $client) => $client->get($this->baseUrl . '/' . $ref . '/prices')
        );

        if ($response->getStatusCode() !== Response::HTTP_OK) {
            throw new Exception('Erro ao consultar o preço da oferta.');
        }

        $contents = json_decode($response->getBody()->getContents(), true);

        $price = $contents['data']['price'] ?? 0;

        if (blank($price)) {
            throw new Exception('Erro ao consultar o preço da oferta.', Response::HTTP_NOT_FOUND);
        }

        return $price;
    }
}
