<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Devis {{ $quote->quote_number }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
            color: #333;
        }

        .header {
            margin-bottom: 30px;
        }

        .quote-title {
            font-size: 24px;
            color: #556ee6;
            font-weight: bold;
        }

        .row {
            width: 100%;
            margin-bottom: 20px;
        }

        .col {
            width: 48%;
            display: inline-block;
            vertical-align: top;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th {
            background: #f8f9fa;
            padding: 10px;
            border-bottom: 2px solid #eee;
            text-align: left;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }

        .text-end {
            text-align: right;
        }

        .totals {
            margin-top: 30px;
            width: 300px;
            float: right;
        }

        .total-row {
            border-top: 2px solid #eee;
            padding-top: 10px;
            margin-top: 10px;
            font-weight: bold;
            font-size: 16px;
            color: #556ee6;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="row">
            <div class="col">
                <div class="quote-title">DEVIS</div>
                <p># {{ $quote->quote_number }}</p>
            </div>
            <div class="col text-end">
                @php $company = \App\Models\CompanySetting::first(); @endphp
                @if($company)
                    <h3>{{ $company->company_name }}</h3>
                    <p>{{ $company->company_email }}</p>
                    <p>{{ $company->company_address }}</p>
                    @if($company->tax_number)
                    <p>TVA/NIF: {{ $company->tax_number }}</p> @endif
                @else
                    <h3>Freelance Manager</h3>
                    <p>contact@exemple.com</p>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <strong>Client :</strong><br>
            {{ $quote->client->name }}<br>
            @if($quote->client->company) {{ $quote->client->company }}<br> @endif
            {{ $quote->client->email }}<br>
            {{ $quote->client->address }}
        </div>
        <div class="col text-end">
            <strong>Date :</strong> {{ $quote->issue_date->format('d/m/Y') }}<br>
            @if($quote->expiry_date)
                <strong>Expiration :</strong> {{ $quote->expiry_date->format('d/m/Y') }}<br>
            @endif
            <strong>Statut :</strong> {{ strtoupper($quote->status) }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th class="text-end">Qté</th>
                <th class="text-end">Prix Unitaire</th>
                <th class="text-end">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($quote->items as $item)
                <tr>
                    <td>{{ $item->description }}</td>
                    <td class="text-end">{{ $item->quantity }}</td>
                    <td class="text-end">{{ number_format($item->unit_price, 2) }} $</td>
                    <td class="text-end">{{ number_format($item->amount, 2) }} $</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <div class="row">
            <div class="col">Sous-total :</div>
            <div class="col text-end">{{ number_format($quote->amount, 2) }} $</div>
        </div>
        @if($quote->tax > 0)
            <div class="row">
                <div class="col">Taxe :</div>
                <div class="col text-end">{{ number_format($quote->tax, 2) }} $</div>
            </div>
        @endif
        <div class="total-row row">
            <div class="col">Total :</div>
            <div class="col text-end">
                {{ number_format($quote->amount + $quote->tax, 2) }} $
            </div>
        </div>
    </div>

    @if($quote->notes)
        <div style="margin-top: 30px;">
            <strong>Notes / Conditions :</strong><br>
            {{ $quote->notes }}
        </div>
    @endif

    <div style="margin-top: 50px; border-top: 1px solid #eee; padding-top: 20px; font-size: 12px; color: #777;">
        Ce devis est valable jusqu'au
        {{ $quote->expiry_date ? $quote->expiry_date->format('d/m/Y') : 'prochaine notification' }}.
    </div>
</body>

</html>