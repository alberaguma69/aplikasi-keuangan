@extends('layouts.keuangan')

@section('title', 'Kelola User')

@section('content')


<div x-data="{ openCreate: false }">

    <!-- HEADER -->
    <div class="mb-8 flex items-center justify-between">

        <!-- LEFT -->
        <div>

            <h1 class="text-3xl font-extrabold text-gray-900">
                KELOLA USER
            </h1>

            <p class="text-sm text-gray-400 mt-2">
                Kelola data pengguna sistem
            </p>

        </div>

        <!-- RIGHT -->
        <div class="flex items-center gap-4">

            <!-- BUTTON TAMBAH USER -->
            <button
                @click="openCreate = true"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-3 rounded-2xl font-semibold transition">

                + Tambah User

            </button>

            <!-- TOPBAR -->
            @include('keuangan.includes.topbar')

        </div>

    </div>

    <!-- ACTION -->
    <div class="flex justify-end mb-6">

        <!-- MODAL TAMBAH USER -->
        <div
            x-show="openCreate"
            x-cloak
            class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">

            <div
                @click.away="openCreate = false"
                class="bg-white rounded-3xl p-6 w-full max-w-md shadow-2xl">

                <div class="flex items-center gap-3 mb-5">

                    <div class="w-12 h-12 rounded-2xl bg-indigo-100 flex items-center justify-center text-xl">
                        👤
                    </div>

                    <div>

                        <h2 class="text-xl font-bold text-gray-900">
                            Tambah User
                        </h2>

                        <p class="text-sm text-gray-400">
                            Buat akun pengguna baru
                        </p>

                    </div>

                </div>

                <form action="/keuangan/user/store" method="POST">

                    @csrf

                    <!-- NAMA -->
                    <label class="block text-sm font-semibold text-gray-600 mb-2">
                        Nama
                    </label>

                    <input
                        type="text"
                        name="name"
                        required
                        class="w-full border border-gray-300 rounded-2xl px-4 py-3 mb-4">

                    <!-- EMAIL -->
                    <label class="block text-sm font-semibold text-gray-600 mb-2">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        required
                        class="w-full border border-gray-300 rounded-2xl px-4 py-3 mb-4">

                    <!-- PASSWORD -->
                    <label class="block text-sm font-semibold text-gray-600 mb-2">
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        required
                        class="w-full border border-gray-300 rounded-2xl px-4 py-3 mb-4">

                    <!-- ROLE -->
                    <label class="block text-sm font-semibold text-gray-600 mb-2">
                        Role
                    </label>

                    <div class="relative mb-5">

                        <select
                            name="role"
                            class="w-full border border-gray-300 rounded-2xl px-4 py-3 pr-10 appearance-none bg-white">

                            <option value="pemohon">
                                Pemohon
                            </option>

                            <option value="keuangan">
                                Keuangan
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

                    <div class="flex justify-end gap-3">

                        <button
                            type="button"
                            @click="openCreate = false"
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

    {{-- Filter Data --}}
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 mb-6">

        <div class="flex items-center justify-between">

            <div>

                <h2 class="text-2xl font-bold text-gray-900">
                    Filter Data
                </h2>

                <p class="text-sm text-gray-400 mt-1">
                    Cari pengguna berdasarkan nama atau email
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
                        class="w-80 border border-gray-200 rounded-2xl pl-12 pr-4 py-4">

                    <span class="absolute left-4 top-1/2 -translate-y-1/2">
                        🔍
                    </span>

                </div>

            </form>

        </div>

    </div>


