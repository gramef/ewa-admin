@extends('layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header content-header{{setting('fixed_header')}}">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-bold">{{trans('lang.payment_analytics')}}<small class="mx-3">|</small><small>{{trans('lang.payment_analytics_overview')}}</small></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb bg-white float-sm-right rounded-pill px-4 py-2 d-none d-md-flex">
                        <li class="breadcrumb-item"><a href="#"><i class="fas fa-tachometer-alt"></i> {{trans('lang.dashboard')}}</a></li>
                        <li class="breadcrumb-item active">{{trans('lang.payment_analytics')}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="content">
        <!-- Period Selection -->
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="period-select">{{trans('lang.select_period')}}</label>
                                <select id="period-select" class="form-control">
                                    <option value="7">{{trans('lang.last_7_days')}}</option>
                                    <option value="30" selected>{{trans('lang.last_30_days')}}</option>
                                    <option value="90">{{trans('lang.last_90_days')}}</option>
                                    <option value="365">{{trans('lang.last_year')}}</option>
                                </select>
                            </div>
                            <div class="col-md-6 d-flex align-items-end">
                                <button id="refresh-analytics" class="btn btn-primary">
                                    <i class="fas fa-sync-alt"></i> {{trans('lang.refresh')}}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Overview Cards -->
        <div class="row" id="overview-cards">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3 id="total-revenue">₦0</h3>
                        <p>{{trans('lang.total_revenue')}}</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3 id="total-transactions">0</h3>
                        <p>{{trans('lang.total_transactions')}}</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3 id="success-rate">0%</h3>
                        <p>{{trans('lang.success_rate')}}</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3 id="avg-transaction">₦0</h3>
                        <p>{{trans('lang.avg_transaction')}}</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calculator"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row">
            <!-- Daily Revenue Chart -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{trans('lang.daily_revenue_chart')}}</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="revenue-chart" height="100"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- Payment Status Distribution -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{trans('lang.payment_status_distribution')}}</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="status-chart" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Methods & Top Services -->
        <div class="row">
            <!-- Payment Methods -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{trans('lang.payment_methods_breakdown')}}</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="methods-chart" height="150"></canvas>
                    </div>
                </div>
            </div>

            <!-- Top Services -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{trans('lang.top_services_by_revenue')}}</h3>
                    </div>
                    <div class="card-body">
                        <div id="top-services-list">
                            <!-- Dynamic content -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{trans('lang.recent_transactions')}}</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="recent-transactions-table" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>{{trans('lang.transaction_id')}}</th>
                                        <th>{{trans('lang.customer')}}</th>
                                        <th>{{trans('lang.service')}}</th>
                                        <th>{{trans('lang.amount')}}</th>
                                        <th>{{trans('lang.payment_method')}}</th>
                                        <th>{{trans('lang.status')}}</th>
                                        <th>{{trans('lang.date')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Dynamic content -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let revenueChart, statusChart, methodsChart;
    
    $(document).ready(function() {
        loadAnalytics();
        
        $('#refresh-analytics, #period-select').on('change click', function() {
            loadAnalytics();
        });
    });
    
    function loadAnalytics() {
        const period = $('#period-select').val();
        
        // Show loading state
        showLoading();
        
        // Load overview data
        $.get('/api/analytics/payments/overview', { period: period })
            .done(function(response) {
                if (response.success) {
                    updateOverviewCards(response.data.overview);
                    updatePaymentMethods(response.data.payment_methods);
                }
            });
        
        // Load daily revenue chart
        $.get('/api/analytics/payments/daily-revenue', { days: period })
            .done(function(response) {
                if (response.success) {
                    updateRevenueChart(response.data);
                }
            });
        
        // Load status distribution
        $.get('/api/analytics/payments/status-distribution', { period: period })
            .done(function(response) {
                if (response.success) {
                    updateStatusChart(response.data);
                }
            });
        
        // Load top services
        $.get('/api/analytics/payments/top-services', { period: period })
            .done(function(response) {
                if (response.success) {
                    updateTopServices(response.data);
                }
            });
        
        // Load recent transactions
        $.get('/api/analytics/payments/recent-transactions')
            .done(function(response) {
                if (response.success) {
                    updateRecentTransactions(response.data);
                }
            });
    }
    
    function showLoading() {
        $('#total-revenue').text('...');
        $('#total-transactions').text('...');
        $('#success-rate').text('...');
        $('#avg-transaction').text('...');
    }
    
    function updateOverviewCards(data) {
        $('#total-revenue').text('₦' + numberFormat(data.total_revenue));
        $('#total-transactions').text(numberFormat(data.total_transactions));
        $('#success-rate').text(data.success_rate + '%');
        $('#avg-transaction').text('₦' + numberFormat(data.average_transaction));
    }
    
    function updateRevenueChart(data) {
        const ctx = document.getElementById('revenue-chart').getContext('2d');
        
        if (revenueChart) {
            revenueChart.destroy();
        }
        
        revenueChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.map(item => new Date(item.date).toLocaleDateString()),
                datasets: [{
                    label: 'Revenue (₦)',
                    data: data.map(item => item.revenue),
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '₦' + numberFormat(value);
                            }
                        }
                    }
                }
            }
        });
    }
    
    function updateStatusChart(data) {
        const ctx = document.getElementById('status-chart').getContext('2d');
        
        if (statusChart) {
            statusChart.destroy();
        }
        
        statusChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: data.map(item => item.payment_status ? item.payment_status.status : 'Unknown'),
                datasets: [{
                    data: data.map(item => item.count),
                    backgroundColor: [
                        '#28a745',
                        '#dc3545',
                        '#ffc107',
                        '#17a2b8'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }
    
    function updatePaymentMethods(data) {
        const ctx = document.getElementById('methods-chart').getContext('2d');
        
        if (methodsChart) {
            methodsChart.destroy();
        }
        
        methodsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.map(item => item.payment_method ? item.payment_method.name : 'Unknown'),
                datasets: [{
                    label: 'Revenue (₦)',
                    data: data.map(item => item.total),
                    backgroundColor: 'rgba(54, 162, 235, 0.8)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '₦' + numberFormat(value);
                            }
                        }
                    }
                }
            }
        });
    }
    
    function updateTopServices(data) {
        let html = '<div class="list-group">';
        data.forEach((service, index) => {
            html += `
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1">${service.booking && service.booking.e_service ? service.booking.e_service.name : 'Unknown Service'}</h6>
                        <small>${service.transaction_count} transactions</small>
                    </div>
                    <span class="badge badge-primary badge-pill">₦${numberFormat(service.total_revenue)}</span>
                </div>
            `;
        });
        html += '</div>';
        $('#top-services-list').html(html);
    }
    
    function updateRecentTransactions(data) {
        let html = '';
        data.forEach(transaction => {
            const statusClass = getStatusClass(transaction.payment_status);
            html += `
                <tr>
                    <td>#${transaction.id}</td>
                    <td>${transaction.booking && transaction.booking.user ? transaction.booking.user.name : 'N/A'}</td>
                    <td>${transaction.booking && transaction.booking.e_service ? transaction.booking.e_service.name : 'N/A'}</td>
                    <td>₦${numberFormat(transaction.price)}</td>
                    <td>${transaction.payment_method ? transaction.payment_method.name : 'N/A'}</td>
                    <td><span class="badge ${statusClass}">${transaction.payment_status ? transaction.payment_status.status : 'Unknown'}</span></td>
                    <td>${new Date(transaction.created_at).toLocaleDateString()}</td>
                </tr>
            `;
        });
        $('#recent-transactions-table tbody').html(html);
    }
    
    function getStatusClass(status) {
        if (!status) return 'badge-secondary';
        switch (status.id) {
            case 2: return 'badge-success'; // Paid
            case 3: return 'badge-danger';  // Failed
            case 1: return 'badge-warning'; // Pending
            default: return 'badge-secondary';
        }
    }
    
    function numberFormat(num) {
        return new Intl.NumberFormat().format(num);
    }
</script>
@endpush
