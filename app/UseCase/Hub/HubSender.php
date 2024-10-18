<?php

namespace App\UseCase\Hub;

use App\UseCase\Contracts\Gateways\IHubGateway;
use App\UseCase\Contracts\Hub\IHubSender;

class HubSender implements IHubSender
{
    /**
     * HubSender constructor.
     *
     * @param IHubGateway $hubGateway
     */
    public function __construct(
        protected IHubGateway $hubGateway
    ) {
    }

    /**
     * @inheritDoc
     */
    public function send(array $data): void
    {
        $this->hubGateway->send($data);
    }
}
