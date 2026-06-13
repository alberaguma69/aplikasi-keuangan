@extends('layouts.pemohon')

@section('title', 'Ubah Password')

@section('content')

<div class="flex items-center justify-between mb-8">

    <div>

        <h1 class="text-3xl font-extrabold text-gray-900">
            UBAH PASSWORD
        </h1>

        <p class="text-sm text-gray-400 mt-1">
            Perbarui password akun
        </p>

    </div>

    @include('pemohon.includes.topbar')

</div>

<div class="max-w-2xl mx-auto">

    <div class="bg-white rounded-3xl p-8 border border-gray-100">

        <form action="/password/update" method="POST">

            @csrf

            <div class="mb-6">

                <label class="block text-sm font-semibold mb-3">
                    Password Baru
                </label>

                <input
                    type="password"
                    name="password"
                    class="w-full border rounded-2xl px-5 py-4">

            </div>

            <div class="mb-8">

                <label class="block text-sm font-semibold mb-3">
                    Konfirmasi Password
                </label>

                <input
                    type="password"
                    name="password_confirmation"
                    class="w-full border rounded-2xl px-5 py-4">

            </div>

            <button
                class="w-full bg-indigo-700 text-white py-4 rounded-2xl font-bold">

                UPDATE PASSWORD

            </button>

        </form>

    </div>

</div>

@endsection
