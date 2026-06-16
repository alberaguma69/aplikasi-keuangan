<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
        protected $fillable = [
            'user_id',
            'kategori',
            'dibayarkan',
            'keterangan',
            'nominal',
            'uang_muka_awal',
            'tanggal_pengajuan',
            'berkas',
            'dokumen_jurnal',
            'dokumen_jurnal_baru',
            'nomor_jurnal',
            'jadwal_pencairan',
            'status',
            'alasan_reject',
        ];

}

