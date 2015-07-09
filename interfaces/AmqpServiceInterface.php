<?php

namespace app\interfaces;


interface AmqpServiceInterface
{
    /**
     * @param string|null $queue
     * @param string $message
     * @param \Closure|null $callback
     */
    public function send($queue = null, $message = '', $callback = null);

    /**
     * @param string|null $queue
     * @param \Closure|null $callback
     */
    public function receive($queue = null, $callback = null);
}