<?php

namespace App\Jobs;

use App\Models\Collar;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessSensorData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function handle(): void
    {
        $deviceId = $this->data['device_id'] ?? null;
        $sensorData = $this->data['sensors'] ?? [];

        //incomplete data
        if (!$deviceId || empty($sensorData)) {
            return;
        }

        $collar = Collar::where('name', $deviceId)->first();
        //collar not found
        if (!$collar) {
            return;
        }

        $cow = $collar->cow;
        //cow not found
        if (!$cow) {
            return;
        }

        if (isset($sensorData['max30102']['heart_rate'])) {
            $cow->heartRateDatas()->create([
                'bpm' => $sensorData['max30102']['heart_rate'],
                'created_at' => $this->data['datetime']
            ]);
        }

        if (isset($sensorData['mlx']['object_temp'])) {
            $cow->temperatureDatas()->create([
                'temperature' => $sensorData['mlx']['object_temp'],
                'created_at' => $this->data['datetime']
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
                'created_at' => $this->data['datetime']
            ]);
        }

        AnalyzeCowHealth::dispatch($cow);
    }
}

