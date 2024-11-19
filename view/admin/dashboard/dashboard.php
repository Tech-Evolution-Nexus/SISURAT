<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISURAT | <?= $data->title ?></title>
    <?php includeFile("layout/css") ?>
    <style>
        /* Card styling */
        .card {
            border-radius: 10px;
            overflow: hidden;
            position: relative;
            color: white;
            /* box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); */
        }

        /* Container for the wave SVG positioned at the bottom */
        .svg-container {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 50%;
            overflow: hidden;
            pointer-events: none;
            z-index: -1;

            /* Ensure it's non-interactive */
        }

        @media (max-width:760px) {
            .svg-container {
                display: none;
                height: 80%;
            }
        }

        /* Icon styling within the card */
        .card-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Glassmorphism effect */
        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
        }
    </style>
</head>

<body class="admin d-flex">
    <div class="header-layer bg-primary"></div>
    <?php includeFile("layout/sidebar") ?>

    <main class="flex-grow-1">
        <?php includeFile("layout/navbar") ?>
        <div class="p-4">
            <div>
                <h2 class="mb-0 text-white"><?= $data->title ?></h2>
                <!-- <p class="text-white text-small"><?= $data->description ?></p> -->
            </div>
            <div class="row mt-0 g-4  ">
                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                    <div class="card glass-card border-0 text-white position-relative bg-success">
                        <div class="card-body pb-md-5 d-flex gap-2 align-items-center">
                            <span class="card-icon bg-success border border-white">
                                <i class="fa fa-envelope text-white "></i>
                            </span>
                            <div>
                                <h2 class="mb-0 fw-bold"><?= $data->jenis_surat ?></h2>
                                <h6>Jenis Surat</h6>
                            </div>
                        </div>
                        <div class="svg-container" style="height: 56%;">
                            <svg style="height: 100%;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                                <path fill="#fff" fill-opacity=".2" d="M0,160L80,138.7C160,117,320,75,480,80C640,85,800,139,960,165.3C1120,192,1280,192,1360,192L1440,192L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path>
                            </svg>
                        </div>
                        <div class="svg-container">
                            <svg style="height: 100%;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                                <path fill="#fff" fill-opacity=".4" d="M0,160L80,138.7C160,117,320,75,480,80C640,85,800,139,960,165.3C1120,192,1280,192,1360,192L1440,192L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path>
                            </svg>
                        </div>

                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                    <div class="card glass-card border-0 text-white position-relative bg-warning">
                        <div class="card-body pb-md-5 d-flex gap-2 align-items-center">
                            <span class="card-icon bg-warning border border-white">
                                <i class="fa fa-users text-white "></i>
                            </span>
                            <div>
                                <h2 class="mb-0 fw-bold"><?= $data->users ?></h2>
                                <h6>Pengguna</h6>
                            </div>
                        </div>
                        <div class="svg-container" style="height: 56%;">
                            <svg style="height: 100%;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                                <path fill="#fff" fill-opacity=".2" d="M0,160L80,138.7C160,117,320,75,480,80C640,85,800,139,960,165.3C1120,192,1280,192,1360,192L1440,192L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path>
                            </svg>
                        </div>
                        <div class="svg-container">
                            <svg style="height: 100%;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                                <path fill="#fff" fill-opacity=".4" d="M0,160L80,138.7C160,117,320,75,480,80C640,85,800,139,960,165.3C1120,192,1280,192,1360,192L1440,192L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path>
                            </svg>
                        </div>
                    </div>
                </div>


                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                    <div class="card glass-card border-0 text-white position-relative bg-info">
                        <div class="card-body pb-md-5 d-flex gap-2 align-items-center">
                            <span class="card-icon bg-info border border-white">
                                <i class="fa fa-newspaper text-white "></i>
                            </span>
                            <div>
                                <h2 class="mb-0 fw-bold"><?= $data->berita ?></h2>
                                <h6>Berita</h6>
                            </div>
                        </div>
                        <div class="svg-container" style="height: 56%;">
                            <svg style="height: 100%;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                                <path fill="#fff" fill-opacity=".2" d="M0,160L80,138.7C160,117,320,75,480,80C640,85,800,139,960,165.3C1120,192,1280,192,1360,192L1440,192L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path>
                            </svg>
                        </div>
                        <div class="svg-container">
                            <svg style="height: 100%;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                                <path fill="#fff" fill-opacity=".4" d="M0,160L80,138.7C160,117,320,75,480,80C640,85,800,139,960,165.3C1120,192,1280,192,1360,192L1440,192L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                    <div class="card glass-card border-0 text-white position-relative bg-accent">
                        <div class="card-body pb-md-5 d-flex gap-2 align-items-center">
                            <span class="card-icon bg-accent border border-white">
                                <i class="fa fa-list text-white "></i>
                            </span>
                            <div>
                                <h2 class="mb-0 fw-bold"><?= $data->kartuKeluarga ?></h2>
                                <h6>Kartu Keluarga</h6>
                            </div>
                        </div>
                        <div class="svg-container" style="height: 56%;">
                            <svg style="height: 100%;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                                <path fill="#fff" fill-opacity=".2" d="M0,160L80,138.7C160,117,320,75,480,80C640,85,800,139,960,165.3C1120,192,1280,192,1360,192L1440,192L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path>
                            </svg>
                        </div>
                        <div class="svg-container">
                            <svg style="height: 100%;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                                <path fill="#fff" fill-opacity=".4" d="M0,160L80,138.7C160,117,320,75,480,80C640,85,800,139,960,165.3C1120,192,1280,192,1360,192L1440,192L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row g-4 mt-2 align-items-stretch">
                <div class="col-md-8 col-12">
                    <div class="card text-dark h-100">
                        <div class="card-body ">
                            <h5 class="mb-2">Pengajuan Surat (Bulan <?= $data->bulan ?>)</h5>
                            <canvas height="150" id="chart-pengajuan"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="card text-dark h-100">
                        <div class="card-body ">
                            <h5 class="mb-2">Statistik Pengguna</h5>
                            <canvas height="150" id="chart-users"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-8 col-12">
                    <div class="card text-dark h-100">
                        <div class="card-body ">
                            <h5 class="mb-2">Pengajuan Surat Terbaru</h5>
                            <div class="table-responsive">
                                <table class="table  ">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Lengkap</th>
                                            <th>Jenis Surat</th>
                                            <th>Waktu Pengajuan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($data->pengajuan)): ?>
                                            <?php foreach ($data->pengajuan  as $index => $kk) : ?> <tr>
                                                    <td><?= $index + 1 ?></td>
                                                    <td><?= $kk->nama_lengkap ?></td>
                                                    <td><?= $kk->nama_surat ?></td>
                                                    <td><?= formatDate($kk->created_at) ?></td>

                                                </tr> <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="5" class="text-center">Tidak ada pengajuan surat</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="card text-dark h-100">
                        <div class="card-body ">
                            <h5 class="mb-2">Statistik </h5>
                            <canvas id="chart-users"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php includeFile("layout/script") ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('chart-pengajuan');
        const label = <?= json_encode($data->label) ?>;
        const dataSuratMasuk = <?= json_encode($data->surat_masuk) ?>;
        const dataSuratSelesai = <?= json_encode($data->surat_selesai) ?>;
        const dataPengguna = <?= json_encode($data->pengguna) ?>;

        var chartData = {
            labels: label,
            datasets: [{
                    label: ' Surat Masuk',
                    data: dataSuratMasuk, // Example data for submission counts
                    borderColor: '#00bc8b', // Line color
                    // borderColor: 'rgba(75, 192, 192, 1)', // Line color
                    backgroundColor: 'rgba(75, 192, 192, 0.2)', // Area color under the line
                    fill: true, // Enable the area under the line to be filled
                    tension: 0.4, // Smoothness of the line curve
                    borderWidth: 2, // Border width
                    pointRadius: 5, // Size of points on the line
                    pointBackgroundColor: 'rgba(75, 192, 192, 1)' // Point color
                },
                {
                    label: ' Surat Selesai',
                    data: dataSuratSelesai, // Example data for completed submission counts
                    borderColor: '#ff371e', // Line color for completed
                    // borderColor: 'rgba(255, 99, 132, 1)', // Line color for completed
                    backgroundColor: 'rgba(255, 99, 132, 0.2)', // Area color for completed
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2,
                    pointRadius: 5,
                    pointBackgroundColor: 'rgba(255, 99, 132, 1)'
                }

            ]

        };
        new Chart(ctx, {
            type: 'line',
            data: chartData,

        });
        const ctx2 = document.getElementById('chart-users');

        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ["RW", "RT", "Masyarakat"],
                datasets: [{
                    label: 'Jumlah Pengguna',
                    data: dataPengguna, // Menyesuaikan data jumlah pengguna
                    backgroundColor: ['#00b4d8', '#00bc8b', '#fda521'], // Warna berbeda untuk setiap bagian
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top', // Menempatkan legend di atas grafik
                    },
                    tooltip: {
                        enabled: true, // Memungkinkan tooltip untuk ditampilkan
                        callbacks: {
                            label: function(tooltipItem) {
                                // Menampilkan nilai dan persentase pada tooltip
                                const value = tooltipItem.raw;
                                const total = tooltipItem.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((value / total) * 100).toFixed(2);
                                return `${tooltipItem.label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>