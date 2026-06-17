<?php

namespace App\Http\Controllers\Pemohon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\User;
use App\Models\Notification;

class PengajuanController extends Controller
{
    /**
     * Halaman form pengajuan
     */
    public function create()
    {
        return view('pemohon.pengajuan.create');
    }

    /**
     * Simpan pengajuan
     */
    public function store(Request $request)
    {
        // VALIDASI
        $request->validate([
            'kategori' => 'required',
            'dibayarkan' => 'required',
            'keterangan' => 'required',
            'nominal' => 'required',
            'uang_muka_awal' => 'nullable|numeric|min:0',
            'tanggal_pengajuan' => 'required',
            'berkas' => 'required|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048'
        ]);

        // UPLOAD FILE
        $file = $request->file('berkas');

        $filename = time() . '.' . $file->getClientOriginalExtension();

        $path = $file->storeAs(
            'berkas',
            $filename,
            'public'
        );

        // SIMPAN KE DATABASE
        $pengajuan = Pengajuan::create([
            'user_id' => auth()->id(),
            'kategori' => $request->kategori,
            'dibayarkan' => $request->dibayarkan,
            'keterangan' => $request->keterangan,
            'nominal' => $request->nominal,
            'uang_muka_awal' => $request->uang_muka_awal,
            'tanggal_pengajuan' => $request->tanggal_pengajuan,
            'berkas' => $filename,
            'status' => 'pending',
        ]);

        // TEST NOTIFIKASI KE USER KEUANGAN
        $keuanganUsers = User::where('role', 'keuangan')->get();

        foreach ($keuanganUsers as $user) {

            Notification::create([
                'user_id' => $user->id,
                'title' => 'Pengajuan Baru',
                'message' => auth()->user()->name . ' mengajukan permohonan dana baru',
                'is_read' => false
            ]);
        }

        return back()->with('success', 'Pengajuan berhasil dikirim');
    }

    /**
     * FORM EDIT
     */
    public function edit($id)
    {
        $pengajuan = Pengajuan::findOrFail($id);

        return view('pemohon.pengajuan.edit', compact('pengajuan'));
    }

    /**
     * UPDATE DOKUMEN
     */
    public function update(Request $request, $id)
    {
    $request->validate([
    'berkas' => 'required|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048'
    ]);


    $pengajuan = Pengajuan::findOrFail($id);

    // UPLOAD FILE BARU
    $file = $request->file('berkas');

    $filename = time() . '.' . $file->getClientOriginalExtension();

    $file->storeAs(
        'berkas',
        $filename,
        'public'
    );

    // UPDATE
    $pengajuan->update([
        'berkas' => $filename,
        'status' => 'pending'
    ]);

    $keuanganUsers = User::where('role', 'keuangan')->get();

    foreach ($keuanganUsers as $user) {

        Notification::create([
            'user_id' => $user->id,
            'title' => 'Dokumen Diperbarui',
            'message' => auth()->user()->name . ' memperbarui dokumen pengajuan',
        ]);
    }

    return redirect('/dashboard')
        ->with('success', 'Dokumen berhasil diperbarui');


    }

}