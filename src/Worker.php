<?php

namespace Iivannov\ElegantWorker;

use Illuminate\Queue\WorkerOptions;

class Worker extends \Illuminate\Queue\Worker
{

    /**
     * Shows if worker should exit after completing the current job
     *
     * @var bool
     */
    protected $exit;


    /**
     * Listen to the given queue in a loop.
     *
     * @param  string $connectionName
     * @param  string $queue
     * @param  \Illuminate\Queue\WorkerOptions $options
     * @return void
     */
    public function daemon($connectionName, $queue, WorkerOptions $options)
    {
        $lastRestart = $this->getTimestampOfLastQueueRestart();

        $this->registerSignalListener();

        while (true) {
            $this->registerTimeoutHandler($options);

            if ($this->daemonShouldRun($options)) {
                $this->runNextJob($connectionName, $queue, $options);
            } else {
                $this->sleep($options->sleep);
            }

            $this->callSignalHandler();

            if ($this->memoryExceeded($options->memory) ||
                $this->queueShouldRestart($lastRestart) ||
                $this->queueShouldExit()
            ) {
                $this->stop();
            }
        }
    }

    /**
     * Register listener for SIGTERM signal
     *
     */
    protected function registerSignalListener()
    {
        if (!extension_loaded('pcntl')) {
            return;
        }

        pcntl_signal(SIGTERM, function () {
            $this->exit = true;
        });
    }

    /**
     * Determine if the worker should exit because of a SIGTERM signal
     *
     * @return bool
     */
    protected function queueShouldExit()
    {
        return $this->exit;
    }

    /**
     * Calls signal handlers for pending signals
     */
    protected function callSignalHandler()
    {
        pcntl_signal_dispatch();
    }
}