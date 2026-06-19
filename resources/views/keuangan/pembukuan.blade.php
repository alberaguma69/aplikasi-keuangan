@extends('layouts.keuangan')

@section('title', 'Pembukuan')

@section('content')

<!-- HEADER -->
<div class="flex items-center justify-between mb-8">

    <div>

        <h1 class="text-3xl font-extrabold text-gray-900">
            PEMBUKUAN
        </h1>

        <p class="text-sm text-gray-400 mt-1">
            Riwayat transaksi pengeluaran dana
        </p>

    </div>

    @include('keuangan.includes.topbar')

</div>

<!-- FILTER -->
<div class="bg-white rounded-3xl p-6 border border-gray-100 mb-6">

    <form method="GET" action="/keuangan/pembukuan">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

            <!-- JUDUL -->
            <div>

                <h2 class="text-lg font-bold text-gray-800">
                    Filter Data
                </h2>

                <p class="text-sm text-gray-400">
                    Cari transaksi berdasarkan kode transaksi, nama, kategori,
                    keterangan, tanggal dan waktu
                </p>

            </div>

            <!-- FORM FILTER -->
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

<!-- FUNCTION SELECT -->
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

<!-- TOMBOL PILIH -->
<div
    x-show="selected.length > 0"
    x-transition
    class="mb-4 bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

    <div class="flex items-center">

        <div class="px-5 py-3 text-red-600 font-semibold whitespace-nowrap">

            <span x-text="selected.length"></span>

            <span class="ml-1">
                dipilih
            </span>

        </div>

        <button
            type="button"
            @click="$refs.deleteForm.submit()"
            class="px-5 py-3 border-l">

            🗑️ Hapus

        </button>

    </div>

</div>

<!-- FORM DELETE -->
<form
    x-ref="deleteForm"
    action="/keuangan/pembukuan/bulk-delete"
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

