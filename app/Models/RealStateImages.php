<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealStateImages extends Model
{
    use HasFactory;

    protected $fillable = [
        'photo', 'is_thumb'
    ];

    public function realStates()
    {
        return $this->belongsTo(RealState::class);
    }
}
