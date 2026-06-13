<!DOCTYPE html>
<html lang="id">

@include('includes.head')

<body class="bg-[#f5f6fa]">

    <div class="flex min-h-screen">

        <!-- SIDEBAR -->
        @include('keuangan.includes.sidebar')

        <!-- CONTENT -->
        <main class="flex-1 p-10 overflow-y-auto">

            @yield('content')

        </main>

    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</body>
</html>