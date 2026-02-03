<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Aperçu Financier</h3>
        <div class="d-flex gap-2">
            <a href="{{ route('finances.expenses.create') }}" class="btn btn-outline-danger d-flex align-items-center">
                <span class="material-symbols-outlined me-1">remove_circle</span> Enregistrer une Dépense
            </a>
            <a href="{{ route('finances.revenues.create') }}" class="btn btn-outline-success d-flex align-items-center">
                <span class="material-symbols-outlined me-1">add_circle</span> Enregistrer un Revenu
            </a>
        </div>
    </div>

    <!-- Financial Cards -->
    <div class="row">
        <div class="col-lg-4">
            <div class="card border-0 rounded-10 p-4 mb-4 bg-success bg-opacity-10 border-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="d-block mb-1 text-success fw-bold">Revenu Total</span>
                        <h2 class="mb-0 text-success">$ {{ number_format($totalRevenue, 2) }}</h2>
                    </div>
                    <div class="stats-icon bg-success text-white rounded-circle d-flex align-items-center justify-content-center"
                        style="width: 50px; height: 50px;">
                        <span class="material-symbols-outlined">payments</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 rounded-10 p-4 mb-4 bg-danger bg-opacity-10 border-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="d-block mb-1 text-danger fw-bold">Dépenses Totales</span>
                        <h2 class="mb-0 text-danger">$ {{ number_format($totalExpenses, 2) }}</h2>
                    </div>
                    <div class="stats-icon bg-danger text-white rounded-circle d-flex align-items-center justify-content-center"
                        style="width: 50px; height: 50px;">
                        <span class="material-symbols-outlined">shopping_cart</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 rounded-10 p-4 mb-4 bg-primary bg-opacity-10 border-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="d-block mb-1 text-primary fw-bold">Bénéfice Net</span>
                        <h2 class="mb-0 text-primary">$ {{ number_format($profit, 2) }}</h2>
                    </div>
                    <div class="stats-icon bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                        style="width: 50px; height: 50px;">
                        <span class="material-symbols-outlined">account_balance_wallet</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Revenue -->
        <div class="col-lg-6">
            <div class="card border-0 rounded-10 mb-4 border-white">
                <div class="card-body p-4">
                    <h5 class="mb-4">Revenu Récent</h5>
                    <div class="default-table-area table-responsive mx-minus-1">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th class="fw-medium">Date</th>
                                    <th class="fw-medium">Projet</th>
                                    <th class="fw-medium text-end">Montant</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($revenues as $revenue)
                                    <tr>
                                        <td class="text-body">{{ $revenue->revenue_date->translatedFormat('d M, Y') }}</td>
                                        <td class="text-body fw-medium">
                                            {{ $revenue->project ? $revenue->project->name : 'Général' }}
                                        </td>
                                        <td class="text-success fw-bold text-end">+$
                                            {{ number_format($revenue->amount, 2) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4 text-muted">Aucun revenu enregistré pour le
                                            moment.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Expenses -->
        <div class="col-lg-6">
            <div class="card border-0 rounded-10 mb-4 border-white">
                <div class="card-body p-4">
                    <h5 class="mb-4">Dépenses Récentes</h5>
                    <div class="default-table-area table-responsive mx-minus-1">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th class="fw-medium">Date</th>
                                    <th class="fw-medium">Catégorie/Projet</th>
                                    <th class="fw-medium text-end">Montant</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($expenses as $expense)
                                    <tr>
                                        <td class="text-body">{{ $expense->expense_date->translatedFormat('d M, Y') }}</td>
                                        <td>
                                            <div class="fs-14 fw-semibold text-body">{{ $expense->category }}</div>
                                            <div class="fs-12 text-muted">
                                                {{ $expense->project ? $expense->project->name : 'Entreprise' }}
                                            </div>
                                        </td>
                                        <td class="text-danger fw-bold text-end">-$ {{ number_format($expense->amount, 2) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4 text-muted">Aucune dépense enregistrée pour
                                            le moment.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>