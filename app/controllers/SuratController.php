<?php

namespace app\controllers;

use app\abstract\Controller;
use app\models\FieldsModel;
use app\models\FormatSuratModel;
use app\models\JenisSuratModel;
use app\models\KartuKeluargaModel;
use app\models\LampiranModel;
use app\models\LampiranSuratModel;
use app\models\MasyarakatModel;
use FileUploader;

class SuratController extends Controller
{
    private $model;


    function __construct()
    {
        if (!auth()->check()) {
            redirect("/login");
        }
        $this->model =  (object)[];
        $this->model->jsurat  = new JenisSuratModel();
        $this->model->lampiran  = new LampiranModel();
        $this->model->lampiransurat  = new LampiranSuratModel();
        $this->model->kartuKeluarga = new KartuKeluargaModel();
        $this->model->masyarakat = new MasyarakatModel();
        $this->model->fields = new FieldsModel();
        $this->model->formatSurat = new FormatSuratModel();
    }
    public function index()
    {

        $datasurat = $this->model->jsurat->orderBy("id", "desc")->get();

        $params["data"] = (object)[
            "title" => "Jenis Surat",
            "description" => "Kelola Jenis dengan mudah",
            "datasurat" => $datasurat
        ];
        return view("admin/surat/surat", $params);
    }

    public function create()
    {
        $lampiran = $this->model->lampiran->all();
        $params["data"] = (object)[
            "title" => "Ubah Surat",
            "description" => "Kelola Surat dengan mudah",
            "action_form" => url("/admin/surat"),
            "lampiran" => $lampiran,

            "data" => (object)[
                "nama" => "",
                "lampiran" => [],
                "fields" => [],

            ]
        ];
        return view("admin/surat/form", $params);
    }
    public function store()
    {
        request()->validate([
            "nama_surat" => "required",
        ]);

        $namasur = request("nama_surat");
        $ficon = request("file_icon");
        $fields = request("fields") ?? [];
        $typeData = request("typeData");
        $isRequired = request("isRequired");
        $lampiran = request("lampiran");

        // Validasi opsi
        if (empty($lampiran) || !is_array($lampiran)) {
            return redirect()->withInput(request()->getAll())->with("error", "Tidak ada data yang diterima.")->back();
        }


        $opsiUnik = array_unique($lampiran);

        if (count($lampiran) !== count($opsiUnik)) {
            return redirect()->with("error", "Terdapat data duplikat dalam pilihan Anda.")->back();
        }

        if (!empty($ficon['name'])) {
            $upload = $this->uploadImage($ficon);
            if (!$upload->statusUpload) {
                return redirect()->with("error", "$upload->statusUpload")->back();
            }
            $fileName = $upload->fileName;
        }

        // Update data surat
        $data = [
            "nama_surat" => $namasur,
            "image" => $fileName,
            "format_surat" => '<h2 style="text-align:center;"><strong>SURAT KETERANGAN</strong></h2><p style="text-align:center;"><strong>No.</strong> <span class="mention" data-mention="{no_surat}">{no_surat}</span><strong>&nbsp;</strong></p><p><strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</strong>Yang bertanda tangan di bawah ini ketua RT <span class="mention" data-mention="{rt}">{rt}</span> , RW <span class="mention" data-mention="{rw}">{rw}</span> Desa &nbsp;<span class="mention" data-mention="{desa}">{desa}</span> Kecamatan <span class="mention" data-mention="{kecamatan}">{kecamatan}</span> Kabupaten <span class="mention" data-mention="{kabupaten}">{kabupaten}</span> } dengan ini menerangkan bahwa :</p><figure class="table"><table><tbody><tr><td>Nama</td><td>: <span class="mention" data-mention="{nama}">{nama}</span></td></tr><tr><td>Tempat/ Tanggal lahir</td><td>: <span class="mention" data-mention="{tempat_lahir}">{tempat_lahir}</span>/ <span class="mention" data-mention="{tanggal_lahir}">{tanggal_lahir}</span></td></tr><tr><td>Jenis Kelamin</td><td>: <span class="mention" data-mention="{jenis_kelamin}">{jenis_kelamin}</span></td></tr><tr><td>Pekerjaan</td><td>: <span class="mention" data-mention="{pekerjaan}">{pekerjaan}</span>&nbsp;</td></tr><tr><td>Agama</td><td>: <span class="mention" data-mention="{agama}">{agama}</span>&nbsp;</td></tr><tr><td>Status perkawinan</td><td>: <span class="mention" data-mention="{status_perkawinan}">{status_perkawinan}</span>&nbsp;</td></tr><tr><td>Kewarganegaraan</td><td>: <span class="mention" data-mention="{kewarganegaraan}">{kewarganegaraan}</span>&nbsp;</td></tr><tr><td>Alamat</td><td>: <span class="mention" data-mention="{alamat}">{alamat}</span>&nbsp;</td></tr></tbody></table></figure><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Orang tersebut diatas, adalah benar-benar warga kami dan berdomisili di RT <span class="mention" data-mention="{rt}">{rt}</span> , RW <span class="mention" data-mention="{rw}">{rw}</span> Desa <span class="mention" data-mention="{desa}">{desa}</span> Kecamatan <span class="mention" data-mention="{kecamatan}">{kecamatan}</span> Kabupaten <span class="mention" data-mention="{kabupaten}">{kabupaten}</span> surat keterangan ini digunakan sebagai kelengkapan pengurusan perpindahan penduduk.</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Demikian surat keterangan ini kami buat, untuk dapat dipergunakan sebagaimana semestinya.</p><p>&nbsp;</p><p>&nbsp;</p><p style="text-align:right;"><span class="mention" data-mention="{tanggal_pengajuan}">{tanggal_pengajuan}</span> ,Ketua RT <span class="mention" data-mention="{rt}">{rt}</span> RW <span class="mention" data-mention="{rt}">{rt}</span> &nbsp; &nbsp; &nbsp;&nbsp;</p><p style="text-align:right;">&nbsp;</p><p style="text-align:right;">&nbsp;</p><p style="text-align:right;">&nbsp;</p><p style="text-align:right;"><span class="mention" data-mention="{nama}">{nama}</span> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p>'
        ];

        $id = $this->model->jsurat->create($data);

        foreach ($lampiran as $index => $data) {

            $this->model->lampiransurat->create([
                'id_lampiran' => $data,
                "id_surat" => $id
            ]);
        }

        foreach ($fields as $index => $data) {

            $this->model->fields->create([
                "id_surat" => $id,
                'nama_field' => strtolower(str_replace(" ", "_", trim($data))),
                "tipe" => $typeData[$index],
                "is_required" => $isRequired[$index]
            ]);
        }
        return redirect()->with("success", "Surat berhasil ditambah")->to("/admin/surat");
    }
    public function getedit($id)
    {

        $datasurat = $this->model->jsurat->where("id", "=", $id)->first();
        $data = $this->model->lampiransurat->select("id_surat", "lampiran.id", "nama_lampiran")
            ->join("lampiran", "lampiran.id", "id_lampiran")->where("id_surat", "=", $id)->get();
        $datasurat->image = url("/admin/assetssurat/" . $datasurat->image);
        $params = [
            "datasurat" => $datasurat,
            "datalampiran" => $data,
        ];
        return response($params, 200);
    }


