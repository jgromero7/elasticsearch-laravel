<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Elastic Search
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

use App\Observers\ElasticSearchObserver;
use App\Models\Article;
use App\Models\ElasticSearchRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Client::class, function ($app){
            return ClientBuilder::create()->setHosts([env('SEARCH_HOST')])->build();
        });

        $this->app->bind(ElasticSearchRepository::class, function($app){
            return new ElasticSearchRepository($app->make(Client::class));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Article::observe(ElasticSearchObserver::class);
    }
}
