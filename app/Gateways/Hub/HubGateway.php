<?php

namespace App\Gateways\Hub;

use App\UseCase\Contracts\Gateways\{IHttpClient, IHubGateway};
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class HubGateway implements IHubGateway
{
    /**
     * URL base para busca de referências de ofertas
     *
     * @var string $baseUrl
     */
    protected string $baseUrl = 'http://host.docker.internal:3000/hub';

    /**
     * @inheritDoc
     */
    public function send(array $offer): void
    {
        $response = with(
            app(IHttpClient::class),
            fn (IHttpClient $client) => $client->post($this->baseUrl . '/create-offer', ['json' => $offer])
        );

        if ($response->getStatusCode() !== Response::HTTP_CREATED) {
            throw new Exception('Erro ao enviar oferta ao hub.');
        }
    }
}
