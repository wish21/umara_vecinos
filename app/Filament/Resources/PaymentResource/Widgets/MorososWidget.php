<?php

namespace App\Filament\Resources\PaymentResource\Widgets;

use Filament\Widgets\Widget;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class MorososWidget extends Widget
{
    protected static string $view = 'filament.resources.payment-resource.widgets.morosos-widget';

    public static function canView(): bool
    {
        // Check if the authenticated user has the 'admin' role
        return Auth::user() && auth()->user()->roles[0]['name'] === 'Administrador';
    }

    protected function getViewData(): array
    {
        $debtors = Payment::getDebtors();

        return [
            'debtors' => $debtors,
        ];
    }
}
