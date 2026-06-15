@extends('layouts.keuangan')

@section('title', 'Dashboard Keuangan')

@section('content')

<!-- HEADER -->
<div class="flex items-center justify-between mb-8">

    <div>

        <h1 class="text-3xl font-extrabold text-gray-900">
            DASHBOARD KEUANGAN
        </h1>

        <p class="text-sm text-gray-400 mt-1">
            Kelola seluruh pengajuan dana
        </p>

    </div>

    @include('keuangan.includes.topbar')

</div>

<!-- STATISTIC -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">

    <!-- TOTAL -->
    <div class="bg-gradient-to-r from-indigo-700 to-blue-700 text-white rounded-3xl p-5">

        <p class="text-xs opacity-70 mb-2">
            TOTAL PENGELUARAN
        </p>

        <h1 class="text-3xl font-extrabold">

            RP {{ number_format($totalPengeluaran, 0, ',', '.') }}

        </h1>

    </div>

    <!-- PENDING -->
    <div class="bg-white rounded-3xl p-5 border border-gray-100">

        <p class="text-xs text-gray-400 mb-2">
            ANTRIAN CEK
        </p>

        <h1 class="text-3xl font-extrabold text-yellow-500">

            {{ $totalPending }}

        </h1>

    </div>

    <!-- DONE -->
    <div class="bg-white rounded-3xl p-5 border border-gray-100">

        <p class="text-xs text-gray-400 mb-2">
            DONE
        </p>

        <h1 class="text-3xl font-extrabold text-green-600">

            {{ $totalDone }}

        </h1>

    </div>

</div>

<!-- LIST -->
<div class="space-y-4">

    <!-- FILTER -->
    <div class="bg-white rounded-3xl p-6 border border-gray-100 mb-6">

        <form method="GET" action="/keuangan/dashboard">

            <div class="grid grid-cols-1 xl:grid-cols-2 gap-5">

                <div>

                    <h2 class="text-lg font-bold text-gray-800">
                        Filter Data
                    </h2>

                    <p class="text-sm text-gray-400">
                        Cari transaksi berdasarkan kode transaksi, nama, kategori, keterangan, tanggal dan waktu
                    </p>

                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 w-full lg:w-auto">

                    <div class="relative">

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Pencarian"
                            class="w-full border border-gray-200 rounded-2xl pl-10 pr-4 py-3">

                        <span class="absolute left-4 top-3.5 text-gray-400">
                            🔍
                        </span>

                    </div>

                    <input
                        type="datetime-local"
                        name="dari"
                        value="{{ request('dari') }}"
                        onchange="this.form.submit()"
                        class="w-full border border-gray-200 rounded-2xl px-4 py-3">

                    <input
                        type="datetime-local"
                        name="sampai"
                        value="{{ request('sampai') }}"
                        onchange="this.form.submit()"
                        class="w-full border border-gray-200 rounded-2xl px-4 py-3">
                        
                </div>

            </div>

        </form>

    </div>

    @forelse($pengajuans as $pengajuan)

        <!-- CARD -->
        <div class="bg-white rounded-3xl px-5 py-4 border border-gray-100 hover:shadow-lg transition">

            <div class="flex items-center justify-between gap-6">

                <!-- LEFT -->
                <div class="flex-1">

                    <!-- TOP -->
                    <div class="flex items-center gap-3 mb-2">

                        <span class="bg-black text-white text-[10px] px-3 py-1 rounded-full">

                            FL{{ str_pad($pengajuan->id, 4, '0', STR_PAD_LEFT) }}

                        </span>

                        <!-- JADWAL PENGAJUAN-->
                        <p class="text-gray-400 text-xs">

                            {{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d M Y H:i') }}

                        </p>

                        <!-- KATEGORI -->
                        @if($pengajuan->kategori == 'Reimburse/Claim')

                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-[10px] font-bold">
                                REIMBURSE/CLAIM
                            </span>

                        @elseif($pengajuan->kategori == 'Hutang Supplier')

                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-[10px] font-bold">
                                HUTANG SUPPLIER
                            </span>

                        @elseif($pengajuan->kategori == 'Uang Muka')

                            <span class="bg-amber-100 text-amber-700 px-3 py-1 rounded-full text-[10px] font-bold">
                                UANG MUKA
                            </span>

                        @elseif($pengajuan->kategori == 'Deklarasi Uang Muka')

                            <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-[10px] font-bold">
                                DEKLARASI UANG MUKA
                            </span>

                        @endif

                    </div>

                    <!-- NOMINAL -->
                    <h1 class="text-xl font-extrabold text-gray-900 mb-1">

                        RP {{ number_format($pengajuan->nominal, 0, ',', '.') }}

                    </h1>

                    <!-- NAME -->
                    <p class="text-sm font-semibold text-gray-700">

                        {{ $pengajuan->dibayarkan }}

                    </p>

                    <!-- DESC -->
                    <p class="text-xs text-gray-400 uppercase mt-1 line-clamp-1">

                        {{ $pengajuan->keterangan }}

                    </p>

                </div>

                <!-- RIGHT -->
                <div class="flex flex-col items-end gap-2">

                    <!-- STATUS -->
                    @if($pengajuan->status == 'done')

                        <span class="text-green-600 font-bold text-xs">
                            DONE
                        </span>

                    @elseif($pengajuan->status == 'approve_and_process')

                        <span class="text-blue-600 font-bold text-xs">
                            APPROVE & PROCESS
                        </span>

                    @elseif($pengajuan->status == 'rejected')

                        <span class="text-red-500 font-bold text-xs">
                            REJECTED
                        </span>

                    @else

                        <span class="text-yellow-500 font-bold text-xs">
                            PENDING
                        </span>

                    @endif

                    <!-- FILE -->
                    <a href="{{ asset('berkas/' . $pengajuan->berkas) }}"
                       target="_blank"
                       class="border border-gray-300 px-4 py-2 rounded-xl text-xs font-semibold hover:bg-gray-100 transition">

                        📄 Berkas

                    </a>

                </div>

            </div>

        </div>

    @empty

        <!-- EMPTY -->
        <div class="bg-white rounded-3xl p-10 text-center">

            <h1 class="text-2xl font-bold text-gray-700 mb-2">
                Tidak Ada Pengajuan
            </h1>

            <p class="text-gray-400">
                Belum ada data pengajuan masuk
            </p>

        </div>

    @endforelse

    <div class="mt-6">
        {{ $pengajuans->links() }}
    </div>

</div>

@endsection