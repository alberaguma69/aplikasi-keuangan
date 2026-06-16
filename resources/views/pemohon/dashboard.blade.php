@extends('layouts.pemohon')

@section('title', 'Status Saya')

@section('content')

<!-- HEADER -->
<div class="mb-8 flex items-center justify-between">

    <!-- LEFT -->
    <div>

        <h1 class="text-3xl font-extrabold text-gray-900">
            STATUS SAYA
        </h1>

        <p class="text-gray-500 text-sm mt-2">
            Daftar seluruh pengajuan dana anda
        </p>

    </div>

    <!-- RIGHT -->
    <div class="flex items-center gap-4">

        <!-- BUTTON -->
        <a href="/pengajuan/create"
           class="bg-indigo-700 hover:bg-indigo-800 transition text-white px-5 py-3 rounded-2xl text-sm font-semibold">

            + Pengajuan

        </a>

        @include('pemohon.includes.topbar')

    </div>

</div>

<!-- FILTER -->
<div class="bg-white rounded-3xl p-6 border border-gray-100 mb-6">

    <form method="GET" action="/dashboard">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

            <!-- JUDUL -->
            <div>

                <h2 class="text-lg font-bold text-gray-800">
                    Filter Data
                </h2>

                <p class="text-sm text-gray-400">
                    Cari transaksi berdasarkan kode transaksi, nama,
                    kategori, keterangan, tanggal dan waktu
                </p>

            </div>

            <!-- FILTER FORM -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 w-full lg:w-auto">

                <!-- SEARCH -->
                <div class="relative">

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Pencarian"
                        class="w-full border border-gray-200 rounded-2xl pl-10 pr-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">

                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                        🔍
                    </span>

                </div>

                <!-- DARI -->
                <input
                    type="datetime-local"
                    name="dari"
                    value="{{ request('dari') }}"
                    onchange="this.form.submit()"
                    class="w-full border border-gray-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">

                <!-- SAMPAI -->
                <input
                    type="datetime-local"
                    name="sampai"
                    value="{{ request('sampai') }}"
                    onchange="this.form.submit()"
                    class="w-full border border-gray-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">

            </div>

        </div>

    </form>

</div>

