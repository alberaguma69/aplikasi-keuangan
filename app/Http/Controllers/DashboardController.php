<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\Notification;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    /**
     * INDEX
     */
    public function index(Request $request)
    {
        $query = Pengajuan::where(
            'user_id',
            auth()->id()
        );

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

        // FILTER DARI TANGGAL
        if ($request->filled('dari')) {

            $query->where(
                'tanggal_pengajuan',
                '>=',
                $request->dari
            );

        }

        // FILTER SAMPAI TANGGAL
        if ($request->filled('sampai')) {

            $query->where(
                'tanggal_pengajuan',
                '<=',
                $request->sampai
            );

        }

        $pengajuans = $query
            ->latest()
            ->paginate(6)
            ->withQueryString();

        return view(
            'pemohon.dashboard',
            compact('pengajuans')
        );
    }

    /**
     * HAPUS NOTIFIKASI
     */
    public function deleteNotification($id)
    {
        \App\Models\Notification::where('id', $id)
            ->where('user_id', auth()->id())
            ->delete();

        return back();
    }

    /**
     * HAPUS SEMUA NOTIFIKASI
     */
    public function deleteAllNotifications()
    {
        \App\Models\Notification::where(
            'user_id',
            auth()->id()
        )->delete();

        return back();
    }

    /**
     * PROFILE
     */
    public function profile()
    {
        return view('pemohon.profile');
    }

    /**
     * UPDATE PROFILE
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email'
        ]);

        auth()->user()->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return back()->with(
            'success',
            'Profil berhasil diperbarui'
        );
    }

    /**
     * PASSWORD
     */
    public function password()
    {
        return view('pemohon.password');
    }

    /**
     * UPDATE PASSWORD
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed'
        ]);

        auth()->user()->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with(
            'success',
            'Password berhasil diperbarui'
        );
    }
}