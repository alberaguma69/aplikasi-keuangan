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

    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

        <div>

            <h2 class="text-2xl font-bold text-gray-900">
                Filter Data
            </h2>

            <p class="text-sm text-gray-400 mt-1">
                Cari permohonan berdasarkan FL, jurnal, atau nama pemohon
            </p>

        </div>

        <form method="GET" class="w-full lg:w-auto">

            <div class="relative">

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Pencarian"
                    onchange="this.form.submit()"
                    class="w-full lg:w-80 border border-gray-200 rounded-2xl pl-12 pr-4 py-4 text-gray-700 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">

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

        <div class="bg-white rounded-3xl border border-gray-200 p-6 hover:shadow-lg transition">

            <!-- HEADER -->
            <div class="flex items-center justify-between mb-6">

                <div class="flex items-center gap-3">

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

                    @elseif($pengajuan->kategori == 'Deklarasi Uang Muka')

                        <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-[10px] font-bold">
                            DEKLARASI UANG MUKA
                        </span>

                    @endif

                </div>

                <!-- UPDATE -->
                <div x-data="{ open: false }">

                    <!-- BUTTON -->
                    <button
                        type="button"
                        @click="open = true"
                        class="bg-indigo-50 hover:bg-indigo-100 text-indigo-600 font-bold px-5 py-2 rounded-xl transition text-sm">

                        UPDATE

                    </button>

                    <!-- MODAL -->
                    <div
                        x-show="open"
                        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">

                        <!-- CARD -->
                        <div
                            @click.away="open = false"
                            class="bg-white rounded-3xl w-full max-w-md p-6 shadow-2xl">

                            <!-- HEADER -->
                            <div class="flex items-center justify-between mb-6">

                                <div>

                                    <h2 class="text-xl font-bold text-gray-900">
                                        Update Status
                                    </h2>

                                    <p class="text-sm text-gray-400">
                                        FL{{ str_pad($pengajuan->id, 4, '0', STR_PAD_LEFT) }}
                                    </p>

                                </div>

                                <button
                                    type="button"
                                    @click="open = false"
                                    class="text-gray-400 hover:text-gray-600 text-xl">

                                    ✕

                                </button>

                            </div>

                            <!-- FORM -->
                            <form
                                action="/keuangan/update-status/{{ $pengajuan->id }}"
                                method="POST"
                                x-data="{ status:'' }">

                                @csrf

                                <!-- STATUS -->
                                <div class="mb-5">

                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Status
                                    </label>

                                    <div class="relative">

                                        <select
                                            x-model="status"
                                            name="status"
                                            class="w-full appearance-none border border-gray-300 rounded-2xl px-4 py-3 pr-12 bg-white">

                                            <option value="">Pilih Status</option>
                                            <option value="pending">Pending</option>
                                            <option value="approve_and_process">Approve & Process</option>
                                            <option value="rejected">Rejected</option>

                                        </select>

                                        <div class="absolute inset-y-0 right-5 flex items-center pointer-events-none">

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="w-4 h-4 text-gray-500"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor">

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M19 9l-7 7-7-7"/>

                                            </svg>

                                        </div>

                                    </div>

                                </div>

                                <!-- APPROVE -->
                                <div
                                    x-show="status === 'approve_and_process'"
                                    x-transition
                                    class="space-y-4 mb-5">

                                    <div>

                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Jadwal Pencairan
                                        </label>

                                        <input
                                            type="datetime-local"
                                            name="jadwal_pencairan"
                                            class="w-full border border-gray-300 rounded-2xl px-4 py-3">

                                    </div>

                                    <div>

                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Nomor Jurnal
                                        </label>

                                        <input
                                            type="text"
                                            name="nomor_jurnal"
                                            placeholder="JRN000001"
                                            class="w-full border border-gray-300 rounded-2xl px-4 py-3">

                                    </div>

                                </div>

                                <!-- REJECT -->
                                <div
                                    x-show="status === 'rejected'"
                                    x-transition
                                    class="mb-5">

                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Alasan Penolakan
                                    </label>

                                    <textarea
                                        name="alasan_reject"
                                        rows="4"
                                        class="w-full border border-gray-300 rounded-2xl px-4 py-3"
                                        placeholder="Masukkan alasan penolakan"></textarea>

                                </div>

                                <!-- FOOTER -->
                                <div class="flex justify-end gap-3">

                                    <button
                                        type="button"
                                        @click="open = false"
                                        class="px-5 py-3 rounded-2xl bg-gray-100 hover:bg-gray-200 font-semibold">

                                        Batal

                                    </button>

                                    <button
                                        type="submit"
                                        class="px-5 py-3 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold">

                                        Simpan

                                    </button>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

            <!-- CONTENT -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 items-center">

                <!-- PEMOHON -->
                <div>

                    <p class="text-xs font-bold text-gray-400 uppercase mb-3">
                        Pemohon
                    </p>

                    <div class="flex items-center gap-4">

                        <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-2xl">
                            👤
                        </div>

                        <div>

                            <h3 class="font-bold text-lg text-gray-900">
                                {{ strtoupper($pengajuan->dibayarkan) }}
                            </h3>

                        </div>

                    </div>

                </div>

                <!-- KETERANGAN -->
                <div>

                    <p class="text-xs font-bold text-gray-400 uppercase mb-3">
                        Keterangan
                    </p>

                    <div class="flex items-center gap-4">

                        <div class="w-12 h-12 rounded-xl bg-green-50 flex items-center justify-center text-2xl">
                            📄
                        </div>

                        <div>

                            <h3 class="font-medium text-sm text-gray-700 leading-relaxed">
                                {{ $pengajuan->keterangan }}
                            </h3>

                        </div>

                    </div>

                </div>

                <!-- NOMINAL -->
                <div>

                    @if($pengajuan->kategori == 'Deklarasi Uang Muka')

                        <p class="text-xs font-bold text-gray-400 uppercase mb-2">
                            Uang Muka Awal
                        </p>

                        <h3 class="text-lg font-bold text-gray-800 mb-3">
                            Rp {{ number_format($pengajuan->uang_muka_awal,0,',','.') }}
                        </h3>

                        <p class="text-xs font-bold text-purple-500 uppercase mb-2">
                            Nominal Deklarasi
                        </p>

                        <h2 class="text-3xl font-extrabold text-purple-600">
                            Rp {{ number_format($pengajuan->nominal,0,',','.') }}
                        </h2>

                    @else

                        <p class="text-xs font-bold text-gray-400 uppercase mb-2">
                            Nominal
                        </p>

                        <h2 class="text-2xl font-bold text-blue-600">
                            Rp {{ number_format($pengajuan->nominal,0,',','.') }}
                        </h2>

                    @endif

                </div>

                <!-- BERKAS -->
                <div>

                    <p class="text-[11px] font-semibold text-gray-400 uppercase mb-2 tracking-wide">
                        Dokumen
                    </p>

                    <a href="{{ asset('berkas/' . $pengajuan->berkas) }}"
                    target="_blank"
                    class="inline-flex items-center gap-2 bg-gray-50 hover:bg-gray-100 border border-gray-200 px-3 py-2 rounded-xl transition">

                        <span class="text-sm">
                            📎
                        </span>

                        <span class="text-xs font-semibold text-gray-700">
                            Lihat Berkas
                        </span>

                    </a>

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
