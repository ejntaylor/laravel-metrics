<?php

namespace Ejntaylor\LaravelMetrics\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $key
 * @property int $value
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class AggregatedMetric extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'total',
        'platform_id',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function platform(): BelongsTo
    {
        return $this->belongsTo(config('metrics.parent'));
    }
}
