<?php

namespace App\Providers;

use App\Http\Services\CacheService\CacheService;
use App\Http\Services\CacheService\CacheServiceInterface;
use App\Http\Services\HttpService\HttpService;
use App\Http\Services\HttpService\HttpServiceInterface;
use App\Http\Services\LaravelPassportService\LaravelPassportService;
use App\Http\Services\LaravelPassportService\LaravelPassportServiceInterface;
use App\Http\Services\OutputFormatService\OutputFormatService;
use App\Http\Services\OutputFormatService\OutputFormatServiceInterface;
use App\Http\Services\ReportService\ReportService;
use App\Http\Services\ReportService\ReportServiceInterface;
use App\Http\Services\UserService\UserService;
use App\Http\Services\UserService\UserServiceInterface;
use App\Http\Services\WeatherClientService\WeatherClientService;
use App\Http\Services\WeatherClientService\WeatherClientServiceInterface;
use App\Models\User;
use App\Models\UserInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ReportServiceInterface::class, ReportService::class);
        $this->app->bind(WeatherClientServiceInterface::class, WeatherClientService::class);
        $this->app->bind(OutputFormatServiceInterface::class, OutputFormatService::class);
        $this->app->bind(HttpServiceInterface::class, HttpService::class);
        $this->app->bind(CacheServiceInterface::class, CacheService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(UserInterface::class, User::class);
        $this->app->bind(LaravelPassportServiceInterface::class, LaravelPassportService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
