# Elegant Laravel Worker

Elegant way to gracefully handle SIGTERM signal in Laravel queue worker.
----------


## Install

Via Composer

``` bash
$ composer require iivannov/elegant-laravel-worker
```


## Register in Laravel

To replace the default Queue Worker with this one, you need to add the ElegantWorkerServiceProvider class to the providers array in your `config\app.php`

``` php

'providers' => [
    ...
    Iivannov\ElegantWorker\ElegantWorkerServiceProvider::class,
];

```
