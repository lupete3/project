<div>
    <div class="d-flex justify-content-between align-items-center mb-4 no-print">
        <h3 class="mb-0">Facture #{{ $invoice->invoice_number }}</h3>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary d-flex align-items-center" onclick="window.print()">
                <span class="material-symbols-outlined fs-18 me-1">print</span> Imprimer
            </button>
            <a href="{{ route('invoices.download', $invoice) }}"
                class="btn btn-outline-secondary d-flex align-items-center">
                <span class="material-symbols-outlined fs-18 me-1">download</span> PDF
            </a>
            <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-outline-info d-flex align-items-center">
                <span class="material-symbols-outlined fs-18 me-1">edit</span> Modifier
            </a>
            <a href="{{ route('invoices.index') }}" class="btn btn-secondary d-flex align-items-center">
                <span class="material-symbols-outlined fs-18 me-1">arrow_back</span> Retour
            </a>
        </div>
    </div>

    <div class="card border-0 rounded-10 border-white p-5">
        <div class="card-body p-0">
            <!-- Invoice Header -->
            <div class="row mb-5">
                <div class="col-sm-6">
                    <h2 class="text-primary mb-1">FACTURE</h2>
                    <p class="text-muted"># {{ $invoice->invoice_number }}</p>
                </div>
                <div class="col-sm-6 text-sm-end">
                    @php $company = \App\Models\CompanySetting::first(); @endphp
                    <h4 class="mb-1">{{ $company?->company_name ?? 'Freelance Manager' }}</h4>
                    <p class="text-muted mb-0">{{ $company?->company_email ?? 'contact@exemple.com' }}</p>
                    <p class="text-muted">{{ $company?->company_address ?? 'Votre Adresse' }}</p>
                </div>
            </div>

            <hr class="mb-5">

            <!-- Bill To Section -->
            <div class="row mb-5">
                <div class="col-sm-6">
                    <h6 class="text-muted text-uppercase mb-3">Facturé à :</h6>
                    <h5 class="mb-1 text-body">{{ $invoice->client->name }}</h5>
                    @if($invoice->client->company)
                        <p class="mb-1 text-secondary">{{ $invoice->client->company }}</p>
                    @endif
                    <p class="mb-1 text-secondary">{{ $invoice->client->email }}</p>
                    <p class="mb-0 text-secondary">{{ $invoice->client->address }}</p>
                </div>
                <div class="col-sm-6 text-sm-end">
                    <div class="mb-2">
                        <span class="text-muted">Date d'Émission :</span>
                        <span
                            class="fw-semibold ms-2 text-body">{{ $invoice->issue_date->translatedFormat('d M, Y') }}</span>
                    </div>
                    <div class="mb-2">
                        <span class="text-muted">Date d'Échéance :</span>
                        <span
                            class="fw-semibold ms-2 text-danger">{{ $invoice->due_date->translatedFormat('d M, Y') }}</span>
                    </div>
                    <div>
                        <span class="text-muted">Statut :</span>
                        @php
                            $statusMap = [
                                'paid' => ['label' => 'Payée', 'class' => 'success'],
                                'unpaid' => ['label' => 'Impayée', 'class' => 'danger'],
                                'partial' => ['label' => 'Partielle', 'class' => 'warning'],
                                'sent' => ['label' => 'Envoyée', 'class' => 'info'],
                                'draft' => ['label' => 'Brouillon', 'class' => 'secondary'],
                                'overdue' => ['label' => 'En retard', 'class' => 'danger'],
                            ];
                            $status = $statusMap[$invoice->status] ?? ['label' => $invoice->status, 'class' => 'secondary'];
                        @endphp
                        <span
                            class="badge bg-{{ $status['class'] }} bg-opacity-10 text-{{ $status['class'] }} text-capitalize ms-2 px-3 default-badge">
                            {{ $status['label'] }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Items Table -->
            <div class="default-table-area table-responsive mb-5 mx-minus-1">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th class="ps-3 fw-medium">Description</th>
                            <th class="text-center fw-medium">Quantité</th>
                            <th class="text-end fw-medium">Prix Unitaire</th>
                            <th class="text-end pe-3 fw-medium">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoice->items as $item)
                            <tr class="border-bottom">
                                <td class="ps-3 py-3 text-body">{{ $item->description }}</td>
                                <td class="text-center py-3 text-body">{{ $item->quantity }}</td>
                                <td class="text-end py-3 text-body">$ {{ number_format($item->unit_price, 2) }}</td>
                                <td class="text-end pe-3 py-3 fw-semibold text-body">
                                    $ {{ number_format($item->quantity * $item->unit_price, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Totals -->
            <div class="row">
                <div class="col-sm-7">
                    @if($invoice->notes)
                        <h6 class="text-muted mb-2">Notes :</h6>
                        <p class="text-muted">{{ $invoice->notes }}</p>
                    @endif

                    @php $company = \App\Models\CompanySetting::first(); @endphp
                    @if($company && ($company->bank_name || $company->bank_iban || $company->invoice_footer_text))
                        <div class="mt-4 pt-3 border-top">
                            @if($company->bank_name || $company->bank_iban)
                                <h6 class="text-muted mb-2">Paiement :</h6>
                                <p class="text-muted small mb-1">Banque: {{ $company->bank_name }}</p>
                                <p class="text-muted small mb-1">IBAN: {{ $company->bank_iban }}</p>
                                <p class="text-muted small mb-3">SWIFT: {{ $company->bank_swift }}</p>
                            @endif
                            @if($company->invoice_footer_text)
                                <p class="text-muted small italic">{{ $company->invoice_footer_text }}</p>
                            @endif
                        </div>
                    @endif
                </div>
                <div class="col-sm-5">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Sous-total :</span>
                        <span class="fw-semibold text-body">$ {{ number_format($invoice->amount, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                        <span class="text-muted">Taxe ({{ $invoice->tax_percentage }}%) :</span>
                        <span class="fw-semibold text-body">$
                            {{ number_format($invoice->amount * ($invoice->tax_percentage / 100), 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Montant Total :</h4>
                        <h3 class="mb-0 text-primary">$ {{ number_format($invoice->amount_with_tax, 2) }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            .main-content {
                margin-left: 0 !important;
                padding: 0 !important;
            }

            .sidebar-area {
                display: none !important;
            }

            .header-area {
                display: none !important;
            }

            .card {
                box-shadow: none !important;
                border: none !important;
            }
        }
    </style>
</div>