    public function show($id)
    {
        $lampiran = $this->model->lampiran->all();
        $surat = $this->model->jsurat->find($id);

        $lampiranSurat = $this->model->lampiransurat
            ->where("id_surat", "=", $id)
            ->join("lampiran", "lampiran_surat.id_lampiran", "lampiran.id")
            ->get();

        $fieldsSurat = $this->model->fields
            ->where("id_surat", "=", $id)
            ->get();



        $params["data"] = (object)[
            "title" => "Detail Surat",
            "description" => "Kelola Surat dengan mudah",
            "action_form" => url("/admin/surat/$id"),
            "lampiran" => $lampiran,
            "data" => (object)[
                "nama" => $surat->nama_surat,
                "gambar" => url("/admin/assetssurat/$surat->image"),
                "lampiran" => $lampiranSurat,
                "fields" => $fieldsSurat,
            ]
        ];

        return view("admin/surat/show", $params);
    }
    public function edit($id)
    {
        $lampiran = $this->model->lampiran->all();
        $surat = $this->model->jsurat->find($id);

        $lampiranSurat = $this->model->lampiransurat
            ->where("id_surat", "=", $id)
            ->join("lampiran", "lampiran_surat.id_lampiran", "lampiran.id")
            ->get();

        $fieldsSurat = $this->model->fields
            ->where("id_surat", "=", $id)
            ->get();



        $params["data"] = (object)[
            "title" => "Ubah Surat",
            "description" => "Kelola Surat dengan mudah",
            "action_form" => url("/admin/surat/$id"),
            "lampiran" => $lampiran,
            "data" => (object)[
                "nama" => $surat->nama_surat,
                "gambar" => url("/admin/assetssurat/$surat->image"),
                "lampiran" => $lampiranSurat,
                "fields" => $fieldsSurat,
            ]
        ];

        return view("admin/surat/form", $params);
    }
    public function update($id)
    {
        request()->validate([
            "nama_surat" => "required",
        ]);

        $namasur = request("nama_surat");
        $ficon = request("file_icon");
        $fields = request("fields") ?? [];
        $typeData = request("typeData");
        $isRequired = request("isRequired");
        $fields_id = request("fields_id") ?? [];
        $lampiran = request("lampiran");
        $lampiran_id = request("lampiran_id");

        // Validasi opsi
        if (empty($lampiran) || !is_array($lampiran)) {
            return redirect()->withInput(request()->getAll())->with("error", "Tidak ada data yang diterima.")->back();
        }

        // Ambil data surat lama dari database
        $existingData = $this->model->jsurat->find($id);

        if (!$existingData) {
            return redirect()->with("error", "Data tidak ditemukan.")->back();
        }
        $opsiUnik = array_unique($lampiran);

        if (count($lampiran) !== count($opsiUnik)) {
            return redirect()->with("error", "Terdapat data duplikat dalam pilihan Anda.")->back();
        }

        $fileName = $existingData->image;
        if (!empty($ficon['name'])) {

            $upload = $this->uploadImage($ficon);
            if ($upload->statusUpload) {
                $upload->delete(storagePath("private", "/surat/" . $fileName));
            } else {
                return redirect()->with("error", "$upload->statusUpload")->back();
            }

            $fileName = $upload->fileName;
        }

        // Update data surat
        $data = [
            "nama_surat" => $namasur,
            "image" => $fileName,
        ];

        $this->model->jsurat->where("id", "=", $id)->update($data);

        foreach ($lampiran as $index => $data) {
            $exist = $this->model->lampiransurat->where("id", "=", $lampiran_id[$index])->first();
            $exist2 = $this->model->lampiransurat->where("id", "=", $lampiran_id[$index])->first();
            if ($exist || $exist2) {
                $this->model->lampiransurat->where("id", "=", $lampiran_id[$index])->update([
                    'id_lampiran' => $data
                ]);
            } else {
                $this->model->lampiransurat->create([
                    'id_lampiran' => $data,
                    "id_surat" => $id
                ]);
            }
        }
        foreach ($fields as $index => $data) {
            // terjadi bug jika hanya menggunakan 1 data
            $exist2 = $this->model->fields->where("id", "=", $fields_id[$index])->first();
            $exist = $this->model->fields->where("id", "=", $fields_id[$index])->first();

            if ($exist || $exist2) {
                $this->model->fields->where("id", "=", $fields_id[$index])->update([
                    'nama_field' => strtolower(str_replace(" ", "_", trim($data))),
                    "tipe" => $typeData[$index],
                    "is_required" => $isRequired[$index]
                ]);
            } else {
                $this->model->fields->create([
                    "id_surat" => $id,
                    'nama_field' => strtolower(str_replace(" ", "_", trim($data))),
                    "tipe" => $typeData[$index],
                    "is_required" => $isRequired[$index]
                ]);
            }
        }

        $this->model->fields
            ->where("id_surat", "=", $id)
            ->whereNotIn("id", $fields_id)
            ->delete();
        return redirect()->with("success", "Surat berhasil diubah")->to("/admin/surat");
    }


