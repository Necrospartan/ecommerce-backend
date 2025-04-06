<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Availability extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'media_id',
        'reserved_date'
    ];

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }
}
