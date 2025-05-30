<?php

namespace App\Console\Commands;

use App\Services\MqttService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ListenMQTT extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'listen:mqtt';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start listening to a MQTT topic, waiting for new messages.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $mqtt = new MqttService();
        $mqtt->subscribe('iot/sensor/temperatura', function ($topic, $message) {
            Log::info("Recebido do tópico {$topic}: {$message}");


        });
    }
}
