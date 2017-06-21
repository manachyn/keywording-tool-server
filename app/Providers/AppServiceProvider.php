<?php

namespace App\Providers;

use App\Uploader\ChunkingUploaderInterface;
use App\Uploader\Uploader;
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
        $this->app->bind(ChunkingUploaderInterface::class, function ($app) {
            return new Uploader(env('UPLOADS_DIR', '/tmp'));
        });
    }
}
