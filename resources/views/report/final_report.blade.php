@extends('layouts.app')
@section('content')
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="offset-md-3 col-md-6">
                    <h2 class="admin-heading text-center">Laporan Peminjaman {{$satuan}}
                        @if ($range)
                            <br>{{$range}}
                        @endif
                    </h2>
                </div>
            </div>
            @if ($report_stat)
            {{-- Baris Statistik --}}
            <div class="row">
                <div class="col-md-3 p-2">
                    <div class="bg-white w-100 h-100 col-md-12 shadow rounded p-3 align-content-center">
                        <div class="row my-3">
                            <div class="col-6 text-left align-content-center">
                                <p class="m-0 font-weight-bold text-black-50 text-right">Total Peminjaman</p>
                            </div>
                            <div class="col-6 text-left align-content-center">
                                <h4 id="total-pinjaman" class="m-0 font-weight-bold text-dark"></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 p-2">
                    <div class="bg-white w-100 h-100 col-md-12 shadow rounded p-3 align-content-center">
                        <div class="row my-3">
                            <div class="col-6 text-left align-content-center">
                                <p class="m-0 font-weight-bold text-black-50 text-right">Peminjaman Terbanyak per-{{$satuan_kecil}}</p>
                            </div>
                            <div class="col-6 text-left align-content-center">
                                <h4 id="pinjam-terbanyak" class="m-0 font-weight-bold text-dark"></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 p-2">
                    <div class="bg-white w-100 h-100 col-md-12 shadow rounded p-3 align-content-center">
                        <div class="row my-3">
                            <div class="col-6 text-left align-content-center">
                                <p class="m-0 font-weight-bold text-black-50 text-right">Rata - Rata Peminjaman per-{{$satuan_kecil}}</p>
                            </div>
                            <div class="col-6 text-left align-content-center">
                                <h4 id="average-pinjam" class="m-0 font-weight-bold text-dark"></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 p-2">
                    <div class="bg-white w-100 h-100 col-md-12 shadow rounded p-3 align-content-center">
                        <div class="row my-3">
                            <div class="col-6 text-left align-content-center">
                                <p class="m-0 font-weight-bold text-black-50 text-right">Total Pendapatan Denda</p>
                            </div>
                            <div class="col-6 text-left align-content-center">
                                <h4 id="total-denda" class="m-0 font-weight-bold text-dark"></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Baris Kedua --}}
            <div class="row">
                <div class="col-md-8 p-2">
                    <div class="bg-white w-100 h-100 col-md-12 shadow rounded p-3 align-content-center">
                        <h5 id="title-chart-1" class="font-weight-bold text-center">Perbandingan Total Peminjaman</h5>
                        <canvas id="total_issues">
                        
                        </canvas>
                    </div>
                </div>
                <div class="col-md-4 p-2">
                    <div class="bg-white w-100 h-100 col-md-12 shadow rounded p-3 align-content-start">
                        <h5 id="title-chart-2" class="font-weight-bold text-center mb-4">Buku Terpopuler</h5>
                        <canvas id="populer_book">

                        </canvas>
                    </div>
                </div>
            </div>
            {{-- Baris Grafik Line Peminjaman per-Waktu --}}
            <div class="row">
                <div class="col-md-12 p-2">
                    <div class="bg-white w-100 h-100 col-md-12 shadow rounded p-3 align-content-center">
                        <h5 id="title-chart-3" class="font-weight-bold text-center">Jumlah Peminjaman per-{{$satuan_kecil}}</h5>
                        <canvas id="daily_issues">

                        </canvas>
                    </div>
                </div>
            </div>
            {{-- Baris Grafik Waktu / Jam paling Sibuk --}}
            <div class="row">
                <div class="col-md-12 p-2">
                    <div class="bg-white w-100 h-100 col-md-12 shadow rounded p-3 align-content-center">
                        <h5 id="title-chart-3" class="font-weight-bold text-center">Jam Paling Sibuk</h5>
                        <canvas id="daily_time">

                        </canvas>
                    </div>
                </div>
            </div>
            {{-- Baris Keempat --}}
            <div class="row">
                <div class="col-md-6 p-2">
                    <div class="bg-white w-100 h-100 col-md-12 shadow rounded p-3 align-content-center">
                        <h5 id="title-chart-4" class="font-weight-bold text-center">Top {{$top_pinjam}} Peminjam Paling Sering Pinjam<br>(Laki - Laki)</h5>
                        <canvas id="male_most">

                        </canvas>
                    </div>
                </div>
                <div class="col-md-6 p-2">
                    <div class="bg-white w-100 h-100 col-md-12 shadow rounded p-3 align-content-center">
                        <h5 id="title-chart-5" class="font-weight-bold text-center">Top {{$top_pinjam}} Peminjam Paling Sering Pinjam<br>(Perempuan)</h5>
                        <canvas id="female_most">

                        </canvas>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    <script type="module">
        // Untuk ambil style warna
        const style = getComputedStyle(document.body);
        const theme = {
            primary: style.getPropertyValue('--primary'),
            secondary: style.getPropertyValue('--secondary'),
            success: style.getPropertyValue('--success'),
            info: style.getPropertyValue('--info'),
            warning: style.getPropertyValue('--warning'),
            danger: style.getPropertyValue('--danger'),
            light: style.getPropertyValue('--light'),
            dark: style.getPropertyValue('--dark'),
        };
        var green = Color(theme.success);
        var reds = Color(theme.danger);
        var blue = Color(theme.primary);
        var gray = Color(theme.secondary);

        var statusa = "{!! $report_stat == 'Y' ? "Y" : "N" !!}"
        if (statusa == "Y") {
            var big_json = {!! $report_stat == 'Y' ? $reports_all : "a" !!}

            // Total Berdasarkan Ketepatan / Chart 1
            {
                var cowo_tepat = 0; var cowo_telat = 0; var cewe_tepat = 0; var cewe_telat = 0; var denda_total = 0;
                // Ini looping data hitung total peminjaman tepat/telat dan cowo/cewe
                for (var i in big_json) {
                    for (var index in Object.keys(big_json[i])) {
                        if(Object.keys(big_json[i])[index] == "fines") {
                            if (Object.values(big_json[i])[index] > 0) {
                                denda_total = denda_total + Object.values(big_json[i])[index];

                                for (var indexo in Object.keys(big_json[i])) {
                                    if (Object.keys(big_json[i])[indexo] == "gender") {
                                        if (Object.values(big_json[i])[indexo] == "L") {
                                            cowo_telat++
                                        } else {
                                            cewe_telat++
                                        }
                                    }
                                }
                            } else {
                                for (var indexo in Object.keys(big_json[i])) {
                                    if (Object.keys(big_json[i])[indexo] == "gender") {
                                        if (Object.values(big_json[i])[indexo] == "L") {
                                            cowo_tepat++
                                        } else {
                                            cewe_tepat++
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                var total_tepat = cowo_tepat+cewe_tepat; var total_telat = cowo_telat+cewe_telat;
                const chart_1 = document.getElementById('total_issues');
                var MyChart1 = new Chart(chart_1, {
                    plugins: [ChartDataLabels],
                    type: 'pie',
                    data: {
                        datasets: [{
                            label: 'Jumlah Pinjaman',
                            data: [
                                cowo_tepat,
                                cewe_tepat,
                                cowo_telat,
                                cewe_telat
                            ],
                            hoverOffset: 4,
                            backgroundColor: [
                                green.clone().darken(0.2).hslString(),
                                green.clone().darken(0.4).hslString(),
                                reds.clone().darken(0.2).hslString(),
                                reds.clone().darken(0.4).hslString(),
                            ],
                            borderColor: [
                                green.clone().hslString(),
                                green.clone().hslString(),
                                reds.clone().hslString(),
                                reds.clone().hslString(),
                            ],
                            borderWidth: 4,
                            labels: ['Laki - Laki Tepat','Perempuan Tepat','Laki - Laki Terlambat','Perempuan Terlambat'],
                        },{
                            label: 'Jumlah Pinjaman Total',
                            data: [
                                total_tepat,
                                total_telat
                            ],
                            hoverOffset: 4,
                            backgroundColor: [
                                green.clone().hslString(),
                                reds.clone().hslString(),
                            ],
                            borderColor: [
                                green.clone().hslString(),
                                reds.clone().hslString(),
                            ],
                            borderWidth: 4,
                            labels: ['Total Tepat','Total Terlambat'],
                        }]
                    },
                    options: {
                        aspectRatio: 2,
                        layout: {
                            padding: 32
                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                        label: function(context) {
                                        var index = context.dataIndex;
                                        return context.dataset.labels[index] + ': ' + context.dataset.data[index];
                                    }
                                },
                                bodyFont: {
                                    size: 16
                                },
                            },
                            datalabels: {
                                display: true,
                                color: 'white',
                                padding: 6,
                                labels: {
                                    percentage: {
                                        font: {
                                            size: 12,
                                            weight: 900
                                        },
                                        anchor: 'center',
                                        align: 'bottom',
                                        offset: -8,
                                        backgroundColor: 'white',
                                        color: function(ctx) {
                                            return ctx.dataset.backgroundColor;
                                        },
                                        borderRadius: 4,
                                        formatter: (value, ctx) => {
                                            let sum = 0;
                                            let dataArr = ctx.chart.data.datasets[0].data;
                                            dataArr.map(data => {
                                                sum += data;
                                            });
                                            let percentage = (value*100 / sum).toFixed(2)+"%";
                                            return percentage;
                                        },
                                    },
                                    value: {
                                        font: {
                                            size: 24,
                                            weight: 'bold'
                                        },
                                        anchor: 'center',
                                        align: 'top',
                                        offset: 0,
                                        formatter: function(value, ctx) {
                                            return value;
                                        },
                                    },
                                    label: {
                                        font: {
                                            size: 16,
                                            weight: 'bold'
                                        },
                                        anchor: 'end',
                                        align: 'end',
                                        offset: 12,
                                        clamp: true,
                                        color: function(ctx) {
                                            return ctx.dataset.backgroundColor;
                                        },
                                        formatter: function(value, ctx) {
                                            // return value;
                                            var index = ctx.dataIndex;
                                            if (ctx.dataset.label == "Jumlah Pinjaman") {
                                                return ctx.dataset.labels[index];
                                            } else {
                                                return '';
                                            }
                                            // return console.log(ctx.dataset.label);
                                        },
                                    }
                                }
                            },
                        }
                    }
                });
            }

            // Untuk Jumlah Pinjaman per-Hari
            {
                var issue_counts = {!! $report_stat == 'Y' ? $issue_counts : "a" !!}
                var punct_counts = {!! $report_stat == 'Y' ? $punctual_counts : "a" !!}
                var late_counts = {!! $report_stat == 'Y' ? $late_counts : "a" !!}
                var issue_groups = {!! $report_stat == 'Y' ? $issue_groups : "a" !!}
                var jumlah = []
                var jumlah_tepat = []
                var jumlah_telat = []
                var tanggal = []
                for (var i in issue_counts) {
                    jumlah.push(Object.values(issue_counts[i])[0])
                }
                for (var i in punct_counts) {
                    jumlah_tepat.push(Object.values(punct_counts[i])[0])
                }
                for (var i in late_counts) {
                    jumlah_telat.push(Object.values(late_counts[i])[0])
                }
                for (var i in issue_groups) {
                    tanggal.push(Object.values(issue_groups[i])[0])
                }
                const chart_2 = document.getElementById('daily_issues');
                var MyChart2 = new Chart(chart_2, {
                    type: 'line',
                    data: {
                        labels: tanggal,
                        datasets: [{
                            label: 'Jumlah Peminjaman Total',
                            data: jumlah,
                            borderWidth: 3,
                            borderColor: theme.primary
                        },{
                            label: 'Jumlah Pengembalian Tepat Waktu',
                            data: jumlah_tepat,
                            borderWidth: 3,
                            borderColor: theme.success
                        },{
                            label: 'Jumlah Pengembalian Terlambat',
                            data: jumlah_telat,
                            borderWidth: 3,
                            borderColor: theme.danger
                        }]
                    },
                    options: {
                        elements: {
                            point: {
                                radius: 4,
                                backgroundColor: theme.light,
                                borderWidth: 1,
                                borderColor: function(ctx) {
                                    return ctx.dataset.borderColor;
                                },
                                hoverRadius: 16,
                                hitRadius: 8
                            }
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'bottom'
                            },
                            tooltip: {
                                titleFont: {
                                    size: 12
                                },
                                bodyFont: {
                                    size: 16
                                },
                            }
                        },
                        aspectRatio: 3,
                        layout: {
                            padding: 32
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            },
                        }
                    }
                });
            }

            // Untuk Lihat Waktu Paling Sibuk per-Hari
            {
                var waktu_jumlah_pinjam = {!! $report_stat == 'Y' ? $daily_time : "a" !!}
                var jumlah_pinjam = []
                jumlah_pinjam.push([]); jumlah_pinjam.push([]);
                for (var i in waktu_jumlah_pinjam) {
                    jumlah_pinjam[0].push(waktu_jumlah_pinjam[i].jam.toLocaleString()+":00")
                    jumlah_pinjam[1].push(waktu_jumlah_pinjam[i].jumlah)
                }
                const chart_6 = document.getElementById('daily_time');
                var MyChart6 = new Chart(chart_6, {
                    type: 'line',
                    data: {
                        labels: jumlah_pinjam[0],
                        datasets: [{
                            label: 'Jumlah Peminjaman',
                            data: jumlah_pinjam[1],
                            borderWidth: 3,
                            borderColor: theme.dark,
                            lineTension: 0.5
                        }]
                    },
                    options: {
                        elements: {
                            point: {
                                radius: 4,
                                backgroundColor: theme.light,
                                borderWidth: 1,
                                borderColor: function(ctx) {
                                    return ctx.dataset.borderColor;
                                },
                                hoverRadius: 16,
                                hitRadius: 8
                            }
                        },
                        plugins: {
                            legend: {
                                display: false,
                                position: 'bottom'
                            },
                            tooltip: {
                                titleFont: {
                                    size: 12
                                },
                                bodyFont: {
                                    size: 16
                                },
                            }
                        },
                        aspectRatio: 3,
                        layout: {
                            padding: 32
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            },
                        }
                    }
                });
            }

            // Untuk Buku Terpopuler
            {
                var popular_book = {!! $report_stat == 'Y' ? $book_counts : "a" !!}
                var buku_populer = []
                var jumlah_populer = []
                for (var i in popular_book) {
                    buku_populer.push(Object.values(popular_book[i])[0])
                    jumlah_populer.push(Object.values(popular_book[i])[1])
                }
                const chart_3 = document.getElementById('populer_book');
                var MyChart3 = new Chart(chart_3, {
                    plugins: [ChartDataLabels],
                    type: 'bar',
                    data: {
                        labels: buku_populer.slice(0,7),
                        datasets: [{
                            label: 'Jumlah Peminjaman',
                            data: jumlah_populer.slice(0,7),
                            labels: buku_populer.slice(0,7),
                            borderWidth: 4,
                            borderColor: theme.secondary,
                            backgroundColor: theme.dark
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        elements: {
                            bar: {
                                borderWidth: 2
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                xAlign: 'center',
                                bodyAlign: 'right',
                                position: 'average',
                                callbacks: {
                                    title: () => null,
                                    label: function(context) {
                                        var index = context.dataIndex;
                                        return context.dataset.labels[index];
                                    }
                                },
                                bodyFont: {
                                    size: 14,
                                    weight: 'bold'
                                },
                                titleFont: {
                                    display: false
                                }
                            },
                            datalabels: {
                                labels: {
                                    label: {
                                            font: {
                                            weight: 800,
                                            size: 12
                                        },
                                        align: 'end',
                                        anchor: 'start',
                                        clamp: true,
                                        color: theme.light,
                                        formatter: function(value, context) {
                                            var index = context.dataIndex;
                                            if (context.dataset.data[index] <= 1) {
                                                return context.chart.data.labels[context.dataIndex].substr(0,12)+"...";
                                            } else if (context.dataset.data[index] > 1 && context.dataset.data[index] <=3) {
                                                return context.chart.data.labels[context.dataIndex].substr(0,18)+"...";
                                            } else {
                                                return context.chart.data.labels[context.dataIndex].substr(0,24)+"...";
                                            }
                                        },
                                    },
                                    value: {
                                        font: {
                                            size: 12,
                                            weight: 800
                                        },
                                        clamp: true,
                                        anchor: 'end',
                                        align: 'start',
                                        offset: 4,
                                        color: theme.light,
                                        formatter: function(value, ctx) {
                                            return value;
                                        },
                                    }
                                }
                            }
                        },
                        aspectRatio: 1,
                        layout: {
                            padding: 4
                        },
                        scales: {
                            x: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0,
                                    font: {
                                        weight: 'bold',
                                        size: 12
                                    }
                                }
                            },
                            y: {
                                ticks: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }

            // Untuk Peminjam Sering Pinjam (Laki)
            {
                var male_name = {!! $report_stat == 'Y' ? $male_most : "a" !!}
                var male_peminjam = []
                var male_jumlah_pinjam = []
                for (var i in male_name) {
                    male_peminjam.push(Object.values(male_name[i])[0])
                    male_jumlah_pinjam.push(Object.values(male_name[i])[1])
                }
                const chart_4 = document.getElementById('male_most');
                var MyChart4 = new Chart(chart_4, {
                    plugins: [ChartDataLabels],
                    type: 'bar',
                    data: {
                        labels: male_peminjam,
                        datasets: [{
                            label: 'Jumlah Peminjaman',
                            data: male_jumlah_pinjam,
                            labels: male_peminjam,
                            borderWidth: 2,
                            borderColor: theme.primary,
                            backgroundColor: Color(theme.primary).clone().darken(0.5).hslString()
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        elements: {
                            bar: {
                                borderWidth: 2
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                xAlign: 'center',
                                bodyAlign: 'right',
                                position: 'average',
                                callbacks: {
                                    title: () => null,
                                    label: function(context) {
                                        var index = context.dataIndex;
                                        return context.dataset.labels[index];
                                    }
                                },
                                bodyFont: {
                                    size: 14,
                                    weight: 'bold'
                                },
                                titleFont: {
                                    display: false
                                }
                            },
                            datalabels: {
                                labels: {
                                    label: {
                                            font: {
                                            weight: 800,
                                            size: 12
                                        },
                                        align: 'end',
                                        anchor: 'start',
                                        clamp: true,
                                        color: theme.light,
                                        formatter: function(value, context) {
                                            return context.chart.data.labels[context.dataIndex];
                                        },
                                    },
                                    value: {
                                        font: {
                                            size: 12,
                                            weight: 800
                                        },
                                        anchor: 'end',
                                        align: 'start',
                                        offset: 4,
                                        color: theme.light,
                                        formatter: function(value, ctx) {
                                            return value;
                                        },
                                    }
                                }
                            }
                        },
                        aspectRatio: 1.5,
                        layout: {
                            padding: 4
                        },
                        scales: {
                            x: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0,
                                    font: {
                                        weight: 'bold',
                                        size: 12
                                    }
                                }
                            },
                            y: {
                                ticks: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }

            // Untuk Peminjam Sering Pinjam (Perempuan)
            {
                var female_name = {!! $report_stat == 'Y' ? $female_most : "a" !!}
                var female_peminjam = []
                var female_jumlah_pinjam = []
                for (var i in female_name) {
                    female_peminjam.push(Object.values(female_name[i])[0])
                    female_jumlah_pinjam.push(Object.values(female_name[i])[1])
                }
                const chart_5 = document.getElementById('female_most');
                var MyChart5 = new Chart(chart_5, {
                    plugins: [ChartDataLabels],
                    type: 'bar',
                    data: {
                        labels: female_peminjam,
                        datasets: [{
                            label: 'Jumlah Peminjaman',
                            data: female_jumlah_pinjam,
                            labels: female_peminjam,
                            borderWidth: 2,
                            borderColor: theme.danger,
                            backgroundColor: Color(theme.danger).clone().lighten(0.5).hslString()
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        elements: {
                            bar: {
                                borderWidth: 2
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                xAlign: 'center',
                                bodyAlign: 'right',
                                position: 'average',
                                callbacks: {
                                    title: () => null,
                                    label: function(context) {
                                        var index = context.dataIndex;
                                        return context.dataset.labels[index];
                                    }
                                },
                                bodyFont: {
                                    size: 14,
                                    weight: 'bold'
                                },
                                titleFont: {
                                    display: false
                                }
                            },
                            datalabels: {
                                labels: {
                                    label: {
                                            font: {
                                            weight: 800,
                                            size: 12
                                        },
                                        align: 'end',
                                        anchor: 'start',
                                        clamp: true,
                                        color: theme.dark,
                                        formatter: function(value, context) {
                                            return context.chart.data.labels[context.dataIndex];
                                        },
                                    },
                                    value: {
                                        font: {
                                            size: 12,
                                            weight: 800
                                        },
                                        anchor: 'end',
                                        align: 'start',
                                        offset: 4,
                                        color: theme.dark,
                                        formatter: function(value, ctx) {
                                            return value;
                                        },
                                    }
                                }
                            }
                        },
                        aspectRatio: 1.5,
                        layout: {
                            padding: 4
                        },
                        scales: {
                            x: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0,
                                    font: {
                                        weight: 'bold',
                                        size: 12
                                    }
                                }
                            },
                            y: {
                                ticks: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }

            // Untuk Statistik
            {
                $("h4#total-pinjaman").html(total_tepat+total_telat);
                $("h4#pinjam-terbanyak").html(Math.max.apply(Math,jumlah));
                $("h4#average-pinjam").html((Math.round((total_telat+total_tepat)/(jumlah.length) * 100) / 100).toFixed(2));
                $("h4#total-denda").html("Rp "+(denda_total.toLocaleString()));
            }
        }
    </script>
@endsection
