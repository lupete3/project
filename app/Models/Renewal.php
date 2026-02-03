<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Renewal extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id',
        'project_id',
        'type',
        'service_name',
        'provider',
        'cost',
        'price',
        'margin',
        'start_date',
        'renewal_date',
        'status',
        'auto_renew',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'renewal_date' => 'date',
        'cost' => 'decimal:2',
        'price' => 'decimal:2',
        'margin' => 'decimal:2',
        'auto_renew' => 'boolean',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function calculateMargin()
    {
        $this->margin = (float) $this->price - (float) $this->cost;
        return (float) $this->margin;
    }
}
