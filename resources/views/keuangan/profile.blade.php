@extends('layouts.keuangan')

@section('title', 'Profil Saya')

@section('content')

<!-- HEADER -->
<div class="flex items-center justify-between mb-8">

    <div>

        <h1 class="text-3xl font-extrabold text-gray-900">
            PROFIL SAYA
        </h1>

        <p class="text-sm text-gray-400 mt-1">
            Kelola informasi akun anda
        </p>

    </div>

    @include('keuangan.includes.topbar')

</div>

<div class="bg-white rounded-3xl p-8 border border-gray-100">

    <form action="/keuangan/profile/update" method="POST">

        @csrf

        <div class="mb-5">

            <label class="block text-sm font-semibold mb-2">
                Nama
            </label>

            <input
                type="text"
                name="name"
                value="{{ auth()->user()->name }}"
                class="w-full border border-gray-300 rounded-2xl px-4 py-3">

        </div>

        <div class="mb-6">

            <label class="block text-sm font-semibold mb-2">
                Email
            </label>

            <input
                type="email"
                name="email"
                value="{{ auth()->user()->email }}"
                class="w-full border border-gray-300 rounded-2xl px-4 py-3">

        </div>

        <button
            type="submit"
            class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-2xl font-semibold">

            Simpan Perubahan

        </button>

    </form>

</div>

@endsection