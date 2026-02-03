<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Facture {{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
            color: #333;
        }

        .header {
            margin-bottom: 30px;
        }

        .invoice-title {
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
                <div class="invoice-title">FACTURE</div>
                <p># {{ $invoice->invoice_number }}</p>
            </div>
            <div class="col text-end">
                @php $company = \App\Models\CompanySetting::first(); @endphp
                <h3>{{ $company?->company_name ?? 'Freelance Manager' }}</h3>
                <p>{{ $company?->company_email ?? 'contact@exemple.com' }}</p>
                <p>{{ $company?->company_address ?? 'Votre Adresse' }}</p>
                @if($company?->tax_number)
                <p>TVA/NIF: {{ $company->tax_number }}</p> @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <strong>Facturé à :</strong><br>
            {{ $invoice->client->name }}<br>
            @if($invoice->client->company) {{ $invoice->client->company }}<br> @endif
            {{ $invoice->client->email }}<br>
            {{ $invoice->client->address }}
        </div>
        <div class="col text-end">
            <strong>Date :</strong> {{ $invoice->issue_date->format('d/m/Y') }}<br>
            <strong>Échéance :</strong> {{ $invoice->due_date->format('d/m/Y') }}<br>
            <strong>Statut :</strong> {{ strtoupper($invoice->status) }}
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
            @foreach($invoice->items as $item)
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
            <div class="col text-end">{{ number_format($invoice->amount, 2) }} $</div>
        </div>
        <div class="row">
            <div class="col">Taxe ({{ $invoice->tax_percentage ?? 0 }}%) :</div>
            <div class="col text-end">{{ number_format($invoice->amount * (($invoice->tax_percentage ?? 0) / 100), 2) }}
                $</div>
        </div>
        <div class="total-row row">
            <div class="col">Total :</div>
            <div class="col text-end">
                {{ number_format($invoice->amount + ($invoice->amount * (($invoice->tax_percentage ?? 0) / 100)), 2) }}
                $
            </div>
        </div>
    </div>

    @if($invoice->notes)
        <div style="margin-top: 30px;">
            <strong>Notes :</strong><br>
            {{ $invoice->notes }}
        </div>
    @endif

    @php $company = \App\Models\CompanySetting::first(); @endphp
    @if($company && ($company->bank_name || $company->bank_iban || $company->invoice_footer_text))
        <div style="margin-top: 50px; border-top: 1px solid #eee; padding-top: 20px; font-size: 12px;">
            @if($company->bank_name || $company->bank_iban)
                <strong>Informations de Paiement :</strong><br>
                Banque: {{ $company->bank_name }} | IBAN: {{ $company->bank_iban }} | SWIFT: {{ $company->bank_swift }}<br><br>
            @endif
            @if($company->invoice_footer_text)
                {{ $company->invoice_footer_text }}
            @endif
        </div>
    @endif
</body>

</html>