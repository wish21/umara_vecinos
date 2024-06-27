<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'house_id', 'concept', 'pay_date', 'amount', 'type',
    ];

    public function house()
    {
        return $this->belongsTo(House::class);
    }
}
