<?php

namespace app\components;

use Yii;
use app\abstracts\ServiceAbstract;
use app\interfaces\AmqpServiceInterface;
use yii\helpers\Json;
use yii\base\ErrorException;
use app\extensions\amqp\AmqpExtension;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

class AmqpService extends ServiceAbstract implements AmqpServiceInterface
{
    protected $config = [];

    public $host = 'localhost';
    public $port = 5672;
    public $user = 'guest';
    public $password = 'guest';
    public $queue;
    public $timeOut = 0;
    public $callback;


    public function init()
    {
        parent::init();

        $this->config = [
            'host' => $this->host,
            'port' => $this->port,
            'user' => $this->user,
            'password' => $this->password
        ];

        $this->callback = function(AMQPMessage $message){
            return $this->defaultHandler($message);
        };
    }

    /**
     * @param array|\stdClass|string $message
     * @param string|null $queue
     * @param null|\Closure $callback
     * @throws ErrorException
     */
    public function send($queue = null, $message = '', $callback = null)
    {
        if ($queue !== null) {
            $this->queue = $queue;
        }

        if (empty($this->queue)) {
            throw new ErrorException("Queue is not set");
        }

        if (!empty($callback)) {
            $this->callback = $callback;
        }

        if (!($this->callback instanceof \Closure)) {
            throw new ErrorException("Callback function mast be valid callback");
        }

        if (!is_string($message)) {
            $message = Json::encode($message);
        }

        $driver = $this->getDriver();
        $message = $driver->createMessage($message);

        // Declare the queue
        $driver->declareQueue($this->queue);

        // Publish a message to the queue
        $driver->publishMessage($message, $this->queue);

        // Close the channel and the connection
        $driver->close();
    }

    /**
     * @param string|null $queue
     * @param null|\Closure $callback
     * @throws ErrorException
     */
    public function receive($queue = null, $callback = null)
    {
        if ($queue !== null) {
            $this->queue = $queue;
        }

        if (empty($this->queue)) {
            throw new ErrorException("Queue is not set");
        }

        if (!empty($callback)) {
            $this->callback = $callback;
        }

        if (!($this->callback instanceof \Closure)) {
            throw new ErrorException("Callback function mast be valid callback");
        }

        $callback = $this->createCallback($this->callback);

        $driver = $this->getDriver();

        // Declare the queue
        $driver->declareQueue($this->queue);
        $driver->setCallback($callback, $this->queue);

        // Wait for messages
        $driver->waitMessage($this->timeOut);
    }

    /**
     * @return AmqpExtension
     */
    protected function getDriver()
    {
        return AmqpExtension::getIdentity($this->config, $this->queue);
    }

    /**
     * @return AMQPConnection
     */
    public function getConnection()
    {
        return $this->getDriver()->getConnection();
    }

    /**
     * @return AMQPChannel
     */
    protected function getChannel()
    {
        return $this->getDriver()->getChannel();
    }

    protected function createCallback($callback)
    {
        return function($message) use ($callback) {
            if ($message instanceof AMQPMessage) {
                $message = $message->body;
            }

            if (is_string($message)) {
                try {
                    $json = Json::decode($message);
                } catch (\Exception $e) {
                    $json = null;
                }

                if ($json !== null) {
                    $message = $json;
                }
            }

            return call_user_func($callback, $message);
        };
    }

    protected function defaultHandler($message)
    {
        if ($message instanceof Message) {
            $message = $message->body;
        }

        echo "\n<---------------------->\n";
        print_r($message);
        echo "\n<---------------------->\n";
        return true;
    }
}