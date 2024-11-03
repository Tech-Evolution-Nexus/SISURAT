<?php

namespace app\models;

use app\abstract\Model;

class PengajuanSuratModel extends Model
{
    protected $table  = "pengajuan_surat";
    protected $primaryKey  = "nomor_surat";
    protected $fillable = [
        'id',
        'nomor_surat',
        'no_pengantar',
        'status',
        'keterangan',
        'keterangan_ditolak',
        'file_pdf',
        'pengantar_rt',
        'pengantar_rw',
        'info',
        'id_masyarakat',
        'id_surat',
        'kode_kelurahan',
        'nomor_surat_tambahan',
        'created_at',
        'updated_at'
    ];
}
