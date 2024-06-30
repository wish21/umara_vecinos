<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Receipt</title>
    <style>
        /* Estilos para el PDF */
        body {
            font-family: DejaVu Sans, sans-serif;
        }
        .receipt-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .receipt-details {
            margin: 0 auto;
            width: 80%;
        }
        .receipt-details th, .receipt-details td {
            text-align: left;
            padding: 8px;
        }
    </style>
</head>
<body>
    <div class="receipt-header">
        <h1>Recibo</h1>
        <p><strong>Nombre:</strong> {{ $users->name  }}</p>
        <p><strong>Direccción:</strong> {{ $houses[0]->street  }} {{ $houses[0]->number  }}</p>
    </div>
    <div class="receipt-details">
        <table>
            <tr>
                <th>Concepto:</th>
                <td>{{ $payment->concept }}</td>
            </tr>
            <tr>
                <th>Monto:</th>
                <td>{{ $payment->amount }}</td>
            </tr>
            <tr>
                <th>Fecha de Pago:</th>
                <td>{{ $payment->pay_date }}</td>
            </tr>
            <tr>
                <th>Tipo:</th>
                <td>{{ $payment->type }}</td>
            </tr>
        </table>
    </div>
</body>
</html>
