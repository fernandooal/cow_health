<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeartRateData extends Model
{
    use HasFactory;
    protected $fillable = ['cow_id', 'bpm', 'created_at', 'updated_at'];

    public function cow()
    {
        return $this->belongsTo(Cow::class, 'cow_id');
    }
}
