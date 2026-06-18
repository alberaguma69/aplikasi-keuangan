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

    <div class="bg-white rounded-3xl border border-gray-200 p-6 hover:shadow-lg transition">

        <div class="flex items-center justify-between gap-8">

            <!-- INFO -->
            <div class="w-44 shrink-0">

                <div class="flex flex-wrap items-center gap-2 mb-3">

                    <span class="bg-[#101827] text-white text-[10px] px-3 py-1 rounded-full font-bold">
                        FL-{{ str_pad($pengajuan->id, 3, '0', STR_PAD_LEFT) }}
                    </span>

                    @if($pengajuan->kategori == 'Reimburse/Claim')

                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-[10px] font-bold">
                            REIMBURSE / CLAIM
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

                <p class="text-[10px] text-gray-400 uppercase font-semibold">
                    Tanggal Pengajuan
                </p>

                <p class="text-sm font-semibold text-gray-700 mt-1">
                    {{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d M Y H:i') }}
                </p>

            </div>

            <!-- PEMOHON -->
            <div class="flex items-center gap-3 w-52 shrink-0">

                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center">
                    👤
                </div>

                <div>

                    <p class="text-[10px] text-gray-400 uppercase font-semibold">
                        Pemohon
                    </p>

                    <h3 class="font-bold text-lg text-gray-900">
                        {{ $pengajuan->user->name }}
                    </h3>

                </div>

            </div>

            <!-- DIBAYARKAN -->
            <div class="flex items-center gap-3 w-52 shrink-0">

                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center">
                    👤
                </div>

                <div>

                    <p class="text-[10px] text-gray-400 uppercase font-semibold">
                        Dibayarkan Kepada
                    </p>

                    <h3 class="font-bold text-lg text-gray-900">
                        {{ $pengajuan->dibayarkan }}
                    </h3>

                </div>

            </div>

            <!-- KETERANGAN -->
            <div>

                <p class="text-[10px] text-gray-400 uppercase font-semibold mb-1">
                    Keterangan
                </p>

                <p class="text-base text-gray-700">
                    {{ $pengajuan->keterangan }}
                </p>

            </div>

            <!-- NOMINAL -->
            <div>

                @if($pengajuan->kategori == 'Deklarasi Uang Muka')

                    <div class="space-y-2">

                        <div>

                            <p class="text-[10px] text-gray-400 uppercase font-semibold">
                                Uang Muka Awal
                            </p>

                            <p class="text-sm font-bold text-gray-800">
                                Rp {{ number_format($pengajuan->uang_muka_awal,0,',','.') }}
                            </p>

                        </div>

                        <div>

                            <p class="text-[10px] text-purple-500 uppercase font-semibold">
                                Nominal Deklarasi
                            </p>

                            <p class="text-lg font-bold text-purple-600">
                                Rp {{ number_format($pengajuan->nominal,0,',','.') }}
                            </p>

                        </div>

                    </div>

                @else

                    <p class="text-[10px] text-gray-400 uppercase font-semibold mb-1">
                        Nominal
                    </p>

                    <p class="text-xl font-bold text-indigo-600">
                        Rp {{ number_format($pengajuan->nominal,0,',','.') }}
                    </p>

                @endif

            </div>

            <!-- STATUS -->
            <div class="w-36 flex flex-col gap-5">

                @if($pengajuan->status == 'done')

                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold w-fit">
                        DONE
                    </span>

                @elseif($pengajuan->status == 'approve_and_process')

                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold w-fit">
                        APPROVE & PROCESS
                    </span>

                @elseif($pengajuan->status == 'rejected')

                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold w-fit">
                        REJECTED
                    </span>

                @else

                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold w-fit">
                        PENDING
                    </span>

                @endif

                <a
                href="{{ asset('storage/berkas/'.$pengajuan->berkas) }}"
                target="_blank"
                class="text-sm font-semibold text-indigo-600 hover:text-indigo-800">

                    📎 Lihat Berkas

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