<!-- TABLE -->
<div class="bg-white rounded-3xl border border-gray-100 overflow-hidden">

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="bg-gray-50 border-b border-gray-100">

                <tr class="bg-gray-50 border-b border-gray-200">

                    <th class="px-4 py-4 w-10">

                        <input
                            type="checkbox"
                            @change="toggleAll($event)">

                    </th>

                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">
                        ID / Jurnal
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">
                        Pemohon
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">
                        Penerima
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">
                        Kategori
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase min-w-[350px]">
                        Keterangan
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">
                        Uang Muka Awal
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">
                        Nominal
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">
                        Tanggal Pencairan
                    </th>                 

                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">
                        Status
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">
                        Berkas Transaksi
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">
                        Jurnal Voucher
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($pengajuans as $pengajuan)

                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition">

                        <td class="px-4 py-5">

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
                        <td class="px-6 py-5">

                            <div class="flex items-center justify-between">

                                <div>

                                    <!-- KODE FL -->
                                    <h1 class="font-bold text-lg text-gray-900">
                                        FL{{ str_pad($pengajuan->id, 4, '0', STR_PAD_LEFT) }}
                                    </h1>

                                    <!-- NOMOR JURNAL -->
                                    <p class="text-indigo-500 text-xs mt-1">
                                        {{ $pengajuan->nomor_jurnal ?? '-' }}
                                    </p>

                                </div>

                            </div>

                        </td>

                        <!-- Dibayarkan -->
                        <td class="px-6 py-5 font-semibold text-gray-800 whitespace-nowrap">

                            {{ $pengajuan->user->name }}

                        </td>

                        <!-- Dibayarkan -->
                        <td class="px-6 py-5 font-semibold text-gray-800 whitespace-nowrap">

                            {{ $pengajuan->dibayarkan }}

                        </td>

                        <!-- KATEGORI -->
                        <td class="px-6 py-5 whitespace-nowrap">

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
                        <td class="px-6 py-5 font-semibold text-gray-800 min-w-[350px]">

                            {{ $pengajuan->keterangan }}

                        </td>

                        <!-- UANG MUKA -->
                        <td class="px-6 py-5 font-bold text-gray-900 whitespace-nowrap">

                            @if($pengajuan->kategori == 'Deklarasi Uang Muka')
                                Rp {{ number_format($pengajuan->uang_muka_awal,0,',','.') }}
                            @else
                                -
                            @endif

                        </td>

                        <!-- NOMINAL -->
                        <td class="px-6 py-5 font-bold text-gray-900 whitespace-nowrap">

                            RP {{ number_format($pengajuan->nominal,0,',','.') }}

                        </td>

                        <!-- TANGGAL PENCAIRAN -->
                        <td class="px-6 py-5 whitespace-nowrap">

                            @if($pengajuan->jadwal_pencairan)

                                <div class="text-sm font-medium text-gray-800">

                                    {{ \Carbon\Carbon::parse($pengajuan->jadwal_pencairan)->format('d M Y') }}

                                </div>

                                <div class="text-xs text-gray-400">

                                    {{ \Carbon\Carbon::parse($pengajuan->jadwal_pencairan)->format('H:i') }} WIB

                                </div>

                            @else

                                <div class="text-sm text-gray-400">

                                    Belum Dijadwalkan

                                </div>

                            @endif

                        </td>

                        <!-- STATUS -->
                        <td class="px-6 py-5 whitespace-nowrap">

                            @if($pengajuan->status == 'pending')

                                <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">
                                    PENDING
                                </span>

                            @elseif($pengajuan->status == 'approve_and_process')

                                <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold whitespace-nowrap">
                                    APPROVE & PROCESS
                                </span>

                            @elseif($pengajuan->status == 'done')

                                <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                                    DONE
                                </span>

                            @elseif($pengajuan->status == 'rejected')

                                <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">
                                    REJECTED
                                </span>

                            @endif

                        </td>

                        <!-- JURNAL LAMA -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a
                                href="{{ asset('storage/berkas/'.$pengajuan->berkas) }}"
                                target="_blank"
                                class="inline-flex items-center px-3 py-2 bg-blue-100 text-blue-700 rounded-xl text-xs font-semibold">

                                📄 Lihat

                            </a>
                        </td>

                        <!-- JURNAL BARU-->
                        <td class="px-6 py-5 whitespace-nowrap">

                            {{-- JIKA SUDAH ADA FILE JURNAL --}}
                            @if($pengajuan->dokumen_jurnal_baru)

                                <a
                                    href="{{ asset('storage/jurnal/'.$pengajuan->dokumen_jurnal_baru) }}"
                                    target="_blank"
                                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-xl text-xs font-bold">

                                    LIHAT

                                </a>

                            {{-- JIKA BELUM ADA FILE DAN STATUS MASIH BISA UPLOAD --}}
                            @elseif(
                                $pengajuan->status == 'pending' ||
                                $pengajuan->status == 'approve_and_process'
                            )

                                <div x-data="{ openUpload:false }">

                                    <button
                                        @click="openUpload=true"
                                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl text-xs font-bold">

                                        UPLOAD

                                    </button>

                                    <!-- MODAL -->
                                    <div
                                        x-show="openUpload"
                                        x-cloak
                                        class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">

                                        <div
                                            @click.away="openUpload=false"
                                            class="bg-white rounded-3xl w-full max-w-lg shadow-2xl overflow-hidden">

                                            <!-- HEADER -->
                                            <div class="p-6 border-b border-gray-100">

                                                <h2 class="text-xl font-bold text-gray-900">
                                                    Upload Dokumen Jurnal
                                                </h2>

                                                <p class="text-sm text-gray-400 mt-1">
                                                    FL{{ str_pad($pengajuan->id, 4, '0', STR_PAD_LEFT) }}
                                                </p>

                                            </div>

                                            <!-- FORM -->
                                            <form
                                                action="/keuangan/upload-jurnal/{{ $pengajuan->id }}"
                                                method="POST"
                                                enctype="multipart/form-data"
                                                class="p-6"
                                                x-data="{ fileName: '' }">

                                                @csrf

                                                <!-- NOMOR JURNAL -->
                                                <div class="mb-5">

                                                    <label class="block text-sm font-semibold text-gray-600 mb-2">
                                                        Nomor Jurnal
                                                    </label>

                                                    <input
                                                        type="text"
                                                        name="nomor_jurnal"
                                                        value="{{ $pengajuan->nomor_jurnal }}"
                                                        readonly
                                                        class="w-full border border-gray-200 bg-gray-50 rounded-2xl px-4 py-3">

                                                </div>

                                                <!-- FILE -->
                                                <div class="mb-6">

                                                    <label class="block text-sm font-semibold text-gray-600 mb-2">
                                                        Dokumen Jurnal
                                                    </label>

                                                    <label
                                                        class="border-2 border-dashed border-indigo-200 rounded-3xl p-8 flex flex-col items-center justify-center cursor-pointer hover:bg-indigo-50 transition">

                                                        <div class="text-5xl mb-3">
                                                            ⬆️
                                                        </div>

                                                        <h3 class="font-bold text-gray-800">
                                                            Upload File
                                                        </h3>

                                                        <p class="text-xs text-gray-400 mt-1">
                                                            Klik untuk memilih file
                                                        </p>

                                                        <template x-if="fileName">

                                                            <div class="mt-4 bg-indigo-100 text-indigo-700 px-4 py-2 rounded-xl text-sm font-semibold">

                                                                <span x-text="fileName"></span>

                                                            </div>

                                                        </template>

                                                        <input
                                                            type="file"
                                                            name="dokumen_jurnal_baru"
                                                            accept=".pdf, .doc, .docx, .jpeg, .jpg, .png"
                                                            class="hidden"
                                                            @change="fileName = $event.target.files[0]?.name">

                                                    </label>

                                                </div>

                                                <!-- BUTTON -->
                                                <div class="flex justify-end gap-3">

                                                    <button
                                                        type="button"
                                                        @click="openUpload=false"
                                                        class="px-5 py-3 rounded-2xl bg-gray-100 hover:bg-gray-200 font-semibold">

                                                        Batal

                                                    </button>

                                                    <button
                                                        type="submit"
                                                        class="px-5 py-3 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold">

                                                        Upload

                                                    </button>

                                                </div>

                                            </form>

                                        </div>

                                    </div>

                                </div>

                            {{-- STATUS DONE TAPI BELUM ADA FILE --}}
                            @else

                                <span
                                    class="bg-gray-100 text-gray-500 px-4 py-2 rounded-xl text-xs font-bold">

                                    BELUM ADA FILE

                                </span>

                            @endif

                        </td>

                    </tr>

                @empty

                <tr>
                    <td colspan="9">
                        <div class="flex flex-col items-center justify-center py-20">

                            <div class="text-5xl mb-4">
                                📒
                            </div>

                            <h1 class="text-xl font-bold text-gray-700 mb-2">
                                Belum Ada Data Pembukuan
                            </h1>

                            <p class="text-gray-400">
                                Data transaksi akan muncul di sini
                            </p>

                        </div>
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    @if($pengajuans->hasPages())

    <div class="p-6 border-t border-gray-100">
        {{ $pengajuans->links() }}
    </div>

    @endif

</div>

@endsection

