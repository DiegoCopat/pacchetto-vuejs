<?php

namespace DiegoCopat\PacchettoVueJs;

use Illuminate\Support\ServiceProvider;

class PacchettoVueJsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Pubblica gli assets JS
        $this->publishes([
            __DIR__.'/../dist' => public_path('vendor/diegocopat/pacchetto-vuejs'),
        ], 'public');
        
        // Pubblica il componente Vue
        $this->publishes([
            __DIR__.'/../resources/js/components' => resource_path('js/components/vendor/diegocopat'),
        ], 'vue-components');
        
        // Pubblica lo script di configurazione
        $this->publishes([
            __DIR__.'/../resources/js/config/apexcharts-setup.js' => resource_path('js/vendor/diegocopat/apexcharts-setup.js'),
        ], 'config');

        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\InstallCommand::class
            ]);
        }
    }
    
    public function register()
    {
        $this->app->singleton('pacchetto-vuejs', function ($app) {
            return new ChartManager();
        });
    }
}