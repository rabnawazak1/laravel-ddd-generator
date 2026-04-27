<?php

namespace rabnawazak1\DddGenerator;

use Illuminate\Support\ServiceProvider;
use rabnawazak1\DddGenerator\Commands\MakeDomainModule;

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