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
        'house_id', 'concept', 'pay_date', 'amount', 'type',
    ];

    public function house()
    {
        return $this->belongsTo(House::class);
    }



    public static function isCurrentMonthRegistered($houseId)
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        return self::where('house_id', $houseId)
                    ->whereMonth('pay_date', $currentMonth)
                    ->whereYear('pay_date', $currentYear)
                    ->exists();
    }

    public static function areCurrentAndPreviousMonthsRegistered($houseId)
    {
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        // Crear un arreglo con todos los meses desde el inicio del año hasta el mes actual
        $months = range(1, $currentMonth);

        // Consultar pagos para cada mes del año actual
        $payments = self::where('house_id', $houseId)
                        ->whereYear('pay_date', $currentYear)
                        ->whereIn(DB::raw('MONTH(pay_date)'), $months)
                        ->get()
                        ->groupBy(function ($date) {
                            return Carbon::parse($date->pay_date)->format('m'); // Agrupar por mes
                        });
        // Verificar si hay pagos para todos los meses del año actual hasta el mes actual
        $contador=0;
        foreach ($months as $month) {
            if (!isset($payments[str_pad($month, 2, '0', STR_PAD_LEFT)])) {
                $contador++; // Si falta un mes, devolver false
            }
        }

        return $contador; // Si todos los meses tienen pagos, devolver true
    }

    public static function getDebtors()
    {
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        // Get all houses
        $houses = House::with('payments')->get();

        $debtors = [];

        foreach ($houses as $house) {
            $monthsPaid = $house->payments()
                ->whereYear('pay_date', $currentYear)
                ->pluck('pay_date')
                ->map(function ($date) {
                    return Carbon::parse($date)->month;
                })->unique()->toArray();

            $monthsDue = array_diff(range(1, $currentMonth), $monthsPaid);

            if (count($monthsDue) > 0) {

                $monthsDueNames = array_map(function ($month) {
                    return Str::of(Carbon::create()->month($month)->monthName)->ucfirst();
                }, $monthsDue);


                $debtors[] = [
                    'house' => $house,
                    'months_due' => count($monthsDue),
                    'months_due_list' => $monthsDueNames,
                ];
            }
        }

        return $debtors;
    }
}
