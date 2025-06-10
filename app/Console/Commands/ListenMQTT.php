<?php

namespace App\Console\Commands;

use App\Jobs\ProcessSensorData;
use App\Services\MQTTService;
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
        $mqtt = new MQTTService();

        $this->info('Conectando ao broker MQTT e escutando o tópico...');

        $mqtt->subscribe('project_ch_ai/send', function ($topic, $message) {
            $this->info('Mensagem recebida!');
            $data = json_decode($message, true);
            try {
                ProcessSensorData::dispatch($data);
            } catch (\Throwable $e) {
                Log::error('Erro ao despachar job: ' . $e->getMessage());
            }
        });
    }

}
