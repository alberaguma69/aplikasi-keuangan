@extends('layouts.app')

@section('title', 'Login')

@section('content')

<div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">

    <!-- LEFT -->
    <div class="bg-[#f7f8ff] flex flex-col justify-center items-center px-10 py-16 relative overflow-hidden">

        <div class="absolute top-10 left-10">
            <h1 class="text-5xl font-extrabold text-indigo-600">
                FinanceApp
            </h1>
        </div>

        <img
            src="https://cdni.iconscout.com/illustration/premium/thumb/cyber-security-4488235-3728454.png"
            class="w-full max-w-xl"
        >

        <div class="mt-10 text-center max-w-md">

            <h2 class="text-4xl font-bold text-gray-800">
                Sistem Permohonan Transaksi
            </h2>

            <p class="text-gray-500 mt-5 text-lg">
                Kelola pengajuan dana dengan mudah dan modern.
            </p>

        </div>

    </div>

    <!-- RIGHT -->
    <div class="flex items-center justify-center px-8 py-16 bg-white">

        <div class="w-full max-w-xl">

            <div class="flex justify-end mb-10">

                <a href="/register"
                   class="border border-gray-300 px-6 py-3 rounded-full">
                    SIGN UP
                </a>

            </div>

            <div class="mb-12">

                <h1 class="text-7xl font-extrabold text-gray-800">
                    Welcome Back!
                </h1>

                <p class="text-gray-500 mt-5 text-2xl">
                    Login untuk melanjutkan.
                </p>

            </div>

            <form action="/login" method="POST">

                @csrf

                <div class="mb-8">

                    <label class="block mb-3 text-2xl font-semibold">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        class="w-full bg-[#eef2ff] rounded-3xl px-6 py-5"
                    >

                </div>

                <div class="mb-10">

                    <label class="block mb-3 text-2xl font-semibold">
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        class="w-full bg-[#eef2ff] rounded-3xl px-6 py-5"
                    >

                </div>

                <button
                    class="w-full bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 text-white py-5 rounded-3xl text-2xl font-bold">
                    LOGIN
                </button>

            </form>

        </div>

    </div>

</div>

@endsection