    public function delete($id)
    {
        $this->model->lampiransurat->where("id_surat", "=", $id)->delete();
        $this->model->jsurat->where("id", "=", $id)->delete();
        $existingData = $this->model->jsurat->find($id);
        $fileName = $existingData->image;
        $uploader = new FileUploader();
        $uploader->delete(storagePath("private", "/surat/" . $fileName));
        return response("succss");
    }

    private function uploadImage($file)
    {
        $maxFileSize = 2 * 1024 * 1024;
        if ($file['size'] > $maxFileSize) {
            return redirect()->with("error", "Ukuran file terlalu besar. Maksimal 2MB.")->back();
        }

        $fileExt = pathinfo($file['name'], PATHINFO_EXTENSION);
        $nameFile  = uniqid() . "." . $fileExt;
        $allowedFileTypes = ["jpg", "jpeg", "png", "gif", "bmp", "webp", "svg"];
        $uploader = new FileUploader();
        $uploader->setFile($file);
        $uploader->setTarget(storagePath("private", "/surat/" . $nameFile));
        $uploader->setAllowedFileTypes($allowedFileTypes);
        $uploader->fileName = $nameFile;
        // Hapus file lama jika ada dan nama file baru berhasil diunggah
        $uploader->upload();
        return $uploader;
    }
}
