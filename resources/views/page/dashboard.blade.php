@extends('layouts.page')

@section('title')
Dashboard
@endsection

@section('content')

<div class="content-header ml-2 mr-2">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Dashboard</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content ml-2 mr-2">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{$buku_dipinjam}}</h3>
                        <p>Buku Dipinjam Hari Ini</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-book-reader"></i>
                    </div>
                    <a href="/peminjaman/pinjam" class="small-box-footer">Info lebih lanjut <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{$jumlah_buku}}</h3>
                        <p>Total Buku</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-book"></i>
                    </div>
                    <a href="/buku/umum" class="small-box-footer">Info lebih lanjut <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{$jumlah_ebook}}</h3>
                        <p>Total Ebook</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-atlas"></i>
                    </div>
                    <a href="/buku/ebook" class="small-box-footer">Info lebih lanjut <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{$jumlah_user}}</h3>
                        <p>User Terdaftar</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <a href="/user/mahasiswa" class="small-box-footer">Info lebih lanjut <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-8">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Total Peminjaman Buku Tahun {{date('Y')}}</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="lineChart"
                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Status Pengembalian Buku Tahun {{date('Y')}}</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="pieChart"
                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function () {

            //--------------
            //- LINE CHART -
            //--------------
            var areaChartData = {
                labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                datasets: [{
                        label: 'Jumlah Peminjaman',
                        backgroundColor: 'rgba(60,141,188,0.9)',
                        borderColor: 'rgba(60,141,188,0.8)',
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        lineTension: 0,
                        data: {{json_encode($total_pinjam_bulan)}},
                    },
                ]
            }

            var areaChartOptions = {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: false
                },
                tooltips: {
					mode: 'index',
					intersect: false,
				},
				hover: {
					mode: 'nearest',
					intersect: true
				},
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: true,
                        },
                        scaleLabel: {
							display: true,
							labelString: 'Bulan'
						}
                    }],
                    yAxes: [{
                        gridLines: {
                            display: true,
                        },
                        scaleLabel: {
							display: true,
							labelString: 'Jumlah Peminjaman'
						}
                    }]
                },
                plugins: {
                    datalabels: {
                        display: false
                    }
                }
            }

            var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
            var lineChartOptions = jQuery.extend(true, {}, areaChartOptions)
            var lineChartData = jQuery.extend(true, {}, areaChartData)
            lineChartData.datasets[0].fill = false;
            lineChartOptions.datasetFill = false;

            var lineChart = new Chart(lineChartCanvas, {
            type: 'line',
            data: lineChartData,
            options: lineChartOptions
            })

            //-------------
            //- PIE CHART -
            //-------------
            var pieData = {
                labels: [
                    'Tepat Waktu',
                    'Telat',
                ],
                datasets: [{
                    data: {{json_encode($status_pengembalian)}},
                    backgroundColor: ['#00a65a', '#f56954'],
                }]
            }
            var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
            var pieOptions = {
                maintainAspectRatio: false,
                responsive: true,
                plugins: {
                    datalabels: {
                        formatter: (value, ctx) => {
                            let sum = 0;
                            let dataArr = ctx.chart.data.datasets[0].data;
                            dataArr.map(data => {
                                sum += data;
                            });
                            let percentage = (value*100 / sum).toFixed(2)+"%";
                            return percentage;
                        },
                        color: '#fff',
                    }
                }
            }
            var pieChart = new Chart(pieChartCanvas, {
                type: 'pie',
                data: pieData,
                options: pieOptions
            });
        });
    </script>
@endpush
