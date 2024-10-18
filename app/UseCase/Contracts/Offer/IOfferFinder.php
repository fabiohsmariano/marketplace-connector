<?php

namespace App\UseCase\Contracts\Offer;

interface IOfferFinder
{
    /**
     * Busca as ofertas
     *
     * @param int $page
     * @return array
     */
    public function fetchReferences(int $page): array;

    /**
     * Busca uma oferta pela referência
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
