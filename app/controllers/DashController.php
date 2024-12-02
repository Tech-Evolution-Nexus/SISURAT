<?php

namespace app\controllers;

use app\models\BeritaModel;
use app\models\JenisSuratModel;
use app\models\KartuKeluargaModel;
use app\models\MasyarakatModel;
use app\models\PengajuanSuratModel;
use PHPMailer\PHPMailer\PHPMailer;
use app\models\UserModel;

use Exception;


class DashController
{
    public $model;
    private $bulanIndonesia = [
        'January' => 'Januari',
        'February' => 'Februari',
        'March' => 'Maret',
        'April' => 'April',
        'May' => 'Mei',
        'June' => 'Juni',
        'July' => 'Juli',
        'August' => 'Agustus',
        'September' => 'September',
        'October' => 'Oktober',
        'November' => 'November',
        'December' => 'Desember'
    ];
    // private $model;
    public function __construct()
    {
        if (!auth()->check()) {
            redirect("/login");
        }
        $this->model = (object)[];
        $this->model->users = new UserModel();
        $this->model->jenisSurat = new JenisSuratModel();
        $this->model->masyarakat = new MasyarakatModel();
        $this->model->users = new UserModel();
        $this->model->pengajuan = new PengajuanSuratModel();
        $this->model->berita = new BeritaModel();
        $this->model->kartuKeluarga = new KartuKeluargaModel();
    }
    public  function index()
    {

        $currentDate = date("Y-m-d");
        $jenisSurat = $this->model->jenisSurat->get();
        $kartuKeluarga = $this->model->kartuKeluarga->get();
        $berita = $this->model->berita->get();
        $users = $this->model->users
            ->where("role", "<>", "admin")
            ->where("status", "=", "1")
            ->get();
        $pengajuan = $this->model->pengajuan
            ->select("pengajuan_surat.nik,surat.id,nama_lengkap,nama_surat,pengajuan_surat.created_at,status")
            ->join("masyarakat", "pengajuan_surat.nik", "masyarakat.nik")
            ->join("surat", "pengajuan_surat.id_surat", "surat.id")
            ->where("status", "=", "di_terima_rw")
            ->where("DATE(pengajuan_surat.created_at)", "=", $currentDate)
            ->orderBy("pengajuan_surat.created_at", "desc")
            ->get();
        $listRt = $this->model->kartuKeluarga->select("rt")->groupBy("rt")->orderBy("rt")->get();
        $listRw = $this->model->kartuKeluarga->select("rw")->groupBy("rw")->orderBy("rw")->get();
        $chart = $this->formatChartData();
        $params["data"] = (object)[
            "title" => "Dashboard",
            "description" => "Selamat datang di dashboard admin",
            "listRt" => $listRt,
            "listRw" => $listRw,
            "jenis_surat" => count($jenisSurat),
            "users" => count($users),
            "pengajuan" => $pengajuan,
            "berita" => count($berita),
            "kartuKeluarga" => count($kartuKeluarga),
            ...$chart,
            "bulan" => strtr(date("F"), $this->bulanIndonesia)

        ];




        return view("admin/dashboard/dashboard", $params);
    }


    private function formatChartData()
    {

        $filterRw = request("rw");
        $filterRt = request("rt");
        $tmpChartData = [];
        $maxDay = date("t");
        for ($i = 1; $i <= $maxDay; $i++) {
            $date = sprintf("%s-%02d", date("Y-m"), $i);
            $tmpPengajuanSuratMasuk = $this->model->pengajuan
                ->join("masyarakat", "pengajuan_surat.nik", "masyarakat.nik")
                ->join("kartu_keluarga", "masyarakat.no_kk", "kartu_keluarga.no_kk")
                ->where("DATE(pengajuan_surat.created_at)", "=", $date)
                ->where("status", "=", "di_terima_rw");

            if ($filterRw) {
                $tmpPengajuanSuratMasuk->where("rw", "=", $filterRw);
            }
            if ($filterRt) {
                $tmpPengajuanSuratMasuk->where("rt", "=", $filterRt);
            }
            $tmpPengajuanSuratMasuk = $tmpPengajuanSuratMasuk->get();
            $tmpPengajuanSuratSelesai = $this->model->pengajuan
                ->join("masyarakat", "pengajuan_surat.nik", "masyarakat.nik")
                ->join("kartu_keluarga", "masyarakat.no_kk", "kartu_keluarga.no_kk")
                ->where("DATE(pengajuan_surat.created_at)", "=", $date)
                ->where("status", "=", "selesai");


            if ($filterRw) {
                $tmpPengajuanSuratSelesai->where("rw", "=", $filterRw);
            }

            if ($filterRt) {
                $tmpPengajuanSuratSelesai->where("rt", "=", $filterRt);
            }

            $tmpPengajuanSuratSelesai = $tmpPengajuanSuratSelesai->get();
            $tmpChartData["label"][] = $i;
            $tmpChartData["surat_masuk"][] = count($tmpPengajuanSuratMasuk);
            $tmpChartData["surat_selesai"][] = count($tmpPengajuanSuratSelesai);
        }

        $rw =   $this->model->users
            ->where("role", "=", "rw")
            ->where("status", "=", "1")
            ->get();
        $rt = $this->model->users
            ->where("role", "=", "rt")
            ->where("status", "=", "1")
            ->get();
        $masyarakat = $this->model->users->where("role", "=", "masyarakat")->get();

        $tmpChartData["pengguna"] = [count($rw), count($rt), count($masyarakat)];
        return $tmpChartData;
    }
}
