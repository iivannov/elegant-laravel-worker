<?php

namespace Iivannov\ElegantWorker;

use Illuminate\Queue\QueueServiceProvider;

class ElegantWorkerServiceProvider extends QueueServiceProvider
{

    protected function registerWorker()
    {
        parent::registerWorker();
        $this->app->singleton('queue.worker', function ($app) {
            return new Worker(
                $app['queue'], $app['events'],
                $app['Illuminate\Contracts\Debug\ExceptionHandler']
            );
        });
    }

}