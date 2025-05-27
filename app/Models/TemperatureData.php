<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemperatureData extends Model
{
    use HasFactory;
    protected $fillable = ['cow_id', 'temperature'];

    public function cow()
    {
        return $this->belongsTo(Cow::class, 'cow_id');
    }
}
