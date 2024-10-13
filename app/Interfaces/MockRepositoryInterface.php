<?php

namespace App\Interfaces;

interface MockRepositoryInterface
{
    public function fetchReferences(int $page): array;
    public function fetchAdByReference(string $reference): array;
    public function fetchAdImagesByReference(string $reference): array;
    public function fetchAdPriceByReference(string $reference): float;
    public function sendAd(array $advert): void;
}
