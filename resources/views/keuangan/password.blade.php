@extends('layouts.keuangan')

@section('title', 'Ubah Password')

@section('content')

<!-- HEADER -->
<div class="flex items-center justify-between mb-8">

    <div>

        <h1 class="text-3xl font-extrabold text-gray-900">
            UBAH PASSWORD
        </h1>

        <p class="text-sm text-gray-400 mt-1">
            Perbarui password akun anda
        </p>

    </div>

    @include('keuangan.includes.topbar')

</div>

<div class="bg-white rounded-3xl p-8 border border-gray-100">

    <form action="/keuangan/password/update" method="POST">

        @csrf

        <div class="mb-5">

            <label class="block text-sm font-semibold mb-2">
                Password Baru
            </label>

            <input
                type="password"
                name="password"
                class="w-full border border-gray-300 rounded-2xl px-4 py-3">

        </div>

        <div class="mb-6">

            <label class="block text-sm font-semibold mb-2">
                Konfirmasi Password
            </label>

            <input
                type="password"
                name="password_confirmation"
                class="w-full border border-gray-300 rounded-2xl px-4 py-3">

        </div>

        <button
            type="submit"
            class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-2xl font-semibold">

            Ubah Password

        </button>

    </form>

</div>

@endsection