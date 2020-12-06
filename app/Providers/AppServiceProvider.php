<?php

namespace App\Providers;

use App\Services\TelegramService;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use TuriBot\Client;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(TelegramService::class, function () {
            $client = new Client(Config::get('telegram.bots.mybot.token'), false);

            return new TelegramService($client);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        if ($this->app->environment('prod')) {
            $this->app['request']->server->set('HTTPS', true);
        }
    }
}
