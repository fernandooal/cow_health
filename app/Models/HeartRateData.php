<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeartRateData extends Model
{
    protected $fillable = ['sensors_data_id', 'bpm'];

    public function sensorsData()
    {
        return $this->belongsTo(SensorsData::class);
    }
}
