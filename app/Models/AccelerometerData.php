<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccelerometerData extends Model
{
    protected $fillable = [
        'sensors_data_id',
        'gyro_x',
        'gyro_y',
        'gyro_z',
        'accel_x',
        'accel_y',
        'accel_z',
        'active'
    ];

    public function sensorsData()
    {
        return $this->belongsTo(SensorsData::class);
    }
}
