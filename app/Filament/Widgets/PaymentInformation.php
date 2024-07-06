<?php
namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use App\Models\Payment;

class PaymentInformation extends BaseWidget
{


     public function getStats(): array
     {
        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
         if (auth()->user()->roles[0]['name']=== 'Vecino') {
             $house = DB::table('houses')->where('user_id',auth()->user()->id)->get();
             $totalPagos = DB::table('payments')->where('house_id',$house[0]->id)->whereYear('pay_date',date('Y'))->count();

             $pago_del_mes = Payment::isCurrentMonthRegistered($house[0]->id);
             if ($pago_del_mes) {
                $pagodelmes="Pagado";
                $pagodelmes_color="success";
             }else{
                $pagodelmes="Adeudo";
                $pagodelmes_color="danger";
             }
             $pagos_del_anio = Payment::areCurrentAndPreviousMonthsRegistered($house[0]->id);
             $pagodelanio_color="danger";
             $etiqueta_pagos=" meses";
             if($pagos_del_anio==1){
                $etiqueta_pagos=" mes";
             }
             if($pagos_del_anio==0){
                $pagodelanio_color="success";
             }



             return[
                Stat::make('Total de Pagos', $totalPagos)
                ->description('Año: '.date('Y'))
                ->descriptionIcon('heroicon-o-banknotes')
                ->color('success'),
                Stat::make('Pago del mes', $meses[date('n') - 1].' - '.date('Y'))
                ->description($pagodelmes)
                ->descriptionIcon('heroicon-o-banknotes')
                ->color($pagodelmes_color),
                Stat::make('Adeudos del año', $pagos_del_anio.' '.$etiqueta_pagos)
                ->description('Año - '.date('Y'))
                ->descriptionIcon('heroicon-o-banknotes')
                ->color($pagodelanio_color),
            ];


         }
         if (auth()->user()->roles[0]['name'] === 'Administrador') {
            $totalPagos = DB::table('payments')->whereYear('pay_date',date('Y'))->count();



            return[
                Stat::make('Total de Pagos', $totalPagos)
                ->description('Año: '.date('Y'))
                ->descriptionIcon('heroicon-o-home')
                ->color('success'),
                Stat::make('Processed', '192.1k')
            ->color('success')
            ->extraAttributes([
                'class' => 'cursor-pointer',
                'wire:click' => "\$dispatch('setStatusFilter', { filter: 'processed' })",
            ]),

            ];
         }


     }
}