<!-- TABLE -->
<div class="bg-white rounded-3xl border border-gray-200 overflow-hidden">

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead>

                <tr class="bg-gray-50 border-b border-gray-200">

                    <th class="text-left px-6 py-4 text-xs font-bold text-gray-500 uppercase">
                        Nama
                    </th>

                    <th class="text-left px-6 py-4 text-xs font-bold text-gray-500 uppercase">
                        Email
                    </th>

                    <th class="text-left px-6 py-4 text-xs font-bold text-gray-500 uppercase">
                        Role
                    </th>

                    <th class="text-center px-6 py-4 text-xs font-bold text-gray-500 uppercase">
                        Aksi
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($users as $user)

                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition">

                        <td class="px-6 py-4">

                            <!-- NAMA -->
                            <div class="flex items-center gap-3">

                                <div
                                    class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold">

                                    {{ strtoupper(substr($user->name, 0, 1)) }}

                                </div>

                                <span class="font-semibold text-gray-800">

                                    {{ $user->name }}

                                </span>

                            </div>

                        </td>

                        <!-- EMAIL -->
                        <td class="px-6 py-4 text-sm text-gray-500">

                            {{ $user->email }}

                        </td>

                        <td class="px-6 py-4">

                            @if($user->role == 'keuangan')

                                <span
                                    class="bg-indigo-50 text-indigo-600 px-3 py-1 rounded-xl text-[11px] font-semibold">

                                    KEUANGAN

                                </span>

                            @else

                                <span
                                    class="bg-green-50 text-green-600 px-3 py-1 rounded-xl text-[11px] font-semibold">

                                    PEMOHON

                                </span>

                            @endif

                        </td>

                        <!-- AKSI -->
                        <td class="px-6 py-4">

                            <div class="flex justify-center gap-2">

                                <!-- EDIT -->
                                <div x-data="{ openEdit: false }">

                                    <button
                                        @click="openEdit = true"
                                        type="button"
                                        class="w-9 h-9 rounded-xl bg-amber-50 text-red-600 hover:bg-amber-100 flex items-center justify-center transition">

                                        ✏️

                                    </button>

                                    <!-- MODAL EDIT -->
                                    <div
                                        x-show="openEdit"
                                        x-cloak
                                        class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">

                                        <div
                                            @click.away="openEdit = false"
                                            class="bg-white rounded-3xl p-6 w-full max-w-md">

                                            <h2 class="text-xl font-bold mb-5">
                                                Edit User
                                            </h2>

                                            <form action="/keuangan/user/update/{{ $user->id }}" method="POST">

                                                @csrf
                                                
                                                <label class="block text-sm font-semibold text-gray-600 mb-2">
                                                    Username Baru
                                                </label>

                                                <input
                                                    type="text"
                                                    name="name"
                                                    value="{{ $user->name }}"
                                                    class="w-full border rounded-xl px-4 py-3 mb-4">
                                                
                                                <label class="block text-sm font-semibold text-gray-600 mb-2">
                                                    Email Baru
                                                </label>

                                                <input
                                                    type="email"
                                                    name="email"
                                                    value="{{ $user->email }}"
                                                    class="w-full border rounded-xl px-4 py-3 mb-4">
                                                
                                                <label class="block text-sm font-semibold text-gray-600 mb-2">
                                                    Role Baru
                                                </label>

                                                <div class="relative mb-5">

                                                    <select
                                                        name="role"
                                                        class="w-full border border-gray-300 rounded-2xl px-4 py-3 pr-10 appearance-none bg-white">

                                                        <option value="pemohon">
                                                            Pemohon
                                                        </option>

                                                        <option value="keuangan">
                                                            Keuangan
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

                                                <!-- PASSWORD BARU -->
                                                <label class="block text-sm font-semibold text-gray-600 mb-2">
                                                    Password Baru
                                                </label>

                                                <input
                                                    type="password"
                                                    name="password"
                                                    placeholder="Kosongkan jika tidak ingin mengganti password"
                                                    class="w-full border border-gray-300 rounded-2xl px-4 py-3 mb-4">

                                                <!-- KONFIRMASI PASSWORD -->
                                                <label class="block text-sm font-semibold text-gray-600 mb-2">
                                                    Konfirmasi Password
                                                </label>

                                                <input
                                                    type="password"
                                                    name="password_confirmation"
                                                    placeholder="Ulangi password baru"
                                                    class="w-full border border-gray-300 rounded-2xl px-4 py-3 mb-5">

                                                <div class="flex justify-end gap-2">

                                                    <button
                                                        type="button"
                                                        @click="openEdit = false"
                                                        class="px-4 py-2 bg-gray-100 rounded-xl">

                                                        Batal

                                                    </button>

                                                    <button
                                                        type="submit"
                                                        class="px-4 py-2 bg-indigo-600 text-white rounded-xl">

                                                        Simpan

                                                    </button>

                                                </div>

                                            </form>

                                        </div>

                                    </div>

                                </div>

                                <!-- DELETE -->
                                <form
                                    action="/keuangan/user/delete/{{ $user->id }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus user ini?')">

                                    @csrf

                                    <button
                                        type="submit"
                                        class="w-9 h-9 rounded-xl bg-red-50 text-red-600 hover:bg-red-100 flex items-center justify-center transition">

                                        🗑️

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="4" class="py-16 text-center">

                            <h2 class="text-xl font-bold text-gray-700 mb-2">
                                Tidak Ada User
                            </h2>

                            <p class="text-gray-400">
                                Data user akan muncul di sini
                            </p>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection
