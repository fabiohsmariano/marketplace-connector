<?php

namespace App\UseCase\Offer;

use App\UseCase\Contracts\Gateways\IOfferGateway;
use App\UseCase\Contracts\Offer\IOfferFinder;

class OfferFinder implements IOfferFinder
{
    /**
     * ImportCreator constructor.
     *
     * @param IOfferGateway $offerGateway
     */
    public function __construct(
        protected IOfferGateway $offerGateway
    ) {
    }

    /**
     * @inheritDoc
     */
    public function fetchReferences(int $page): array
    {
        return $this->offerGateway->fetch($page);
    }

    /**
     * @inheritDoc
     */
    public function fetchByRef(int $ref): array
    {
        return $this->offerGateway->fetchByRef($ref);
    }

    /**
     * @inheritDoc
     */
    public function fetchImagesByRef(int $ref): array
    {
        return $this->offerGateway->fetchImagesByRef($ref);
    }

    /**
     * @inheritDoc
     */
    public function fetchPriceByRef(int $ref): float
    {
        return $this->offerGateway->fetchPriceByRef($ref);
    }
}
