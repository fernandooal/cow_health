<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemperatureData extends Model
{
    protected $fillable = ['collar_id', 'temperature'];

    public function collar()
    {
        return $this->belongsTo(Collar::class, 'collar_id');
    }
}
