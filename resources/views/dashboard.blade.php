@extends('layouts.app')

@section('title', 'Dashboard')

@section('contents')
<div class="container-fluid">
    <div class="row">
        <!-- Card: Total Products -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Produk
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalProducts }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box-open fa-2x me-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Card: Total Stock Entry -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Stok Masuk
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalStockEntry }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-arrow-down fa-2x me-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Card: Total Stock Exit -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Stok Keluar
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalStockExit }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-arrow-up fa-2x me-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Card: Total Current Stock -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Stok Tersisa
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $currentStock }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-warehouse fa-2x me-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- ilustrasi -->
        <div class="col-xl-6 col-lg-5">
            <div class="card shadow mb-4">
                <div>
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Illustrations</h6>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 20rem;"
                                src="admin_assets/img/11065.jpg" alt="...">
                        </div>
                        <p>Add some quality, svg illustrations to your project courtesy of <a
                                target="_blank" rel="nofollow" href="https://undraw.co/">unDraw</a>, a
                            constantly updated collection of beautiful svg images that you can use
                            completely free and without attribution!</p>
                        <a target="_blank" rel="nofollow" href="https://undraw.co/">Browse Illustrations on
                            unDraw &rarr;</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pie Chart -->
        <div class="col-xl-6 col-lg-5">
            <div class="card shadow mb-4">
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Stock Masuk & Keluar</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="myPieChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- SweetAlert JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Notifikasi SweetAlert jika ada pesan sukses -->
@if(Session::has('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Sukses',
            text: '{{ Session::get('success') }}',
            showConfirmButton: false,
            timer: 2000
        });
    </script>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var ctx = document.getElementById('myPieChart').getContext('2d');
        var myPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Stok Masuk', 'Stok Keluar'],
                datasets: [{
                    data: [{{ $totalStockEntry }}, {{ $totalStockExit }}],
                    backgroundColor: ['#4e73df', '#e74a3b'],
                    hoverBackgroundColor: ['#2e59d9', '#e74a3b'],
                    hoverBorderColor: "rgba(234, 236, 244, 1)"
                }],
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                },
                legend: {
                    display: false
                },
                cutoutPercentage: 80,
            },
        });
    });
</script>
@endsection
