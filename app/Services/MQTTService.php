<?php

namespace App\Services;

use PhpMqtt\Client\Exceptions\ProtocolNotSupportedException;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;

class MqttService
{
    protected $mqtt;

    public function __construct()
    {
        $this->mqtt = new MqttClient('broker.hivemq.com', 1883, 'cow_health_web');
    }

    public function subscribe(string $topic, callable $callback)
    {
        $settings = (new ConnectionSettings)
            ->setKeepAliveInterval(60)
            ->setLastWillTopic('app/lastwill')
            ->setLastWillMessage('Client disconnected')
            ->setLastWillQualityOfService(1);

        $this->mqtt->connect($settings, true);

        $this->mqtt->subscribe($topic, function ($topic, $message) use ($callback) {
            $callback($topic, $message);
        }, 0);

        $this->mqtt->loop(true);
        $this->mqtt->disconnect();
    }

    public function publish(string $topic, string $message)
    {
        $settings = (new ConnectionSettings)->setKeepAliveInterval(60);
        $this->mqtt->connect($settings, true);
        $this->mqtt->publish($topic, $message, 0);
        $this->mqtt->disconnect();
    }
}
