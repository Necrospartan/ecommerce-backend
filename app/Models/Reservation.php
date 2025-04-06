<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    /** @use HasFactory<\Database\Factories\ReservationFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'reservations';

    protected $fillable = [
        'user_id',
        'media_id',
        'start_date',
        'end_date',
        'total_price'
    ];

    protected $casts = [
        'total' => 'float'
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function media() : BelongsTo
    {
        return $this->belongsTo(Media::class);
    }

    public function availability() : HasMany
    {
        return $this->hasMany(Availability::class);
    }
}
