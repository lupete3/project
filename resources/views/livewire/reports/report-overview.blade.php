<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Analytics & Reports</h3>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary d-flex align-items-center" onclick="window.print()">
                <span class="material-symbols-outlined fs-18 me-1">print</span> Export Report
            </button>
        </div>
    </div>

    <!-- Stats Summary -->
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card border-0 rounded-10 shadow-sm p-4 h-100">
                <h5 class="mb-4">Project Profitability (Top 5)</h5>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr class="text-muted fs-13">
                                <th>Project</th>
                                <th class="text-end">Revenue</th>
                                <th class="text-end">Profit</th>
                                <th class="text-end">Margin</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($projectProfitability as $proj)
                                <tr>
                                    <td class="fw-semibold">{{ $proj['name'] }}</td>
                                    <td class="text-end">${{ number_format($proj['revenue'], 2) }}</td>
                                    <td class="text-end text-success fw-bold">${{ number_format($proj['profit'], 2) }}</td>
                                    <td class="text-end">
                                        <span class="badge bg-success-10 text-success">
                                            {{ $proj['revenue'] > 0 ? round(($proj['profit'] / $proj['revenue']) * 100) : 0 }}%
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 rounded-10 shadow-sm p-4 h-100">
                <h5 class="mb-4">Client Lifetime Value (Top 5)</h5>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr class="text-muted fs-13">
                                <th>Client</th>
                                <th class="text-end">Total Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clientRevenue as $client)
                                <tr>
                                    <td>
                                        <div class="fw-semibold">{{ $client['name'] }}</div>
                                    </td>
                                    <td class="text-end fw-bold text-primary">${{ number_format($client['revenue'], 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Trend -->
    <div class="card border-0 rounded-10 shadow-sm p-4">
        <h5 class="mb-4">Monthly Revenue Trend ({{ date('Y') }})</h5>
        <div style="height: 300px;" class="d-flex align-items-end justify-content-between px-4">
            @php
                $maxRevenue = $monthlyRevenue->max('total') ?: 1000;
                $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            @endphp
            @foreach($months as $index => $name)
                @php
                    $m = $index + 1;
                    $revenue = $monthlyRevenue->firstWhere('month', $m)?->total ?: 0;
                    $height = ($revenue / $maxRevenue) * 100;
                @endphp
                <div class="text-center" style="width: 7%;">
                    <div class="bg-primary-10 position-relative rounded-top" style="height: 200px; width: 100%;">
                        <div class="bg-primary position-absolute bottom-0 start-0 w-100 rounded-top"
                            style="height: {{ $height }}%; transition: height 0.5s ease;">
                            <span
                                class="position-absolute top-0 start-50 translate-middle-x mt-n4 fs-10 fw-bold @if($height < 10) text-dark @else text-white @endif">
                                @if($revenue > 0) ${{ number_format($revenue / 1000, 1) }}k @endif
                            </span>
                        </div>
                    </div>
                    <div class="mt-2 fs-12 text-muted fw-semibold">{{ $name }}</div>
                </div>
            @endforeach
        </div>
    </div>
</div>