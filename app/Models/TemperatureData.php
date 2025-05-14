<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemperatureData extends Model
{
    protected $fillable = ['sensors_data_id', 'temperature'];

    public function sensorsData()
    {
        return $this->belongsTo(SensorsData::class);
    }
}
