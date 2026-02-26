<div>
    <div class="d-flex justify-content-between align-items-center mb-4 no-print">
        <h3 class="mb-0">Devis #{{ $quote->quote_number }}</h3>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary d-flex align-items-center" onclick="window.print()">
                <span class="material-symbols-outlined fs-18 me-1">print</span> Imprimer
            </button>
            <a href="{{ route('quotes.download', $quote) }}"
                class="btn btn-outline-secondary d-flex align-items-center">
                <span class="material-symbols-outlined fs-18 me-1">download</span> PDF
            </a>
            <a href="{{ route('quotes.edit', $quote) }}" class="btn btn-outline-info d-flex align-items-center">
                <span class="material-symbols-outlined fs-18 me-1">edit</span> Modifier
            </a>
            <a href="{{ route('quotes.index') }}" class="btn btn-secondary d-flex align-items-center">
                <span class="material-symbols-outlined fs-18 me-1">arrow_back</span> Retour
            </a>
        </div>
    </div>

    <div class="card border-0 rounded-10 border-white p-5">
        <div class="card-body p-0">
            <!-- Quote Header -->
            <div class="row mb-5">
                <div class="col-sm-6">
                    <h2 class="text-primary mb-1">DEVIS</h2>
                    <p class="text-muted"># {{ $quote->quote_number }}</p>
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
                    <h6 class="text-muted text-uppercase mb-3">Client :</h6>
                    <h5 class="mb-1 text-body">{{ $quote->client->name }}</h5>
                    @if($quote->client->company)
                        <p class="mb-1 text-secondary">{{ $quote->client->company }}</p>
                    @endif
                    <p class="mb-1 text-secondary">{{ $quote->client->email }}</p>
                    <p class="mb-0 text-secondary">{{ $quote->client->address }}</p>
                </div>
                <div class="col-sm-6 text-sm-end">
                    <div class="mb-2">
                        <span class="text-muted">Date d'Émission :</span>
                        <span
                            class="fw-semibold ms-2 text-body">{{ $quote->issue_date->translatedFormat('d M, Y') }}</span>
                    </div>
                    @if($quote->expiry_date)
                        <div class="mb-2">
                            <span class="text-muted">Date d'Expiration :</span>
                            <span
                                class="fw-semibold ms-2 text-danger">{{ $quote->expiry_date->translatedFormat('d M, Y') }}</span>
                        </div>
                    @endif
                    <div>
                        <span class="text-muted">Statut :</span>
                        @php
                            $statusMap = [
                                'accepted' => ['label' => 'Accepté', 'class' => 'success'],
                                'rejected' => ['label' => 'Rejeté', 'class' => 'danger'],
                                'sent' => ['label' => 'Envoyé', 'class' => 'info'],
                                'draft' => ['label' => 'Brouillon', 'class' => 'secondary'],
                                'cancelled' => ['label' => 'Annulé', 'class' => 'warning'],
                            ];
                            $status = $statusMap[$quote->status] ?? ['label' => $quote->status, 'class' => 'secondary'];
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
                        @foreach($quote->items as $item)
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
                    @if($quote->notes)
                        <h6 class="text-muted mb-2">Notes / Conditions :</h6>
                        <p class="text-muted">{{ $quote->notes }}</p>
                    @endif

                    <div class="mt-4 no-print">
                        <h6 class="text-muted mb-2">Mettre à jour le statut :</h6>
                        <div class="btn-group" role="group">
                            <button type="button" wire:click="updateStatus('accepted')"
                                class="btn btn-outline-success btn-sm">Accepté</button>
                            <button type="button" wire:click="updateStatus('rejected')"
                                class="btn btn-outline-danger btn-sm">Rejeté</button>
                            <button type="button" wire:click="updateStatus('sent')"
                                class="btn btn-outline-info btn-sm">Envoyé</button>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Sous-total :</span>
                        <span class="fw-semibold text-body">$ {{ number_format($quote->amount, 2) }}</span>
                    </div>
                    @if($quote->tax > 0)
                        <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                            <span class="text-muted">Taxe :</span>
                            <span class="fw-semibold text-body">$ {{ number_format($quote->tax, 2) }}</span>
                        </div>
                    @endif
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Montant Total :</h4>
                        <h3 class="mb-0 text-primary">$ {{ number_format($quote->amount + $quote->tax, 2) }}</h3>
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