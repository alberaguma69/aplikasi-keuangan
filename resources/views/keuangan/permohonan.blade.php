@extends('layouts.keuangan')

@section('title', 'Permohonan')

@section('content')

<!-- HEADER -->
<div class="flex items-center justify-between mb-8">

    <div>

        <h1 class="text-3xl font-extrabold text-gray-900">
            PERMOHONAN
        </h1>

        <p class="text-sm text-gray-400 mt-1">
            Daftar seluruh pengajuan dana masuk
        </p>

    </div>

    @include('keuangan.includes.topbar')

</div>

<!-- FILTER DATA -->
<div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 mb-6">

    <div class="flex items-center justify-between">

        <div>

            <h2 class="text-2xl font-bold text-gray-900">
                Filter Data
            </h2>

            <p class="text-sm text-gray-400 mt-1">
                Cari permohonan berdasarkan FL, jurnal, atau nama pemohon
            </p>

        </div>

        <form method="GET">

            <div class="relative">

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Pencarian"
                    onchange="this.form.submit()"
                    class="w-80 border border-gray-200 rounded-2xl pl-12 pr-4 py-4 text-gray-700 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">

                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-lg">
                    🔍
                </span>

            </div>

        </form>

    </div>

</div>

<!-- CARD LIST -->
<div class="space-y-5">

    @forelse($pengajuans as $pengajuan)

        <div class="bg-white rounded-3xl border border-gray-200 px-6 py-5 hover:shadow-md transition">

            <div class="flex items-center justify-between gap-4">

                <!-- LEFT -->
                <div class="flex-1 min-w-0">

                    <div class="flex items-center gap-3 mb-2">

                        <!-- ID -->
                        <span class="bg-[#101827] text-white text-[10px] px-3 py-1 rounded-full font-bold">

                            FL-{{ str_pad($pengajuan->id, 3, '0', STR_PAD_LEFT) }}

                        </span>
                        
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

                    <!-- DIBAYARKAN -->
                    <h2 class="font-bold text-lg text-gray-800 truncate">

                        {{ strtoupper($pengajuan->dibayarkan) }}

                    </h2>

                    <!-- KETERANGAN -->
                    <p class="text-gray-400 text-sm font-semibold truncate">

                        {{ strtoupper($pengajuan->keterangan) }}

                    </p>

                    <div class="flex items-center gap-4 mt-3">

                        <!-- NOMINAL -->
                        <h1 class="text-2xl font-extrabold text-blue-600">

                            Rp {{ number_format($pengajuan->nominal, 0, ',', '.') }}

                        </h1>

                        <!-- BERKAS -->
                        <a href="{{ asset('berkas/' . $pengajuan->berkas) }}"
                           target="_blank"
                           class="text-gray-400 text-sm font-bold hover:text-blue-600">

                            📎 BERKAS

                        </a>

                    </div>

                </div>

                <!-- RIGHT -->
                <div>

                    <div x-data="{ open: false }">

                        <button
                            @click="open = true"
                            class="bg-indigo-50 hover:bg-indigo-100 text-indigo-600 font-bold px-5 py-2 rounded-xl transition text-sm">

                            UPDATE

                        </button>

                        <!-- MODAL -->
                        <div
                            x-show="open"
                            x-cloak
                            class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">

                            <div
                                @click.away="open = false"
                                class="bg-white rounded-3xl p-6 w-full max-w-sm shadow-2xl">

                                <!-- HEADER -->
                                <div class="flex items-center gap-3 mb-5">

                                    <div class="w-12 h-12 rounded-2xl bg-indigo-100 flex items-center justify-center text-xl">

                                        ✏️

                                    </div>

                                    <div>

                                        <h2 class="text-xl font-bold text-gray-900">
                                            Update Status
                                        </h2>

                                        <p class="text-sm text-gray-400">
                                            FL-{{ str_pad($pengajuan->id, 3, '0', STR_PAD_LEFT) }}
                                            •
                                            {{ strtoupper($pengajuan->dibayarkan) }}
                                        </p>

                                    </div>

                                </div>

                                <form action="/keuangan/update-status/{{ $pengajuan->id }}"
                                    method="POST" x-data="{ status:'' }">

                                    @csrf
                                    
                                    <!-- STATUS -->
                                    <div class="mb-6">

                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Status
                                        </label>

                                            
                                        <div class="relative">

                                            <select
                                                x-model="status"
                                                name="status"
                                                class="w-full border border-gray-300 rounded-2xl px-5 py-4 pr-12 appearance-none focus:outline-none focus:ring-2 focus:ring-indigo-500">

                                                <option value="">Pilih Status</option>
                                                <option value="pending">Pending</option>
                                                <option value="approve_and_process">Approve & Process</option>
                                                <option value="done">Done</option>
                                                <option value="rejected">Rejected</option>

                                            </select>

                                            <!-- PANAH -->
                                            <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">

                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    class="w-5 h-5 text-gray-500"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor">

                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 9l-7 7-7-7" />

                                                </svg>

                                            </div>

                                        </div>

                                    </div>

                                    <!-- APPROVE FIELDS -->
                                    <div x-show="status === 'approve_and_process'" x-transition class="mb-6">

                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Jadwal Pencairan
                                        </label>

                                        <input
                                            type="datetime-local"
                                            name="jadwal_pencairan"
                                            class="w-full border border-gray-300 rounded-xl px-4 py-3 mb-4">

                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Nomor Jurnal
                                        </label>

                                        <input
                                            type="text"
                                            name="nomor_jurnal"
                                            placeholder="JRN000001"
                                            class="w-full border border-gray-300 rounded-xl px-4 py-3">

                                    </div>

                                    <!-- REJECT FIELDS -->
                                    <div x-show="status === 'rejected'" x-transition class="mb-6">

                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Alasan Ditolak
                                        </label>

                                        <textarea
                                            name="alasan_reject"
                                            rows="4"
                                            placeholder="Masukkan alasan penolakan..."
                                            class="w-full border border-gray-300 rounded-xl px-4 py-3"></textarea>

                                    </div>

                                    <!-- BUTTON -->
                                    <div class="flex justify-end gap-3">

                                        <button
                                            type="button"
                                            @click="open = false"
                                            class="px-5 py-3 rounded-2xl bg-gray-100 hover:bg-gray-200 font-semibold transition">

                                            Batal

                                        </button>

                                        <button
                                            type="submit"
                                            class="px-5 py-3 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold transition">

                                            Simpan

                                        </button>

                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    @empty

        <div class="bg-white rounded-3xl p-10 text-center">

            <h1 class="text-2xl font-bold text-gray-700 mb-2">
                Tidak Ada Pengajuan
            </h1>

            <p class="text-gray-400">
                Data permohonan akan muncul di sini
            </p>

        </div>

    @endforelse
    
    <!-- PAGINATION -->
    @if($pengajuans->hasPages())

        <div class="mt-6">
            {{ $pengajuans->links() }}
        </div>

    @endif

</div>

@endsection
