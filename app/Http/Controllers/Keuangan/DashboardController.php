<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    /**
     * DASHBOARD KEUANGAN
     */
    public function index(Request $request)
    {
        $query = Pengajuan::query();

        // SEARCH
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('dibayarkan', 'like', "%{$search}%")
                ->orWhere('keterangan', 'like', "%{$search}%")
                ->orWhere('kategori', 'like', "%{$search}%")
                ->orWhere('id', $search);

            });
        }

        // FILTER TANGGAL
        if ($request->filled('dari')) {

            $query->where(
                'tanggal_pengajuan',
                '>=',
                $request->dari
            );

        }

        if ($request->filled('sampai')) {

            $query->where(
                'tanggal_pengajuan',
                '<=',
                $request->sampai
            );

        }

        $pengajuans = $query
            ->latest()
            ->paginate(5)
            ->withQueryString();

        $totalPengeluaran = Pengajuan::where('status', 'done')
            ->sum('nominal');

        $totalPending = Pengajuan::where('status', 'pending')
            ->count();

        $totalDone = Pengajuan::where('status', 'done')
            ->count();

        return view('keuangan.dashboard', compact(
            'pengajuans',
            'totalPengeluaran',
            'totalPending',
            'totalDone'
        ));
    }

    /**
     * APPROVE PENGAJUAN
     */
    public function approve(Request $request, $id)
    {
        $request->validate([
            'jadwal_pencairan' => 'required'
        ]);

        $pengajuan = Pengajuan::findOrFail($id);

        $pengajuan->update([
            'status' => 'approved',
            'jadwal_pencairan' => $request->jadwal_pencairan
        ]);

        Notification::create([
            'user_id' => $pengajuan->user_id,
            'title' => 'Pengajuan Disetujui',
            'message' => 'Pengajuan dana anda telah disetujui oleh bagian keuangan'
        ]);

        return back();
    }

    /**
     * REJECT PENGAJUAN
     */
    public function reject($id)
    {
        $pengajuan = Pengajuan::findOrFail($id);

        $pengajuan->update([
            'status' => 'rejected'
        ]);

        Notification::create([
            'user_id' => $pengajuan->user_id,
            'title' => 'Pengajuan Ditolak',
            'message' => 'Pengajuan dana anda ditolak oleh bagian keuangan'
        ]);

        return back();
    }

    /**
     * PEMBUKUAN
     */
    public function pembukuan(Request $request)
    {
        $pengajuans = Pengajuan::whereIn(
            'status',
            [
                'approve_and_process',
                'done'
            ]
        );

        // SEARCH
        if ($request->filled('search')) {

            $search = $request->search;

            $pengajuans->where(function ($q) use ($search) {

                $q->where('nomor_jurnal', 'like', "%{$search}%")
                ->orWhere('dibayarkan', 'like', "%{$search}%")
                ->orWhere('id', $search);

            });
        }

        // FILTER TANGGAL
        if ($request->filled('dari')) {

            $pengajuans->where(
                'jadwal_pencairan',
                '>=',
                $request->dari
            );
        }

        if ($request->filled('sampai')) {

            $pengajuans->where(
                'jadwal_pencairan',
                '<=',
                $request->sampai
            );
        }

        $pengajuans = $pengajuans
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'keuangan.pembukuan',
            compact('pengajuans')
        );
    }

    /**
     * PERMOHONAN
     */
    public function permohonan(Request $request)
    {
        $pengajuans = Pengajuan::where('status', 'pending');

        // SEARCH
        if ($request->filled('search')) {

            $search = $request->search;

            $pengajuans->where(function ($q) use ($search) {

                $q->where('dibayarkan', 'like', "%{$search}%")
                ->orWhere('keterangan', 'like', "%{$search}%")
                ->orWhere('id', $search);

            });
        }

        $pengajuans = $pengajuans
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'keuangan.permohonan',
            compact('pengajuans')
        );
    }

    /**
     * REJECTED PENGAJUAN
     */
    public function rejected()
    {
        $pengajuans = Pengajuan::where(
            'status',
            'rejected'
        )
        ->latest()
        ->paginate(5);

        return view(
            'keuangan.rejected',
            compact('pengajuans')
        );
    }

    /**
     * UPDATE STATUS PENGAJUAN
     */
    public function updateStatus(Request $request, $id)
    {
        $pengajuan = Pengajuan::findOrFail($id);

        // VALIDASI BERDASARKAN STATUS
        if ($request->status == 'approve_and_process') {

            $request->validate([
                'jadwal_pencairan' => 'required',
                'nomor_jurnal' => 'required'
            ]);

        } elseif ($request->status == 'rejected') {

            $request->validate([
                'alasan_reject' => 'required'
            ]);

        }

        $pengajuan->update([
            'status' => $request->status,

            'jadwal_pencairan' => $request->status == 'approve_and_process'
                ? $request->jadwal_pencairan
                : $pengajuan->jadwal_pencairan,

            'nomor_jurnal' => $request->status == 'approve_and_process'
                ? $request->nomor_jurnal
                : $pengajuan->nomor_jurnal,

            'alasan_reject' => $request->status == 'rejected'
                ? $request->alasan_reject
                : null,
        ]);

        // NOTIFIKASI
        if ($request->status == 'approve_and_process') {

            Notification::create([
                'user_id' => $pengajuan->user_id,
                'title' => 'Pengajuan Diproses',
                'message' => 'Pengajuan dana anda sedang diproses oleh bagian keuangan',
            ]);

        } elseif ($request->status == 'done') {

            Notification::create([
                'user_id' => $pengajuan->user_id,
                'title' => 'Dana Sudah Dicairkan',
                'message' => 'Dana pengajuan anda telah selesai dicairkan',
            ]);

        } elseif ($request->status == 'rejected') {

            Notification::create([
                'user_id' => $pengajuan->user_id,
                'title' => 'Pengajuan Ditolak',
                'message' => 'Alasan: ' . $request->alasan_reject,
            ]);

        }

        return back()->with('success', 'Status berhasil diperbarui');
    }

    /**
     * UPDATE JURNAL
     */
    public function updateJurnal(Request $request, $id)
    {
        $request->validate([
            'nomor_jurnal' => 'required'
        ]);

        $pengajuan = Pengajuan::findOrFail($id);

        $pengajuan->update([
            'nomor_jurnal' => $request->nomor_jurnal
        ]);

        return back()->with('success', 'Nomor jurnal berhasil diperbarui');
    }

    /**
     * UPLOAD JURNAL
     */
    public function uploadJurnal(Request $request, $id)
    {
        $request->validate([
            'dokumen_jurnal_baru' => 'required|mimes:pdf|max:2048'
        ]);

        $pengajuan = Pengajuan::findOrFail($id);

        if ($request->hasFile('dokumen_jurnal_baru')) {

            $file = $request->file('dokumen_jurnal_baru');

            $namaFile = time() . '_' . $file->getClientOriginalName();

            $file->move(
                public_path('jurnal'),
                $namaFile
            );

            // SIMPAN KE DATABASE
            $pengajuan->update([
                'status' => 'done',
                'nomor_jurnal' => $request->nomor_jurnal,
                'dokumen_jurnal_baru' => $namaFile,
            ]);
    }

    $keuanganUsers = User::where('role', 'keuangan')->get();

    foreach ($keuanganUsers as $user) {

        Notification::create([
            'user_id' => $user->id,
            'title' => 'Jurnal Diupload',
            'message' => 'Dokumen jurnal untuk FL' . str_pad($pengajuan->id, 4, '0', STR_PAD_LEFT) . ' telah diupload',
        ]);
    }

        return back()->with(
            'success',
            'Dokumen jurnal berhasil diupload'
        );
    }

    /**
     * USER MANAGEMENT
     */
    public function user(Request $request)
    {
        $users = User::query();

        if ($request->filled('search')) {

            $search = $request->search;

            $users->where(function ($q) use ($search) {

                $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");

            });
        }

        $users = $users
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'keuangan.user',
            compact('users')
        );
    }

    /**
     * STORE USER
     */
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return back()->with(
            'success',
            'User berhasil ditambahkan'
        );
    }

    /**
     * UPDATE USER
     */
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        // Jika password diisi
        if (!empty($request->password)) {

            $request->validate([
                'password' => 'confirmed|min:6'
            ]);

            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'User berhasil diperbarui');
    }

    /**
     * HAPUS USER
     */
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        // Mencegah akun sendiri terhapus
        if ($user->id == auth()->id()) {

            return back()->with(
                'error',
                'Akun yang sedang login tidak dapat dihapus'
            );
        }

        $user->delete();

        return back()->with(
            'success',
            'User berhasil dihapus'
        );
    }

    /**
     * PROFILE
     */
    public function profile()
    {
        return view('keuangan.profile');
    }

    /**
     * UPDATE PROFILE
     */
    public function updateProfile(Request $request)
    {
        auth()->user()->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui');
    }

    /**
     * PASSWORD
     */
    public function password()
    {
        return view('keuangan.password');
    }

    /**
     * UPDATE PASSWORD
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:6'
        ]);

        auth()->user()->update([
            'password' => bcrypt($request->password)
        ]);

        return back()->with('success', 'Password berhasil diperbarui');
    }

    /**
     * READ NOTIFICATIONS
     */
    public function readNotifications()
    {
        Notification::where('user_id', auth()->id())
            ->update([
                'is_read' => true
            ]);

        return back();
    }

    /**
     * HAPUS NOTIFIKASI
     */
    public function deleteNotification($id)
    {
        Notification::where('id', $id)
            ->where('user_id', auth()->id())
            ->delete();

        return back();
    }

    /**
     * HAPUS SEMUA NOTIFIKASI
     */
    public function deleteAllNotifications()
    {
        Notification::where(
            'user_id',
            auth()->id()
        )->delete();

        return back();
    }
    /**
     * HAPUS PEMBUKUAN
     */

    public function bulkDeletePembukuan(Request $request)
    {
        $data = Pengajuan::whereIn('id', $request->ids)->get();

        foreach ($data as $pengajuan) {

            if ($pengajuan->berkas) {

                $file = public_path('berkas/' . $pengajuan->berkas);

                if (file_exists($file)) {
                    unlink($file);
                }
            }

            if ($pengajuan->dokumen_jurnal) {

                $file = public_path('jurnal/' . $pengajuan->dokumen_jurnal);

                if (file_exists($file)) {
                    unlink($file);
                }
            }

            if ($pengajuan->dokumen_jurnal_baru) {

                $file = public_path('jurnal/' . $pengajuan->dokumen_jurnal_baru);

                if (file_exists($file)) {
                    unlink($file);
                }
            }
        }

        Pengajuan::whereIn('id', $request->ids)->delete();

        return back()->with(
            'success',
            'Data dan file berhasil dihapus'
        );
    }

    /**
     * RESTORE PENGAJUAN YANG DITOLAK
     */
    public function bulkRestore(Request $request)
    {
        Pengajuan::whereIn('id', $request->ids)
            ->update([
                'status' => 'pending',
                'alasan_reject' => null
            ]);

        return back();
    }

    /**
     * HAPUS PENGAJUAN YANG DITOLAK
     */
public function bulkDeleteRejected(Request $request)
{
    if (!$request->has('ids') || empty($request->ids)) {

        return back()->with('error', 'Pilih data yang ingin dihapus');

    }

    Pengajuan::whereIn('id', $request->ids)->delete();

    return back()->with('success', 'Data berhasil dihapus');
}

}
