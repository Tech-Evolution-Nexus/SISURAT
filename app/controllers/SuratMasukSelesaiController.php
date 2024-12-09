<?php

namespace app\controllers;

use app\abstract\Controller;
use app\models\FieldsModel;
use app\models\FieldValuesModel;
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
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class SuratMasukSelesaiController extends Controller
{
    private $model;
    function __construct()
    {
        $url = $_SERVER["REQUEST_URI"];
        // dd($url);
        if (!auth()->check()  && strpos($url, "api") === false) {
            redirect("/login");
        }
        $this->model =  (object)[];
        $this->model->psurat  = new PengajuanSuratModel();
        $this->model->lpengajuan  = new LampiranPengajuanModel();

        $this->model->formatSurat  = new FormatSuratModel();
        $this->model->masyarakat  = new MasyarakatModel();
        $this->model->fieldValues  = new FieldValuesModel();
        $this->model->fields  = new FieldsModel();
        $this->model->fieldsValues = new FieldValuesModel();
    }
    public function  index()
    {
        $data = $this->model->psurat
            ->select("pengajuan_surat.id", "nomor_surat", "masyarakat.nik", "nama_lengkap", "nama_surat", "pengajuan_surat.created_at", "pengajuan_surat.status", "no_hp")
            ->join("masyarakat", "masyarakat.nik", "pengajuan_surat.nik")
            ->join("surat", "surat.id", "pengajuan_surat.id_surat")
            ->join("users", "users.nik", "pengajuan_surat.nik")
            ->where("pengajuan_surat.status", "=", "selesai")
            ->orderBy("id", "desc")
            ->get();

        $params["data"] = (object)[
            "title" => "Surat Selesai",
            "description" => "Kelola Surat Selesai dengan mudah",
            "data" => $data,

        ];
        return view('admin/surat_masuk_selesai/surat_selesai', $params);
    }
    public function exportsuratselesai()
    {
        // dd("");
        $data = $this->model->psurat
            ->select("pengajuan_surat.id", "nomor_surat", "nama_lengkap", "nama_surat", "pengajuan_surat.created_at")
            ->join("masyarakat", "masyarakat.nik", "pengajuan_surat.nik")
            ->join("surat", "surat.id", "pengajuan_surat.id_surat")
            ->get();

        // Membuat Spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Menulis header ke file Excel
        $header = ['ID', 'No Surat', 'Nama Pengaju', 'Nama Surat', 'Waktu Pengajuan'];
        $sheet->fromArray($header, NULL, 'A1');

        $startRow = 2;
        foreach ($data as $row) {
            // Menggunakan properti objek untuk mengambil nilai
            $sheet->setCellValue('A' . $startRow, $row->id);
            $sheet->setCellValue('B' . $startRow, $row->nomor_surat);
            $sheet->setCellValue('C' . $startRow, $row->nama_lengkap);
            $sheet->setCellValue('D' . $startRow, $row->nama_surat);
            $sheet->setCellValue('E' . $startRow, $row->created_at);
            $startRow++;
        }


        // Mengatur nama file untuk download
        $filename = 'data_pengajuan.xlsx';

        // Mengunduh file
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        // Tulis dan kirim file ke browser
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
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
            ->where("pengajuan_surat.id", "=", $id)
            ->get();
        $datasurat = $this->model->psurat->select(
            "lampiran.nama_lampiran",
            "url"
        )
            ->join("surat", "surat.id", "pengajuan_surat.id_surat")
            ->join("lampiran_pengajuan", "lampiran_pengajuan.id_pengajuan", "pengajuan_surat.id")
            ->join("lampiran", "lampiran_pengajuan.id_lampiran", "lampiran.id")
            ->where("pengajuan_surat.id", "=", $id)
            ->get();
        $params = [
            "biodata" => $biodata,
            "datasurat" => $datasurat,
        ];
        return response($params, 200);
    }


    public function exportPengajuan($idPengajuan)
    {


        $data = $this->model->psurat->select("pengajuan_surat.id as id_pengajuan,format_surat,id_surat,nama_lengkap,nomor_surat,pengajuan_surat.nik,rw,rt,kecamatan,kelurahan,kabupaten,tempat_lahir,tgl_lahir,jenis_kelamin,pekerjaan,agama,status_perkawinan,kewarganegaraan,alamat,pengajuan_surat.created_at,nama_surat,pendidikan,kartu_keluarga.no_kk,alamat")
            ->join("masyarakat", "masyarakat.nik", "pengajuan_surat.nik")
            ->join("kartu_keluarga", "masyarakat.no_kk", "kartu_keluarga.no_kk")
            ->join("surat", "surat.id", "pengajuan_surat.id_surat")
            ->join("users", "users.nik", "pengajuan_surat.nik")
            ->where("pengajuan_surat.id", "=", $idPengajuan)
            ->first();

        $data->bapak = $this->model->masyarakat
            ->where("status_keluarga", "=", "kk")
            ->where("no_kk", "=", $data->no_kk)
            ->first();
        $data->ibu = $this->model->masyarakat
            ->where("status_keluarga", "=", "istri")
            ->where("no_kk", "=", $data->no_kk)
            ->first();

        $fields = $this->model->fields->select("nama_field,id")->where("id_surat", "=", $data->id_surat)->get();

        $data->fields = $fields;

        $html = "<style>
                @page { margin:10px 50px; }
                img{
                    height:auto;
                    max-width:100%;
                }
                .image-style-align-left{
                    float:left;
                }
                .image-style-align-right{
                    float:right;
                }
                .image-style-block-align-right{
                    margin-left: auto;
                    margin-right: 0;
                }
                .image-style-block-align-left{
                    margin-left: 0;
                    margin-right: auto;
                }
                </style>";

        $html .= $data->format_surat;
        $this->replaceValue($html, $data);
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $options = $dompdf->getOptions();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf->setOptions($options);
        $dompdf->render();
        $dompdf->stream($data->nama_surat . ".pdf", [
            "Attachment" => false // Ubah ke false jika ingin ditampilkan di browser
        ]);
    }


    private function replaceValue(&$html, $data)
    {
        $noSurat = $data->nomor_surat;
        $html = str_replace("{no_surat}", $noSurat ?? "", $html);
        $html = str_replace("{nama}", $data->nama_lengkap ?? "", $html);
        $html = str_replace("{nik}", $data->nik ?? "", $html);
        $html = str_replace("{tempat_lahir}", $data->tempat_lahir ?? "", $html);
        $html = str_replace("{tanggal_lahir}", $data->tgl_lahir ?? "", $html);
        $html = str_replace("{jenis_kelamin}", $data->jenis_kelamin ?? "", $html);
        $html = str_replace("{pekerjaan}", $data->pekerjaan ?? "", $html);
        $html = str_replace("{agama}", $data->agama ?? "", $html);
        $html = str_replace("{status_perkawinan}", $data->status_perkawinan ?? "", $html);
        $html = str_replace("{kewarganegaraan}", $data->kewarganegaraan ?? "", $html);
        $html = str_replace("{pendidikan}", $data->pendidikan ?? "", $html);
        $html = str_replace("{alamat}", $data->alamat ?? "", $html);
        $html = str_replace("{rw}", $data->rw ?? "", $html);

        if ($data->bapak) {
            $html = str_replace("{nama_bapak}", $data->bapak->nama_lengkap ?? "", $html);
            $html = str_replace("{nik_bapak}", $data->bapak->nik ?? "", $html);
            $html = str_replace("{tempat_lahir_bapak}", $data->bapak->tempat_lahir ?? "", $html);
            $html = str_replace("{tanggal_lahir_bapak}", $data->bapak->tgl_lahir ?? "", $html);
            $html = str_replace("{jenis_kelamin_bapak}", $data->bapak->jenis_kelamin ?? "", $html);
            $html = str_replace("{pekerjaan_bapak}", $data->bapak->pekerjaan ?? "", $html);
            $html = str_replace("{agama_bapak}", $data->bapak->agama ?? "", $html);
            $html = str_replace("{status_perkawinan_bapak}", $data->bapak->status_perkawinan ?? "", $html);
            $html = str_replace("{kewarganegaraan_bapak}", $data->bapak->kewarganegaraan ?? "", $html);
            $html = str_replace("{pendidikan_bapak}", $data->bapak->pendidikan ?? "", $html);
            $html = str_replace("{alamat_bapak}", $data->bapak->alamat ?? "", $html);
        }

        if ($data->ibu) {
            $html = str_replace("{nama_ibu}", $data->ibu->nama_lengkap ?? "", $html);
            $html = str_replace("{nik_ibu}", $data->ibu->nik ?? "", $html);
            $html = str_replace("{tempat_lahir_ibu}", $data->ibu->tempat_lahir ?? "", $html);
            $html = str_replace("{tanggal_lahir_ibu}", $data->ibu->tgl_lahir ?? "", $html);
            $html = str_replace("{jenis_kelamin_ibu}", $data->ibu->jenis_kelamin ?? "", $html);
            $html = str_replace("{pekerjaan_ibu}", $data->ibu->pekerjaan ?? "", $html);
            $html = str_replace("{agama_ibu}", $data->ibu->agama ?? "", $html);
            $html = str_replace("{status_perkawinan_ibu}", $data->ibu->status_perkawinan ?? "", $html);
            $html = str_replace("{kewarganegaraan_ibu}", $data->ibu->kewarganegaraan ?? "", $html);
            $html = str_replace("{pendidikan_ibu}", $data->ibu->pendidikan ?? "", $html);
            $html = str_replace("{alamat_ibu}", $data->ibu->alamat ?? "", $html);
        }


        $html = str_replace("{rw}", $data->rw ?? "", $html);
        $html = str_replace("{rt}", $data->rt ?? "", $html);
        $html = str_replace("{kecamatan}", $data->kecamatan ?? "", $html);
        $html = str_replace("{desa}", $data->kelurahan ?? "", $html);
        $html = str_replace("{kabupaten}", $data->kabupaten ?? "", $html);
        $html = str_replace("{tanggal_pengajuan}", formatDate($data->created_at) ?? "", $html);


        foreach ($data->fields as $field) {
            $value = $this->model->fieldValues
                ->where("id_field", "=", $field->id)
                ->where("id_pengajuan", "=", $data->id_pengajuan)
                ->first();
            $namaField = "{field_" . strtolower(str_replace(" ", "_", trim($field->nama_field)) . "}");

            $html = str_replace($namaField,  $value->value ?? "-", $html);
        }
    }
    public function detail($id)
    {
        $data = $this->model->psurat
            ->select("pengajuan_surat.nik,surat.id,nama_lengkap,nama_surat,surat.created_at as tanggal_pengajuan,pengajuan_surat.nomor_surat,no_pengantar_rw,jenis_kelamin,kewarganegaraan,agama,pekerjaan,alamat,tempat_lahir,tgl_lahir,status,kode_kelurahan")
            ->join("masyarakat", "pengajuan_surat.nik", "masyarakat.nik")
            ->join("kartu_keluarga", "masyarakat.no_kk", "kartu_keluarga.no_kk")
            ->join("surat", "pengajuan_surat.id_surat", "surat.id")
            ->where("pengajuan_surat.id", "=", $id)
            ->first();

        $lampiran = $this->model->lpengajuan
            ->select("nama_lampiran,url")
            ->where("id_pengajuan", "=", $id)
            ->join("lampiran", "lampiran_pengajuan.id_lampiran", "lampiran.id")
            ->get();

        $fields = $this->model->fieldsValues
            ->select("nama_field,value")
            ->join("fields", "field_values.id_field", "fields.id")
            ->where("id_pengajuan", "=", $id)
            ->get();

        $data->tgl_lahir = formatDate($data->tgl_lahir);
        $data->tanggal_pengajuan = formatDate($data->tanggal_pengajuan);
        $data->status = formatStatusPengajuan($data->status);
        $data->lampiran = $lampiran;
        $data->fields = $fields;

        return response($data, 200);
    }
}
