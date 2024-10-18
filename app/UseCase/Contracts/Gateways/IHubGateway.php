<?php

namespace App\UseCase\Contracts\Gateways;

use Exception;

interface IHubGateway
{
    /**
     * Envia uma oferta para o hub
     *
     * @param array $offer
     * @return void
     * @throws Exception
     */
    public function send(array $offer): void;
}
