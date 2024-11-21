<?php

namespace app\controllers;

use app\abstract\Controller;
use app\models\FormatSuratModel;
use app\models\JenisSuratModel;
use app\models\KartuKeluargaModel;
use app\models\LampiranModel;
use app\models\LampiranPengajuanModel;
use app\models\LampiranSuratModel;
use app\models\MasyarakatModel;
use app\models\PengajuanSuratModel;
use Dompdf\Dompdf;
use FileUploader;

class SuratMasukSelesaiController extends Controller
{
    private $model;
    function __construct()
    {
        if (!auth()->check()) {
            redirect("/login");
        }
        $this->model =  (object)[];
        $this->model->psurat  = new PengajuanSuratModel();
        $this->model->lpengajuan  = new LampiranPengajuanModel();

        $this->model->formatSurat  = new FormatSuratModel();
    }
    public function  index()
    {
        $data = $this->model->psurat->select("pengajuan_surat.id", "nomor_surat", "masyarakat.nik", "nama_lengkap", "nama_surat", "pengajuan_surat.created_at", "status", "no_hp")->join("masyarakat", "masyarakat.nik", "pengajuan_surat.nik")->join("surat", "surat.id", "pengajuan_surat.id_surat")->join("users", "users.nik", "pengajuan_surat.nik")->where("status","=","selesai")->get();

        $params["data"] = (object)[
            "title" => "Jenis Surat",
            "description" => "Kelola Jenis dengan mudah",
            "data" => $data,

        ];
        return view('admin/surat_masuk_selesai/surat_selesai', $params);
    }
    public function  getdata($id)
    {
        $biodata = $this->model->psurat->select(
            "nomor_surat as nomor_surat",
            "nama_surat as nama_surat",
            "nik as nik",
            "nama_lengkap as nama_lengkap",
            "tempat_lahir as tempat_lahir",
            "tgl_lahir as tanggal_lahir",
            "jenis_kelamin as jenis_kelamin",
            "kewarganegaraan as kewarganegaraan",
            "agama as agama",
            "status_perkawinan as status_perkawinan",
            "pekerjaan as pekerjaan",
            "pengajuan_surat.created_at as tanggal_pengajuan"
        )
            ->join("masyarakat", "masyarakat.id", "pengajuan_surat.id_masyarakat")
            ->join("surat", "surat.id", "pengajuan_surat.id_surat")
            ->where("nomor_surat", "=", $id)->get();
        $datasurat = $this->model->psurat->select(
            "lampiran.nama_lampiran",
            "url"
        )
            ->join("surat", "surat.id", "pengajuan_surat.id_surat")
            ->join("lampiran_pengajuan", "lampiran_pengajuan.id_pengajuan", "pengajuan_surat.id")
            ->join("lampiran", "lampiran_pengajuan.id_lampiran", "lampiran.id")
            ->where("nomor_surat", "=", $id)->get();
        $params = [
            "biodata" => $biodata,
            "datasurat" => $datasurat,
        ];
        return response($params, 200);
    }


    public function exportPengajuan($idPengajuan)
    {
        $formatSurat = $this->model->formatSurat
            ->join("surat", "format_surat.id", "surat.id_format_surat")
            ->join("pengajuan_surat", "surat.id", "pengajuan_surat.id_surat")
            ->where("pengajuan_surat.id", "=", $idPengajuan)
            ->first();

        $data = $this->model->psurat->select("nama_lengkap,nomor_surat,pengajuan_surat.nik,rw,rt,kecamatan,kelurahan,kabupaten,tempat_lahir,tgl_lahir,jenis_kelamin,pekerjaan,agama,status_perkawinan,kewarganegaraan,alamat,pengajuan_surat.created_at")
            ->join("masyarakat", "masyarakat.nik", "pengajuan_surat.nik")
            ->join("kartu_keluarga", "masyarakat.no_kk", "kartu_keluarga.no_kk")
            ->join("surat", "surat.id", "pengajuan_surat.id_surat")
            ->join("users", "users.nik", "pengajuan_surat.nik")
            ->first();
        $html = $formatSurat->konten;
        $this->replaceValue($html, $data);
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        // Set opsi untuk orientasi dan ukuran kertas
        $dompdf->setPaper('A4', 'portrait');

        // Render HTML menjadi PDF
        $dompdf->render();

        // Output PDF untuk diunduh oleh pengguna
        $dompdf->stream("Surat_" . $idPengajuan . ".pdf", [
            "Attachment" => false // Ubah ke false jika ingin ditampilkan di browser
        ]);
        // dd($html);
    }


    private function replaceValue(&$html, $data)
    {
        $html = str_replace("{nama}", $data->nama_lengkap, $html);
        $html = str_replace("{no_surat}", $data->nomor_surat, $html);
        $html = str_replace("{nik}", $data->nik, $html);
        $html = str_replace("{rw}", $data->rw, $html);
        $html = str_replace("{rt}", $data->rt, $html);
        $html = str_replace("{kecamatan}", $data->kecamatan, $html);
        $html = str_replace("{desa}", $data->kelurahan, $html);
        $html = str_replace("{kabupaten}", $data->kabupaten, $html);
        $html = str_replace("{tempat_lahir}", $data->tempat_lahir, $html);
        $html = str_replace("{tanggal_lahir}", $data->tgl_lahir, $html);
        $html = str_replace("{jenis_kelamin}", $data->jenis_kelamin, $html);
        $html = str_replace("{pekerjaan}", $data->pekerjaan, $html);
        $html = str_replace("{agama}", $data->agama, $html);
        $html = str_replace("{status_perkawinan}", $data->status_perkawinan, $html);
        $html = str_replace("{kewarganegaraan}", $data->kewarganegaraan, $html);
        $html = str_replace("{alamat}", $data->alamat, $html);
        $html = str_replace("{tanggal_pengajuan}", formatDate($data->created_at), $html);
    }
    public function detail($id){
        $data = $this->model->psurat
        ->select("pengajuan_surat.nik,surat.id,nama_lengkap,nama_surat,surat.created_at as tanggal_pengajuan,pengajuan_surat.nomor_surat,no_pengantar_rw,jenis_kelamin,kewarganegaraan,agama,pekerjaan,alamat,tempat_lahir,tgl_lahir,status,nomor_surat_tambahan,kode_kelurahan")
        ->join("masyarakat", "pengajuan_surat.nik", "masyarakat.nik")
        ->join("kartu_keluarga", "masyarakat.no_kk", "kartu_keluarga.no_kk")
        ->join("surat", "pengajuan_surat.id_surat", "surat.id")
        ->where("surat.id", "=", $id)
        ->first();

   $lampiran = $this->model->lpengajuan
        ->select("nama_lampiran,url")
        ->where("id_pengajuan", "=",$data->id)
        ->join("lampiran", "lampiran_pengajuan.id_lampiran", "lampiran.id")
        ->get();

    $data->tgl_lahir = formatDate($data->tgl_lahir);
    $data->tanggal_pengajuan = formatDate($data->tanggal_pengajuan);
    $data->status = formatStatusPengajuan($data->status);
    $data->lampiran = $lampiran; 

    return response($data, 200);
    }
}
