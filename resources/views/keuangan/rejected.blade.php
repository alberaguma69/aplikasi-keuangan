@extends('layouts.keuangan')

@section('title', 'Rejected')

@section('content')

<!-- HEADER -->
<div class="flex items-center justify-between mb-8">

    <div>

        <h1 class="text-3xl font-extrabold text-red-600">
            DATA REJECTED
        </h1>

        <p class="text-sm text-gray-400 mt-1">
            Daftar pengajuan yang ditolak
        </p>

    </div>

    @include('keuangan.includes.topbar')

</div>

<!-- FILTER -->
<div class="bg-white rounded-3xl p-6 border border-gray-100 mb-6">

    <form method="GET" action="/keuangan/rejected">

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
                        class="w-full border border-gray-200 rounded-2xl pl-10 pr-4 py-3">

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
                    class="w-full border border-gray-200 rounded-2xl px-4 py-3">

                <!-- SAMPAI -->
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

<div
    x-data="{
        selected: [],
        toggleAll(event) {
            let checked = event.target.checked;

            document.querySelectorAll('.row-checkbox')
                .forEach(cb => {
                    cb.checked = checked;

                    if (checked) {
                        if (!this.selected.includes(cb.value)) {
                            this.selected.push(cb.value);
                        }
                    } else {
                        this.selected = [];
                    }
                });
        }
    }">

<div
    x-show="selected.length > 0"
    x-transition
    class="mb-4 bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

    <form
        x-ref="restoreForm"
        action="/keuangan/rejected/bulk-restore"
        method="POST">

        @csrf

        <template x-for="id in selected">
            <input
                type="hidden"
                name="ids[]"
                :value="id">
        </template>

    </form>

    <form
        x-ref="deleteForm"
        action="/keuangan/rejected/bulk-delete"
        method="POST">

        @csrf
        @method('DELETE')

        <template x-for="id in selected">
            <input
                type="hidden"
                name="ids[]"
                :value="id">
        </template>

    </form>

    <div class="flex items-center">

        <div class="px-5 py-3 text-blue-600 font-semibold">

            <span x-text="selected.length"></span> dipilih

        </div>

        <button
            type="button"
            @click="$refs.restoreForm.submit()"
            class="px-5 py-3 border-l">

            ↩️ Kembalikan

        </button>

        <button
            type="button"
            @click="$refs.deleteForm.submit()"
            class="px-5 py-3 border-l">

            🗑️ Hapus

        </button>

    </div>

</div>

<!-- TABLE -->
<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="bg-gray-50">

                 <tr class="bg-gray-50 border-b border-gray-200">
                    
                    <th class="px-4">

                        <input
                            type="checkbox"
                            @change="toggleAll($event)">

                    </th>

                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">
                        ID
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">
                        Kategori
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">
                        Pemohon
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">
                        Uang Muka Awal
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">
                        Nominal
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">
                        Tanggal Pengajuan
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">
                        Keterangan
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">
                        Dokumen Jurnal
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">
                        Alasan Ditolak
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($pengajuans as $pengajuan)

                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition">

                        <!-- CHECKBOX -->
                        <td class="px-4">

                            <input
                                type="checkbox"
                                value="{{ $pengajuan->id }}"
                                class="row-checkbox"
                                @change="
                                    if($event.target.checked){
                                        selected.push($event.target.value)
                                    }else{
                                        selected = selected.filter(id => id != $event.target.value)
                                    }
                                ">

                        </td>

                        <!-- ID -->
                        <td class="px-6 py-4">

                            FL{{ str_pad($pengajuan->id, 4, '0', STR_PAD_LEFT) }}

                        </td>

                        <!-- DIBAYARKAN -->
                        <td class="px-6 py-4">

                            {{ $pengajuan->dibayarkan }}

                        </td>

                        <!-- KATEGORI -->
                        <td class="px-6 py-5">

                            @if($pengajuan->kategori == 'Reimburse/Claim')

                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">
                                    Reimburse/Claim
                                </span>

                            @elseif($pengajuan->kategori == 'Hutang Supplier')

                                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold">
                                    Hutang Supplier
                                </span>
                            

                            @elseif($pengajuan->kategori == 'Uang Muka')

                                <span class="bg-amber-100 text-amber-700 px-3 py-1 rounded-full text-xs font-bold">
                                    Uang Muka
                                </span>

                            @elseif(
                                $pengajuan->kategori == 'Deklarasi Uang Muka'
                            )

                                <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-bold">
                                    Deklarasi Uang Muka
                                </span>

                            @endif

                        </td>

                        <!-- KETERANGAN -->
                        <td class="px-6 py-4">

                            {{ $pengajuan->keterangan }}

                        </td>

                        <!-- UANG MUKA -->
                        <td>
                        @if($pengajuan->kategori == 'Deklarasi Uang Muka')
                            Rp {{ number_format($pengajuan->uang_muka_awal,0,',','.') }}
                        @else
                            -
                        @endif
                        </td>

                        <!-- NOMINAL -->
                        <td class="px-6 py-4">

                            Rp {{ number_format($pengajuan->nominal, 0, ',', '.') }}

                        </td>

                        <!-- TANGGAL PENGAJUAN -->
                        <td class="px-6 py-4">

                            {{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d M Y H:i') }}

                        </td>

                        <!-- JURNAL LAMA -->
                        <td class="px-6 py-5">

                            @if($pengajuan->berkas)

                                <a
                                    href="{{ asset('storage/'.$pengajuan->berkas) }}"
                                    target="_blank"
                                    class="bg-blue-100 text-blue-600 px-4 py-2 rounded-xl text-xs font-bold hover:bg-blue-200 transition">

                                    📄 Lihat

                                </a>

                            @else

                                <span
                                    class="bg-gray-100 text-gray-500 px-4 py-2 rounded-xl text-xs font-bold">

                                    Tidak Ada

                                </span>

                            @endif

                        </td>

                        <!-- ALASAN REJECT -->
                        <td class="px-6 py-4 text-red-500">

                            {{ $pengajuan->alasan_reject ?? '-' }}

                        </td>

                    </tr>

                @empty

                <tr>
                    <td colspan="9">
                        <div class="flex justify-center items-center py-16 text-gray-400">
                            Tidak ada data rejected
                        </div>
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

<div class="mt-6">

    {{ $pengajuans->links() }}

</div>

@endsection
