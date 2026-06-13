@extends('layouts.app')

@section('title', 'Register')

@section('content')

<div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">

    <!-- LEFT -->
    <div class="bg-[#f7f8ff] flex flex-col justify-center items-center px-10 py-16 relative overflow-hidden">

        <!-- LOGO -->
        <div class="absolute top-10 left-10">
            <h1 class="text-5xl font-extrabold text-indigo-600">
                FinanceApp
            </h1>
        </div>

        <!-- IMAGE -->
        <img
            src="https://cdni.iconscout.com/illustration/premium/thumb/mobile-registration-4488236-3728455.png"
            alt="Register Illustration"
            class="w-full max-w-xl"
        >

        <!-- TEXT -->
        <div class="mt-10 text-center max-w-lg">

            <h2 class="text-5xl font-bold text-gray-800 leading-tight">
                Buat Akun Baru
            </h2>

            <p class="text-gray-500 mt-5 text-xl leading-relaxed">
                Daftarkan akun anda untuk mulai
                mengelola pengajuan dana dengan mudah.
            </p>

        </div>

    </div>

    <!-- RIGHT -->
    <div class="flex items-center justify-center px-8 py-16 bg-white">

        <div class="w-full max-w-xl">

            <!-- TOP BUTTON -->
            <div class="flex justify-end mb-10">

                <a href="/login"
                   class="border border-gray-300 px-6 py-3 rounded-full hover:bg-gray-100 transition">
                    SIGN IN
                </a>

            </div>

            <!-- HEADER -->
            <div class="mb-10">

                <h1 class="text-6xl font-extrabold text-gray-800">
                    Create Account
                </h1>

                <p class="text-gray-500 mt-4 text-xl">
                    Lengkapi data dibawah untuk membuat akun baru.
                </p>

            </div>

            <!-- FORM -->
            <form action="/register" method="POST">

                @csrf

                <!-- NAME -->
                <div class="mb-5">

                    <label class="block mb-3 text-lg font-semibold text-gray-700">
                        Nama Lengkap
                    </label>

                    <input
                        type="text"
                        name="name"
                        placeholder="Masukkan nama lengkap"
                        class="w-full bg-[#eef2ff] border border-gray-200 rounded-2xl px-5 py-4 text-lg focus:outline-none focus:ring-4 focus:ring-indigo-200"
                    >

                </div>

                <!-- EMAIL -->
                <div class="mb-5">

                    <label class="block mb-3 text-lg font-semibold text-gray-700">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        placeholder="Masukkan email"
                        class="w-full bg-[#eef2ff] border border-gray-200 rounded-2xl px-5 py-4 text-lg focus:outline-none focus:ring-4 focus:ring-indigo-200"
                    >

                </div>

                <!-- ROLE -->
                <div class="mb-5">

                    <label class="block mb-3 text-lg font-semibold text-gray-700">
                        Pilih Role
                    </label>

                    <select
                        name="role"
                        class="w-full bg-[#eef2ff] border border-gray-200 rounded-2xl px-5 py-4 text-lg focus:outline-none focus:ring-4 focus:ring-indigo-200"
                    >

                        <option value="">
                            -- Pilih Role --
                        </option>

                        <option value="pemohon">
                            Pemohon Dana
                        </option>

                        <option value="keuangan">
                            Admin Keuangan
                        </option>

                    </select>

                </div>

                <!-- PASSWORD -->
                <div class="mb-5">

                    <label class="block mb-3 text-lg font-semibold text-gray-700">
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        placeholder="Masukkan password"
                        class="w-full bg-[#eef2ff] border border-gray-200 rounded-2xl px-5 py-4 text-lg focus:outline-none focus:ring-4 focus:ring-indigo-200"
                    >

                </div>

                <!-- CONFIRM PASSWORD -->
                <div class="mb-8">

                    <label class="block mb-3 text-lg font-semibold text-gray-700">
                        Konfirmasi Password
                    </label>

                    <input
                        type="password"
                        name="password_confirmation"
                        placeholder="Ulangi password"
                        class="w-full bg-[#eef2ff] border border-gray-200 rounded-2xl px-5 py-4 text-lg focus:outline-none focus:ring-4 focus:ring-indigo-200"
                    >

                </div>

                <!-- BUTTON -->
                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 text-white py-5 rounded-2xl text-xl font-bold shadow-lg hover:scale-[1.01] transition duration-300"
                >
                    CREATE ACCOUNT
                </button>

            </form>

            <!-- LOGIN -->
            <p class="text-center text-gray-500 mt-8 text-lg">
                Sudah punya akun?

                <a href="/login"
                   class="text-indigo-600 font-semibold hover:underline">
                    Login sekarang
                </a>

            </p>

        </div>

    </div>

</div>

@endsection

