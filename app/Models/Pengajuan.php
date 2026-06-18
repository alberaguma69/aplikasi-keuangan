<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

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

        public function user()
        {
            return $this->belongsTo(User::class);
        }

}

