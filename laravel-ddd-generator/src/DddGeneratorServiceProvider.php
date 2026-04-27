<?php

namespace Rabnawazak1\DddGenerator;

use Illuminate\Support\ServiceProvider;
use Rabnawazak1\DddGenerator\Commands\MakeDomainModule;

class DddGeneratorServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeDomainModule::class,
            ]);
        }
    }
}