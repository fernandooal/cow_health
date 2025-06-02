<?php

namespace App\Jobs;

use App\Models\Collar;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessSensorData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function handle(): void
    {
        $deviceId = $this->data['device_id'] ?? null;
        $sensorData = $this->data['sensors'] ?? [];

        if (!$deviceId || empty($sensorData)) {
            Log::warning('MQTT: Dados incompletos recebidos.', $this->data);
            return;
        }

        $collar = Collar::where('name', $deviceId)->first();
        if (!$collar) {
            Log::warning("MQTT: Collar não encontrado para device_id: {$deviceId}");
            return;
        }

        $cow = $collar->cow;
        if (!$cow) {
            Log::warning("MQTT: Vaca não encontrada para o collar de device_id: {$deviceId}");
            return;
        }

        if (isset($sensorData['max30102']['heart_rate'])) {
            $cow->heartRateDatas()->create([
                'bpm' => $sensorData['max30102']['heart_rate'],
            ]);
        }

        if (isset($sensorData['mlx']['object_temp'])) {
            $cow->temperatureDatas()->create([
                'temperature' => $sensorData['mlx']['object_temp'],
            ]);
        }

        if (isset($sensorData['mpu']['acc'], $sensorData['mpu']['gyro'])) {
            [$accelX, $accelY, $accelZ] = $sensorData['mpu']['acc'];
            [$gyroX, $gyroY, $gyroZ] = $sensorData['mpu']['gyro'];

            $cow->accelerometerDatas()->create([
                'accel_x' => $accelX,
                'accel_y' => $accelY,
                'accel_z' => $accelZ,
                'gyro_x' => $gyroX,
                'gyro_y' => $gyroY,
                'gyro_z' => $gyroZ,
            ]);
        }

        Log::info("MQTT: Dados salvos com sucesso para cow_id={$cow->id}");
    }
}

