<?php

namespace app\extensions\amqp;

use Yii;
use app\abstracts\ExtensionAbstract;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

class AmqpExtension extends ExtensionAbstract
{
    const HELLO_QUEUE = 'queue_hello';

    /**
     * @var AmqpExtension[]
     */
    protected static $_identity;

    protected $_connection;
    protected $_channel;
    protected $_message;

    public $host;
    public $port;
    public $user;
    public $password;

    /**
     * @param string|array $config
     * @param string|null $queue
     * @return AmqpExtension
     * @throws \yii\base\InvalidConfigException
     */
    public static function getIdentity($config = [], $queue = null)
    {
        if (is_string($config)) {
            $queue = $config;
            $config = [];
        }

        if ($queue === null) {
            $queue = self::HELLO_QUEUE;
        }

        if (!isset(self::$_identity[$queue]) || self::$_identity[$queue] === null) {
            $config['class'] = self::className();
            self::$_identity[$queue] = Yii::createObject($config);
        }

        return self::$_identity[$queue];
    }

    /**
     * @return AMQPConnection
     */
    public function getConnection()
    {
        if ($this->_connection !== null) {
            return $this->_connection;
        }

        // Connect to broker
        return $this->_connection = new AMQPConnection($this->host, $this->port, $this->user, $this->password);
    }

    /**
     * @return AMQPChannel
     */
    public function getChannel()
    {
        if ($this->_channel !== null) {
            return $this->_channel;
        }

        // Get the channel
        return $this->_channel = $this->getConnection()->channel();
    }

    /**
     * @param string $message
     * @return AMQPMessage
     */
    public function createMessage($message = 'Hello world!')
    {
        return $this->_message = new AMQPMessage($message);
    }

    /**
     * @return AMQPMessage
     */
    public function getMessage()
    {
        if ($this->_message === null) {
            $this->_message = $this->createMessage();
        }

        return $this->_message;
    }

    public function declareQueue($queue=null, $passive=false, $durable=false, $exclusive=false, $autoDelete=false, $nowait=false, $arguments=null, $ticket=null)
    {
        if ($queue === null) {
            $queue = self::HELLO_QUEUE;
        }

        $this->getChannel()->queue_declare($queue, $passive, $durable, $exclusive, $autoDelete, $nowait, $arguments, $ticket);
    }

    public function publishMessage($message, $queue=null, $exchange='', $mandatory=false, $immediate=false, $ticket=null)
    {
        if ($queue === null) {
            $queue = self::HELLO_QUEUE;
        }

        $this->getChannel()->basic_publish($message, $exchange, $queue, $mandatory, $immediate, $ticket);
    }

    public function setCallback($callback, $queue = null, $consumerTag='', $noLocal=false, $noAck=true, $exclusive=false, $nowait=false, $ticket=null)
    {
        if ($queue === null) {
            $queue = self::HELLO_QUEUE;
        }

        $this->getChannel()->basic_consume($queue, $consumerTag, $noLocal, $noAck, $exclusive, $nowait, $callback, $ticket);
    }

    public function waitMessage($timeout=0, $allowedMethods=null, $nonBlocking=false)
    {
        $channel = $this->getChannel();
        while (count($channel->callbacks) > 0) {
            $channel->wait($allowedMethods, $nonBlocking, $timeout);
        }
    }

    public function close()
    {
        $this->getChannel()->close();
        $this->getConnection()->close();
    }
}