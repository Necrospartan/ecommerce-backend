<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{
    /** @use HasFactory<\Database\Factories\MediaFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'media';

    protected $fillable = [
        'name',
        'location',
        'type',
        'image',
        'price_per_day',
    ];

    protected $casts = [
        'price_per_day' => 'float',
    ];

    public function reservations() : HasMany {
        return $this->hasMany(Reservation::class);
    }
}
