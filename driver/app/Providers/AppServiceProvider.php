<?php

namespace App\Providers;

use App\Contracts\DriverContractInterface;
use App\Services\KohaDriverService;
use App\Services\PmbDriverService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $driver = env('DRIVER');
        $class = config('services.driver.'.$driver);
        $this->app->bind(DriverContractInterface::class, $class );
    }
}
