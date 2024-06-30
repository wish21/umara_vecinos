<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class PdfController extends Controller
{
    public function generateReceipt($id)
    {
        $payment = Payment::findOrFail($id);
        $houses = DB::table('houses')->where('id',$payment->house_id)->get();
        $users = User::findOrFail($houses[0]->user_id);
        $pdf = Pdf::loadView('pdf.receipt', ['payment' => $payment, 'houses' => $houses, 'users' => $users]);

        $nombre_archivo=Str::slug($houses[0]->street.'-'.$houses[0]->number."-".$payment->pay_date, '-');

        return $pdf->download($nombre_archivo.'.pdf');
    }
}