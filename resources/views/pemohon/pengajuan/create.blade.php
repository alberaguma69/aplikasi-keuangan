@extends('layouts.pemohon')

@section('title', 'Buat Pengajuan')

@section('content')

<!-- HEADER -->
<div class="flex items-center justify-between mb-8">

    <div>

        <h1 class="text-3xl font-extrabold text-gray-900">
            BUAT PENGAJUAN
        </h1>

        <p class="text-sm text-gray-400 mt-1">
            Silahkan isi form pengajuan dana
        </p>

    </div>

    @include('pemohon.includes.topbar')

</div>

<!-- FORM -->
<div class="max-w-3xl mx-auto">

    <!-- CARD -->
    <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">

        <form action="/pengajuan/store"
            method="POST"
            enctype="multipart/form-data"
            x-data="{ kategori: '' }">

            @csrf

            <!-- KATEGORI -->
            <div class="mb-6">

                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    Kategori Pengajuan
                </label>

                <div class="relative">

                    <select
                        name="kategori"
                        x-model="kategori"
                        required
                        class="w-full border border-gray-300 rounded-2xl px-5 py-4 pr-10 appearance-none bg-white">

                        <option value="">
                            Pilih Kategori
                        </option>

                        <option value="Reimburse/Claim">
                            Reimburse / Claim
                        </option>

                        <option value="Hutang Supplier">
                            Hutang Supplier
                        </option>

                        <option value="Uang Muka">
                            Uang Muka
                        </option>

                        <option value="Deklarasi Uang Muka">
                            Deklarasi Uang Muka
                        </option>

                    </select>

                    <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5 text-gray-500"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M19 9l-7 7-7-7" />

                        </svg>

                    </div>

                </div>

            </div>

            <!-- DIBAYARKAN -->
            <div class="mb-6">

                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    Dibayarkan Kepada / Diterima Oleh
                </label>

                <input
                    type="text"
                    name="dibayarkan"
                    required
                    class="w-full border border-gray-200 rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-indigo-500">

            </div>

            <!-- KETERANGAN -->
            <div class="mb-6">

                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    Keterangan Penggunaan Biaya
                </label>

                <textarea
                    name="keterangan"
                    required
                    class="w-full border border-gray-200 rounded-2xl px-5 py-4 h-32 resize-none focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>

            </div>

            <!-- UANG MUKA AWAL -->
            <div
                class="mb-6"
                x-show="kategori === 'Deklarasi Uang Muka'"
                x-transition>

                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    Uang Muka Awal
                </label>

                <input
                    type="number"
                    name="uang_muka_awal"
                    class="w-full border border-gray-200 rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-indigo-500">

            </div>

            <!-- NOMINAL -->
            <div class="mb-6">

                <label class="block text-sm font-semibold text-gray-700 mb-3">

                    <span x-show="kategori !== 'Deklarasi Uang Muka'">
                        Nominal Biaya
                    </span>

                    <span x-show="kategori === 'Deklarasi Uang Muka'">
                        Nominal Deklarasi Uang Muka
                    </span>

                </label>

                <input
                    type="number"
                    name="nominal"
                    required
                    class="w-full border border-gray-200 rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-indigo-500">

            </div>

            <!-- TANGGAL -->
            <div class="mb-6">

                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    Tanggal Pengajuan
                </label>

                <input
                    type="datetime-local"
                    name="tanggal_pengajuan"
                    class="w-full border rounded-2xl px-4 py-3">

            </div>

            <!-- FILE -->
            <div
                class="mb-8"
                x-data="{ fileName: '' }">

                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    Upload Dokumen
                </label>

                <label
                    class="flex items-center justify-center w-full px-6 py-8 border-2 border-dashed border-gray-300 rounded-3xl cursor-pointer hover:border-indigo-500 hover:bg-indigo-50 transition group">

                    <div class="text-center">

                        <div class="text-5xl mb-4">
                            📄
                        </div>

                        <p class="text-sm font-semibold text-gray-700 group-hover:text-indigo-700">
                            Klik untuk upload file
                        </p>

                        <p class="text-xs text-gray-400 mt-2">
                            PDF atau Word (.pdf, .doc, .docx, .jpg, .jpeg, .png)
                        </p>

                        <template x-if="fileName">

                            <div class="mt-4">

                                <p class="text-sm font-bold text-indigo-600 break-all">
                                    📎 <span x-text="fileName"></span>
                                </p>

                            </div>

                        </template>

                    </div>

                    <input
                        type="file"
                        name="berkas"
                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                        class="hidden"
                        required
                        @change="fileName = $event.target.files[0].name">

                </label>

            </div>

            <!-- BUTTON -->
            <button
                type="submit"
                class="w-full bg-indigo-700 hover:bg-indigo-800 transition text-white py-4 rounded-2xl font-bold text-sm">

                AJUKAN SEKARANG

            </button>

        </form>

    </div>

</div>

@endsection
