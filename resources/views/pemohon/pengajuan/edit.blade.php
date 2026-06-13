@extends('layouts.pemohon')

@section('title', 'Edit Dokumen')

@section('content')

<!-- BACK -->
<div class="mb-6">

    <a href="/dashboard"
       class="inline-flex items-center gap-2 text-sm font-semibold text-gray-600 hover:text-indigo-700 transition">

        ← Kembali

    </a>

</div>

<div class="max-w-2xl mx-auto">

    <!-- HEADER -->
    <div class="mb-8">

        <h1 class="text-3xl font-extrabold text-gray-900">
            EDIT DOKUMEN
        </h1>

        <p class="text-sm text-gray-400 mt-2">
            Upload ulang dokumen pengajuan anda
        </p>

    </div>

    <!-- CARD -->
    <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">

        
        <form action="/pengajuan/update/{{ $pengajuan->id }}"
            method="POST"
            enctype="multipart/form-data"
            x-data="{ fileName: '' }">

            @csrf

            <!-- DIBAYARKAN -->
            <div class="mb-6">

                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    Dibayarkan Kepada
                </label>

                <input
                    type="text"
                    name="dibayarkan"
                    value="{{ $pengajuan->dibayarkan }}"
                    disabled
                    class="w-full border border-gray-300 rounded-2xl px-5 py-4">

            </div>

            <!-- KETERANGAN -->
            <div class="mb-6">

                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    Keterangan
                </label>

                <textarea
                    name="keterangan"
                    class="w-full border border-gray-300 rounded-2xl px-5 py-4 h-32 resize-none">{{ $pengajuan->keterangan }}</textarea>

            </div>

            <!-- NOMINAL -->
            <div class="mb-6">

                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    Nominal
                </label>

                <input
                    type="number"
                    name="nominal"
                    value="{{ $pengajuan->nominal }}"
                    class="w-full border border-gray-300 rounded-2xl px-5 py-4">

            </div>

            <!-- FILE LAMA -->
            <div class="mb-4">

                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    Dokumen Saat Ini
                </label>

                <div class="bg-gray-50 border border-gray-200 rounded-2xl px-5 py-4">

                    📄 {{ $pengajuan->berkas }}

                </div>

            </div>

            <!-- FILE BARU -->
            <div class="mb-8">

                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    Upload Dokumen Baru
                </label>

                <label class="flex items-center justify-center w-full px-6 py-8 border-2 border-dashed border-gray-300 rounded-3xl cursor-pointer hover:border-indigo-500 hover:bg-indigo-50 transition group">

                    <div class="text-center">

                        <div class="text-5xl mb-4">
                            📄
                        </div>

                        <p class="text-sm font-semibold text-gray-700 group-hover:text-indigo-700">
                            Klik untuk upload file
                        </p>

                        <p class="text-xs text-gray-400 mt-2">
                            PDF atau Word (.pdf, .doc, .docx)
                        </p>

                        <template x-if="fileName">

                            <div class="mt-4 bg-indigo-100 text-indigo-700 px-4 py-2 rounded-xl text-sm font-semibold">

                                📎 <span x-text="fileName"></span>

                            </div>

                        </template>

                    </div>

                    <input
                        type="file"
                        name="berkas"
                        accept=".pdf,.doc,.docx"
                        class="hidden"
                        @change="fileName = $event.target.files[0]?.name">

                </label>

            </div>

            <!-- BUTTON -->
            <button
                type="submit"
                class="w-full bg-indigo-700 hover:bg-indigo-800 transition text-white py-4 rounded-2xl font-bold text-sm">

                UPDATE DOKUMEN

            </button>

        </form>

    </div>

</div>

@endsection