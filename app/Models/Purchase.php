<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Purchase extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id'
    ];

    /**
     * The games that belong to the purchase
     */
    public function purchases(): BelongsToMany
    {
        return $this->belongsToMany(Game::class, 'purchase_games');
    }

    /**
     * The payments that belong to the purchase
     */
    public function payments(): BelongsToMany
    {
        return $this->belongsToMany(Payment::class, 'purchase_payments');
    }
}
