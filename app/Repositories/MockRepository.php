<?php

namespace App\Repositories;

use App\Interfaces\MockRepositoryInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class MockRepository implements MockRepositoryInterface
{
    private string $urlBase;

    public function __construct()
    {
        $this->urlBase = config('app.mock_url_base');
    }

    private function doRequest(string $endpoint, string $method, array $data): array
    {
        switch ($method) {
            case 'GET':
                $response = Http::get("{$this->urlBase}$endpoint");

                break;

            case 'POST':
                $response = Http::post("{$this->urlBase}$endpoint", $data);

                break;
        }

        return $response->json();
    }

    /**
     * Fetches a list of all available ad references from the mock marketplace.
     *
     * @return array An array of ad references.
     */
    public function fetchReferences(int $page): array
    {
        $referencesResponse = $this->doRequest("/offers?page=$page", 'GET', []);

        return Arr::get($referencesResponse, 'data.offers', []);
    }

    /**
     * Fetches the details of an ad by its reference from the mock marketplace.
     *
     * @param string $reference The reference of the ad.
     *
     * @return array The ad data.
     */
    public function fetchAdByReference(string $reference): array
    {
        $adResponse = $this->doRequest("/offers/$reference", 'GET', []);

        return Arr::get($adResponse, 'data', []);
    }

    /**
     * Fetches the images of an ad by its reference from the mock marketplace.
     *
     * @param string $reference The reference of the ad.
     *
     * @return array An array of image data.
     */
    public function fetchAdImagesByReference(string $reference): array
    {
        $imagesResponse = $this->doRequest("/offers/$reference/images", 'GET', []);

        return Arr::get($imagesResponse, 'data.images', []);
    }

    /**
     * Fetches the price of an ad by its reference from the mock marketplace.
     *
     * @param string $reference The reference of the ad.
     *
     * @return array The ad price data, or null if not found.
     */
    public function fetchAdPriceByReference(string $reference): float
    {
        $pricesResponse = $this->doRequest("/offers/$reference/prices", 'GET', []);

        return Arr::get($pricesResponse, 'data.price', null);
    }

    /**
     * Sends the ad to the Hub.
     *
     * @param array $advert The ad to send, which must contain the following keys:
     *  - title
     *  - description
     *  - status
     *  - stock
     *
     * @return void
     */
    public function sendAd(array $advert): void
    {
        $this->doRequest('/hub/create-offer', 'POST', $advert);
    }
}
