@extends('layouts.template') 

@push('css')
<link rel="stylesheet" href="{{ asset('adminlte/plugins/chart.js/Chart.min.css') }}">
@endpush

@section('content') 
<div class="card"> 
    <div class="card-header bg-primary text-white"> 
        <h3 class="card-title">📊 Dashboard Penjualan</h3> 
    </div> 
    <div class="card-body"> 
        <div class="row">
            <!-- Total Penjualan -->
            <div class="col-md-6">
                <div class="small-box bg-success shadow">
                    <div class="inner">
                        <h3 id="total-penjualan">Loading...</h3>
                        <p>Total Penjualan</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-cash-register"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="small-box bg-info shadow">
                    <div class="inner">
                        <h3 id="total-laba">Loading...</h3>
                        <p>Total Laba/Keuntungan</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-cash-register"></i>
                    </div>
                </div>
            </div>

            <!-- Barang Terlaris -->
            <div class="col-md-6">
                <div class="card border-left-primary shadow">
                    <div class="card-header bg-light">
                        <h3 class="card-title">📦 Barang Terlaris</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="topProductsChart" height="200"></canvas>
                    </div>
                </div>
            </div>

            <!-- Jam Ramai -->
            <div class="col-md-6">
                <div class="card border-left-warning shadow">
                    <div class="card-header bg-light">
                        <h3 class="card-title">⏰ Waktu Ramai</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="peakHoursChart" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div> 

@push('js')
<script src="{{ asset('adminlte/plugins/chart.js/Chart.min.js') }}"></script>
<script>
$(document).ready(function () {
    // Total Penjualan Hari Ini
    $.get('/dashboard/penjualan-per-hari-ini', function (res) {
        $('#total-penjualan').text('Rp ' + res.total);
    });
    
    $.get('/dashboard/laba-per-hari-ini', function (res) {
        $('#total-laba').text('Rp ' + res.total);
    });

    // Barang Terlaris
    $.get('/dashboard/top-products', function (res) {
        new Chart(document.getElementById('topProductsChart'), {
            type: 'bar',
            data: {
                labels: res.labels,
                datasets: [{
                    label: 'Jumlah Terjual',
                    data: res.data,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)'
                }]
            }
        });
    });

    // Jam Ramai
    $.get('/dashboard/peak-hours', function (res) {
        new Chart(document.getElementById('peakHoursChart'), {
            type: 'line',
            data: {
                labels: res.labels,
                datasets: [{
                    label: 'Jumlah Transaksi',
                    data: res.data,
                    backgroundColor: 'rgba(255, 206, 86, 0.4)',
                    borderColor: 'rgba(255, 206, 86, 1)',
                    fill: true
                }]
            }
        });
    });
});
</script>
@endpush

@endsection
