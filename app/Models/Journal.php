<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Journal extends Model
{
    use HasFactory;

    protected $fillable = ['store_id', 'date', 'revenue', 'food_cost', 'labor_cost', 'profit'];

    protected $casts = [
        'date' => 'date'
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}
