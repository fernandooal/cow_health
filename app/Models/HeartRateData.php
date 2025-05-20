<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeartRateData extends Model
{
    protected $fillable = ['collar_id', 'bpm'];

    public function collar()
    {
        return $this->belongsTo(Collar::class);
    }
}
