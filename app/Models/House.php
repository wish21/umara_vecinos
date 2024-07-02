<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class House extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'neighborhood_id', 'street', 'number'];

    public function neighborhood() : BelongsTo{
        return $this->belongsTo(Neighborhood::class);
    }
    public function user() : BelongsTo{
        return $this->belongsTo(User::class);
    }
    public function payment()
    {
        return $this->hasMany(Payment::class);
    }
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
