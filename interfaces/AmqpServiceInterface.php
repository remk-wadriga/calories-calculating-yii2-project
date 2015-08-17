<?php

namespace app\interfaces;


interface AmqpServiceInterface
{
    /**
     * @param string $queue
     * @param string $message
     * @param \Closure $callback
     */
    public function send($queue = null, $message = '', $callback = null);

    /**
     * @param string $queue
     * @param \Closure $callback
     */
    public function receive($queue = null, $callback = null);
}