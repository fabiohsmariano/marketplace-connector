<?php

namespace App\UseCase\Contracts\Gateways;

use Exception;

interface IOfferGateway
{
    /**
     * Busca as referências das ofertas
     *
     * @param int $page
     * @return array
     */
    public function fetch(int $page): array;

    /**
     * Busca os dados de uma oferta
     *
     * @param int $ref
     * @return array
     */
    public function fetchByRef(int $ref): array;

    /**
     * Busca as imagens de uma oferta
     *
     * @param int $ref
     * @return array
     */
    public function fetchImagesByRef(int $ref): array;

    /**
     * Busca o preço de uma oferta
     *
     * @param int $ref
     * @return float
     */
    public function fetchPriceByRef(int $ref): float;
}
