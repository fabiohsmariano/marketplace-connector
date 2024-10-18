<?php

namespace App\Providers;

use App\Events\ImportCreated;
use App\Events\OfferFetched;
use App\Gateways\Client\GuzzleHttpClient;
use App\Gateways\Hub\HubGateway;
use App\Gateways\Offer\OfferGateway;
use App\Listeners\OnImportCreated;
use App\Listeners\OnOfferFetched;
use App\Repositories\ImportRepository;
use App\UseCase\Contracts\Gateways\IHttpClient;
use App\UseCase\Contracts\Gateways\IHubGateway;
use App\UseCase\Contracts\Gateways\IOfferGateway;
use App\UseCase\Contracts\Hub\IHubSender;
use App\UseCase\Contracts\Import\IImportCreator;
use App\UseCase\Contracts\Import\IImportManager;
use App\UseCase\Contracts\Import\IImportUpdater;
use App\UseCase\Contracts\Offer\IOfferFinder;
use App\UseCase\Contracts\Repositories\IImportRepository;
use App\UseCase\Hub\HubSender;
use App\UseCase\Import\ImportCreator;
use App\UseCase\Import\ImportManager;
use App\UseCase\Import\ImportUpdater;
use App\UseCase\Offer\OfferFinder;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Event::listen(
            ImportCreated::class,
            OnImportCreated::class,

            OfferFetched::class,
            OnOfferFetched::class,
        );

        $this->bindImport();
        $this->bindOffer();
        $this->bindClient();
        $this->bindHub();
    }

    protected function bindImport(): void
    {
        $this->app->bind(IImportManager::class, ImportManager::class);
        $this->app->bind(IImportCreator::class, ImportCreator::class);
        $this->app->bind(IImportUpdater::class, ImportUpdater::class);
        $this->app->bind(IImportRepository::class, ImportRepository::class);
    }

    protected function bindOffer(): void
    {
        $this->app->bind(IOfferGateway::class, OfferGateway::class);
        $this->app->bind(IOfferFinder::class, OfferFinder::class);
    }

    protected function bindClient(): void
    {
        $this->app->bind(IHttpClient::class, GuzzleHttpClient::class);
    }

    protected function bindHub(): void
    {
        $this->app->bind(IHubGateway::class, HubGateway::class);
        $this->app->bind(IHubSender::class, HubSender::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
