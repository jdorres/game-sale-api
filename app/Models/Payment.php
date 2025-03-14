<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Payment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'purchase_id',
        'payment_method_id',
        'gateway_id',
        'amount',
        'due_date',
        'payment_date',
        'status'
    ];

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class);
    }

    public function payment_methods(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function gateways(): BelongsTo
    {
        return $this->belongsTo(Gateway::class);
    }
}
