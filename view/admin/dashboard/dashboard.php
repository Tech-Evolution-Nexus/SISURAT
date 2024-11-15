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
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
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
            /* Ensure it's non-interactive */
        }

        @media (max-width:760px) {
            .svg-container {
                height: 80%;
                z-index: -1;
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
                <p class="text-white text-small"><?= $data->description ?></p>
            </div>
            <div class="row mt-3 g-4">
                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                    <div class="card glass-card border-0 text-dark position-relative bg-white">
                        <div class="card-body pb-5 d-flex gap-2 align-items-center">
                            <span class="card-icon bg-success border border-white">
                                <i class="fa fa-envelope text-white "></i>
                            </span>
                            <div>
                                <h2 class="mb-0 fw-bold"><?= $data->jenis_surat ?></h2>
                                <h6>Jenis Surat</h6>
                            </div>
                        </div>
                        <div class="svg-container">
                            <svg style="height: 100%;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                                <path fill="#00bc8b" fill-opacity="1" d="M0,160L80,138.7C160,117,320,75,480,80C640,85,800,139,960,165.3C1120,192,1280,192,1360,192L1440,192L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                    <div class="card glass-card border-0 text-dark position-relative bg-white">
                        <div class="card-body pb-5 d-flex gap-2 align-items-center">
                            <span class="card-icon bg-warning border border-white">
                                <i class="fa fa-envelope text-white "></i>
                            </span>
                            <div>
                                <h2 class="mb-0 fw-bold"><?= $data->masyarakat ?></h2>
                                <h6>Masyarakat</h6>
                            </div>
                        </div>
                        <div class="svg-container">
                            <svg style="height: 100%;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                                <path fill="#fab41d" fill-opacity="1" d="M0,160L80,138.7C160,117,320,75,480,80C640,85,800,139,960,165.3C1120,192,1280,192,1360,192L1440,192L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                    <div class="card glass-card border-0 text-dark position-relative bg-white">
                        <div class="card-body pb-5 d-flex gap-2 align-items-center">
                            <span class="card-icon bg-primary border border-white">
                                <i class="fa fa-envelope text-white "></i>
                            </span>
                            <div>
                                <h2 class="mb-0 fw-bold"><?= $data->pengajuan ?></h2>
                                <h6>Surat Masuk Hari Ini</h6>
                            </div>
                        </div>
                        <div class="svg-container">
                            <svg style="height: 100%;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                                <path fill="#052158" fill-opacity="1" d="M0,160L80,138.7C160,117,320,75,480,80C640,85,800,139,960,165.3C1120,192,1280,192,1360,192L1440,192L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php includeFile("layout/script") ?>
</body>

</html>