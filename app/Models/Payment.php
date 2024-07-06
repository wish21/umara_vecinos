<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'house_id', 'concept', 'pay_date', 'amount', 'type', 'status',
    ];

    public function house()
    {
        return $this->belongsTo(House::class);
    }


}