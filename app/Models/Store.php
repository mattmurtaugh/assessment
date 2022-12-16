<?php

namespace App\Models;

use App\Models\Scopes\BelongsToUserScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Store extends Model
{
    use HasFactory;

    protected $fillable = ['brand_id', 'user_id', 'number', 'address', 'city', 'state', 'zip_code'];

    protected static function booted()
    {
        static::addGlobalScope(new BelongsToUserScope);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function journals(): HasMany
    {
        return $this->hasMany(Journal::class);
    }

    public function scopeBelongsToUser(Builder $query, $user = null)
    {
        return $query->where('user_id', $user ?? Auth::id());
    }

    public function getTotalRevenueAttribute() {
        return $this->journals()->sum('revenue');
    }

    public function getTotalProfitAttribute() {
        return $this->journals()->sum('profit');
    }
}
