<?php
namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class HouseCount extends BaseWidget
{
     
     
     public function getStats(): array
     {
         if (auth()->user()->roles[0]['name']=== 'Vecino') {
             $house = DB::table('houses')->where('user_id',auth()->user()->id)->get();
         
         $totalPagos = DB::table('payments')->where('house_id',$house[0]->id)->whereYear('pay_date',date('Y'))->count();
         }
         if (auth()->user()->roles[0]['name'] === 'Administrador') {
           $totalPagos = DB::table('payments')->whereYear('pay_date',date('Y'))->count();
         
         }
         
           return[
             Stat::make('Total de Pagos', $totalPagos)
             ->description('Año: '.date('Y'))
             ->descriptionIcon('heroicon-o-home')
             ->color('success'),
         ];
     }
}