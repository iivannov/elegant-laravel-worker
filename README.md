# Elegant Laravel Worker for Laravel 5.3

Elegant way to gracefully handle SIGTERM signal in Laravel 5.3 queue worker.
In Laravel >=5.4 this issue is beautifully handled.
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

## Use Case

Gracefully stop a Queue Worker by using SIGTERM signal.

### Why would I stop the Worker?

There are many cases that will require to restart the worker. 
- start/stop workers when auto-scaling
- temporarily stop the execution of tasks 
- reloading supervisor (or another monitoring tool) configuration


### Default Laravel Behaviour: 

When SIGTERM is received by the Worker it interrupts immediately the currently processed job, which may  break your application by not letting the job finish leading to unexpected results.

### Elegant Behaviour:

When SIGTERM is received by the Worker it will wait for the currently processed job to finish and then will exit gracefully.

### What do we solve?

- Interrupting long running jobs executing consecutive interrelated tasks 
- Interrupting in the middle of a DB transaction causing a deadlock
- Prevent repeating the execution of a an interrupted job when it is picked up again by a Worker



 
 
 

