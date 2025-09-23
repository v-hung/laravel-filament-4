<?php

namespace App\Providers;

use App\Repositories\SettingRepository;
use BezhanSalleh\LanguageSwitch\LanguageSwitch;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        FilamentAsset::register([
            Js::make('apline-sort', __DIR__ . '/../../resources/js/alpine-plugin/alpine.sort.min.js'),
        ]);

        if (!$this->app->runningInConsole()) {
            Gate::guessPolicyNamesUsing(function (string $modelClass) {
                return str_replace('Models', 'Policies', $modelClass) . 'Policy';
            });

            LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
                $switch->locales(['en', 'vi']); // also accepts a closure
            });

            app()->instance('settings', (new SettingRepository)->getAll());
        }
    }
}
