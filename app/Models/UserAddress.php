<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAddress extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'client_id',
        'country',
        'zipcode',
        'state',
        'city',
        'district',
        'street',
        'number',
        'complement'
    ];

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