<!-- GRID -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">

    @forelse($pengajuans as $pengajuan)

        <!-- CARD -->
        <div class="bg-white rounded-3xl p-5 hover:shadow-lg transition">

            <!-- TOP -->
            <div class="flex items-center justify-between mb-5">

                <div>

                    <span class="bg-black text-white text-[10px] px-3 py-1 rounded-full">
                        FL{{ str_pad($pengajuan->id, 4, '0', STR_PAD_LEFT) }}
                    </span>

                    <p class="text-gray-400 text-xs mt-2">
                        {{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d M Y H:i') }}
                    </p>

                </div>

                <!-- STATUS -->
                @if($pengajuan->status == 'pending')

                    <span class="bg-yellow-50 text-yellow-600 px-3 py-1 rounded-xl text-[11px] font-semibold">
                        PENDING
                    </span>

                @elseif($pengajuan->status == 'approve_and_process')

                    <span class="bg-blue-50 text-blue-600 px-3 py-1 rounded-xl text-[11px] font-semibold">
                        APPROVE & PROCESS
                    </span>

                @elseif($pengajuan->status == 'done')

                    <span class="bg-green-50 text-green-600 px-3 py-1 rounded-xl text-[11px] font-semibold">
                        DONE
                    </span>

                @elseif($pengajuan->status == 'rejected')

                    <span class="bg-red-50 text-red-600 px-3 py-1 rounded-xl text-[11px] font-semibold">
                        REJECTED
                    </span>

                @endif
                
            </div>

            <!-- Kategori -->
            <div class="mb-3">

            @if($pengajuan->kategori == 'Reimburse/Claim')

                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-xl text-xs font-semibold">
                    Reimburse / Claim
                </span>

            @elseif($pengajuan->kategori == 'Hutang Supplier')

                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-xl text-xs font-semibold">
                    Hutang Supplier
                </span>

            @elseif($pengajuan->kategori == 'Uang Muka')

                <span class="bg-amber-100 text-amber-700 px-3 py-1 rounded-xl text-xs font-semibold">
                    Uang Muka
                </span>

            @elseif($pengajuan->kategori == 'Deklarasi Uang Muka')

                <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-xl text-xs font-semibold">
                    Deklarasi Uang Muka
                </span>

            @endif

        </div>

        <!-- DETAIL PENGAJUAN -->

        @if($pengajuan->kategori == 'Deklarasi Uang Muka')

            <div class="grid grid-cols-2 gap-3 mt-4">

                <div class="bg-gray-50 rounded-2xl p-4">

                    <p class="text-xs text-gray-500">
                        Uang Muka Awal
                    </p>

                    <p class="text-xl font-bold text-gray-800 mt-1">
                        Rp {{ number_format($pengajuan->uang_muka_awal,0,',','.') }}
                    </p>

                </div>

                <div class="bg-indigo-50 rounded-2xl p-4">

                    <p class="text-xs text-indigo-500">
                        Nominal Realisasi
                    </p>

                    <p class="text-xl font-bold text-indigo-700 mt-1">
                        Rp {{ number_format($pengajuan->nominal,0,',','.') }}
                    </p>

                </div>

            </div>

        @else

            <!-- NOMINAL -->
            <div class="mt-4">

                <div class="bg-indigo-50 rounded-2xl p-4">

                    <p class="text-xs text-indigo-500 mb-2">
                        Nominal Pengajuan
                    </p>

                    <h2 class="text-xl font-bold text-indigo-700">
                        Rp {{ number_format($pengajuan->nominal,0,',','.') }}
                    </h2>

                </div>

            </div>

        @endif

        <!-- DIBAYARKAN -->
        <div class="mt-3">

            <div class="bg-gray-50 rounded-2xl p-4 flex items-center gap-4">

                <div class="w-12 h-12 rounded-xl bg-indigo-100 flex items-center justify-center text-xl">
                    👤
                </div>

                <div>

                    <p class="text-xs text-gray-500 uppercase">
                        Dibayarkan Kepada
                    </p>

                    <p class="font-semibold text-gray-800">
                        {{ $pengajuan->dibayarkan }}
                    </p>

                </div>

            </div>

        </div>

        <!-- KETERANGAN -->
        <div class="mt-3">

            <div class="bg-gray-50 rounded-2xl p-4 flex items-start gap-4">

                <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center text-xl">
                    📄
                </div>

                <div>

                    <p class="text-xs text-gray-500 uppercase">
                        Keterangan
                    </p>

                    <p class="text-sm text-gray-700 leading-relaxed">
                        {{ $pengajuan->keterangan }}
                    </p>

                </div>

            </div>

        </div>

        <!-- ALASAN REJECT -->
       @if($pengajuan->status == 'rejected' && $pengajuan->alasan_reject)

        <div class="mt-3">

            <div class="bg-red-50 border border-red-200 rounded-2xl p-4 flex items-start gap-4">

                <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center text-xl">
                    ❌
                </div>

                <div>

                    <p class="text-xs font-bold text-red-600 uppercase mb-1">
                        Alasan Penolakan
                    </p>

                    <p class="text-sm text-red-700 leading-relaxed">
                        {{ $pengajuan->alasan_reject }}
                    </p>

                </div>

            </div>

        </div>

        @endif

        <!-- FOOT -->
        <div class="mt-8">

            <!-- JADWAL -->
            <div class="flex items-center justify-between mb-4">

                <!-- LEFT -->
                <div class="flex items-center gap-2">

                    <span class="text-lg">📅</span>

                    <p class="text-gray-400 text-xs font-medium">
                        JADWAL
                    </p>

                </div>

                <!-- RIGHT -->
                <p class="font-medium text-sm text-gray-700">

                    @if($pengajuan->jadwal_pencairan)

                        {{ \Carbon\Carbon::parse($pengajuan->jadwal_pencairan)->format('d M Y H:i') }}

                    @else

                        Menunggu Jadwal

                    @endif

                </p>

            </div>

            <!-- BUTTON -->
            <a href="{{ asset('berkas/' . $pengajuan->berkas) }}"
                target="_blank"
                class="w-full flex items-center justify-center gap-2 border border-gray-300 px-4 py-3 text-sm rounded-xl hover:bg-gray-100 transition font-semibold">

                <span class="text-lg">📄</span>

                LIHAT BERKAS

            </a>

            @if($pengajuan->status == 'rejected')

                <a href="/pengajuan/edit/{{ $pengajuan->id }}"
                class="w-full mt-3 flex items-center justify-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-3 text-sm rounded-xl transition font-semibold">

                    ✏️ EDIT DOKUMEN

                </a>

            @endif

        </div>

    </div>

@empty

    <!-- EMPTY -->
    <div class="col-span-3">

        <div class="bg-white rounded-3xl p-10 text-center">

            <h1 class="text-2xl font-bold text-gray-700 mb-2">
                Belum Ada Pengajuan
            </h1>

            <p class="text-gray-400 mb-6">
                Silahkan buat pengajuan dana terlebih dahulu
            </p>

            <a href="/pengajuan/create"
                class="bg-indigo-700 hover:bg-indigo-800 transition text-white px-5 py-3 rounded-2xl text-sm font-semibold">

                Buat Pengajuan

            </a>

        </div>

    </div>

@endforelse

    <!-- PAGINATION -->
    <div class="px-6 py-4 border-t border-gray-100 flex justify-start">

        {{ $pengajuans->links() }}

    </div>

</div>

@endsection