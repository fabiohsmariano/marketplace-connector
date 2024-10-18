<?php

namespace App\UseCase\Contracts\Hub;

interface IHubSender
{
    /**
     * Envia uma ofeta ao hub
     *
     * @param array $data
     * @return void
     */
    public function send(array $data): void;
}
