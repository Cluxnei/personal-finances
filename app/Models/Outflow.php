<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class Outflow extends Model
{
    use HasFactory;

    protected $table = 'outflows';

    protected $fillable = [
        'name', 'description', 'amount', 'date', 'category_id', 'user_id',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeStartsAt(Builder $query, string $date): Builder
    {
        return $query->whereDate('date', '>=', Carbon::parse($date)->startOfDay()->toDateTimeString());
    }

    public function scopeEndsAt(Builder $query, string $date): Builder
    {
        return $query->whereDate('date', '<=', Carbon::parse($date)->startOfDay()->toDateTimeString());
    }
}
