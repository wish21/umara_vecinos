<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;
use Illuminate\Support\Str;

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

    protected static function booted()
    {
        static::created(function ($house) {
            // Obtener el año actual
            $currentYear = Carbon::now()->year;

            // Crear los pagos para cada mes del año actual
            for ($month = 1; $month <= 12; $month++) {
                $payment = new Payment([
                    'house_id' => $house->id,
                    'concept' => 'Mensualidad del mes: '.Str::ucfirst(Carbon::create()->month($month)->translatedFormat('F')).' de '.date('Y'),
                    'amount' => 0, // Debes establecer el monto adecuado aquí
                    'status' => 0,
                    'type' => 'mensual', // Debes establecer el tipo adecuado aquí
                ]);

                // Guardar el pago
                $payment->save();
            }
        });
    }
}