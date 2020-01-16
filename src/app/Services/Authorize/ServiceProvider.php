<?php

namespace App\Services\Authorize;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $this->app->bind('authorize', function () {
            return new Authorize();
        });
    }
}
