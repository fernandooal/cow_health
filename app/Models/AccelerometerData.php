<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccelerometerData extends Model
{
    use HasFactory;
    protected $fillable = [
        'cow_id',
        'gyro_x',
        'gyro_y',
        'gyro_z',
        'accel_x',
        'accel_y',
        'accel_z',
    ];

    public function cow()
    {
        return $this->belongsTo(Cow::class, 'cow_id');
    }
}
