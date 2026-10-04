@extends('admin.layouts.app')
@section('title', 'Dashboard')
@push('css')
@endpush

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4>Dashboard</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="row">
                <div class="col-md-3">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium mb-2">Total Orders</p>
                                    <h4 class="mb-0">{{ number_format($totalOrders) }}</h4>
                                </div>
                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                        <span class="avatar-title rounded-circle bg-primary">
                                            <i class="bx bx-cart-alt font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium mb-2">Total Revenue</p>
                                    <h4 class="mb-0 text-success">৳ {{ number_format($totalRevenue, 2) }}</h4>
                                </div>
                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-sm rounded-circle bg-success">
                                        <span class="avatar-title rounded-circle bg-success">
                                            <i class="bx bx-dollar-circle font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium mb-2">Total Products</p>
                                    <h4 class="mb-0 text-info">{{ number_format($totalProducts) }}</h4>
                                </div>
                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-sm rounded-circle bg-info">
                                        <span class="avatar-title rounded-circle bg-info">
                                            <i class="bx bx-archive-in font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium mb-2">Avg. Order Value</p>
                                    <h4 class="mb-0 text-warning">৳ {{ number_format($averagePrice, 2) }}</h4>
                                </div>
                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-sm rounded-circle bg-warning">
                                        <span class="avatar-title rounded-circle bg-warning">
                                            <i class="bx bx-line-chart font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Daily Sales Track</h5>
                    <div class="d-flex w-25">
                        <select id="chart-month" class="form-select form-select-sm me-2">
                            @for ($m = 1; $m <= 12; $m++)
                                <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}"
                                    {{ date('m') == $m ? 'selected' : '' }}>
                                    {{ date('F', mktime(0, 0, 0, $m, 10)) }}
                                </option>
                            @endfor
                        </select>
                        <select id="chart-year" class="form-select form-select-sm">
                            @for ($y = date('Y') - 5; $y <= date('Y'); $y++)
                                <option value="{{ $y }}" {{ date('Y') == $y ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="card-body" style="position: relative;">
                    <div id="loadingIndicator" class="text-center"
                        style="display: none; position: absolute; z-index: 10; top: 40%; left: 50%; transform: translate(-50%, -50%);">
                        <div class="spinner-border text-primary" role="status"></div>
                    </div>
                    <div id="monthly-sales-chart" class="apex-charts" dir="ltr"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <h5 class="card-title">Recent Orders</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mb-0 text-start align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Order No.</th>
                                    <th>Invoice</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Payment Status</th>
                                    <th>Order Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latestOrders as $key => $itm)
                                    @php
                                        // Handle polymorphic rendering for Admins vs Sellers
                                        $orderData = authAdminType() === 'administrator' ? $itm : $itm->order;
                                        if (!$orderData) {
                                            continue;
                                        } // safety check

                                        $displayAmount =
                                            authAdminType() === 'administrator'
                                                ? $itm->total_order_price
                                                : $itm->seller_amount;
                                        $displayDate = $orderData->created_at->format('M d, Y h:i A');
                                    @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td><span class="fw-bold">{{ $orderData->order_number }}</span></td>
                                        <td>{{ $orderData->invoice }}</td>
                                        <td>{{ $displayDate }}</td>
                                        <td class="fw-semibold">৳ {{ number_format($displayAmount, 2) }}</td>
                                        <td>
                                            @if ($orderData->payment_status === 'paid')
                                                <span class="badge badge-success custom-badge px-2 py-1">Paid</span>
                                            @else
                                                <span class="badge badge-warning custom-badge px-2 py-1">Unpaid</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($orderData->order_status === 'delivered')
                                                <span class="badge badge-success custom-badge px-2 py-1">Delivered</span>
                                            @elseif($orderData->order_status === 'canceled')
                                                <span class="badge badge-danger custom-badge px-2 py-1">Canceled</span>
                                            @else
                                                <span
                                                    class="badge badge-info custom-badge px-2 py-1 text-capitalize">{{ str_replace('_', ' ', $orderData->order_status) }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if (authAdminType() === 'administrator')
                                                <a href="{{ route('admin.order-summary', $orderData->unique_id) }}"
                                                    class="btn btn-sm btn-soft-info" data-bs-toggle="tooltip"
                                                    title="View Order">
                                                    <i class="fa fa-eye"></i> View
                                                </a>
                                            @else
                                                <a href="{{ route('admin.seller-order-invoice', $orderData->unique_id) }}"
                                                    target="_blank" class="btn btn-sm btn-soft-primary"
                                                    data-bs-toggle="tooltip" title="Invoice">
                                                    <i class="fa fa-file-invoice"></i> Invoice
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">
                                            <div class="py-4 text-muted">
                                                <i class="bx bx-inbox font-size-24 mb-2"></i>
                                                <p class="mb-0">No recent orders found.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/admin/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            let chart;

            const initChart = (labels, data) => {
                const options = {
                    chart: {
                        height: 350,
                        type: 'area',
                        toolbar: {
                            show: false
                        },
                        zoom: {
                            enabled: false
                        }
                    },
                    colors: ['#007bff'],
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 2
                    },
                    series: [{
                        name: 'Sales',
                        data: data
                    }],
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.4,
                            opacityTo: 0.05,
                            stops: [0, 90, 100]
                        }
                    },
                    xaxis: {
                        categories: labels,
                    },
                    yaxis: {
                        labels: {
                            formatter: function(val) {
                                if (val >= 1000) {
                                    return "৳ " + (val / 1000).toFixed(1) + "k";
                                }
                                return "৳ " + val;
                            }
                        }
                    },
                    tooltip: {
                        x: {
                            format: 'dd MMM'
                        },
                        y: {
                            formatter: function(val) {
                                return "৳ " + val.toLocaleString('en-IN');
                            }
                        }
                    }
                };

                if (chart) {
                    chart.updateOptions(options);
                } else {
                    chart = new ApexCharts(document.querySelector("#monthly-sales-chart"), options);
                    chart.render();
                }
            };

            const fetchChartData = () => {
                const month = $('#chart-month').val();
                const year = $('#chart-year').val();

                $('#loadingIndicator').show();

                axios.get(`{{ route('admin.chart.monthly-sales') }}?month=${month}&year=${year}`)
                    .then(response => {
                        initChart(response.data.labels, response.data.data);
                    })
                    .catch(error => {
                        console.error("Error fetching chart data", error);
                    })
                    .finally(() => {
                        $('#loadingIndicator').hide();
                    });
            };

            // Initialize on load
            if (typeof ApexCharts !== 'undefined') {
                fetchChartData();
            } else {
                console.warn("ApexCharts library not loaded.");
            }

            // Bind change events
            $('#chart-month, #chart-year').on('change', fetchChartData);
        });
    </script>
@endpush
