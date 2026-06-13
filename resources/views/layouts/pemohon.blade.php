<!DOCTYPE html>
<html lang="id">

@include('includes.head')

<body class="bg-[#f5f6fa]">

    <div class="flex min-h-screen">

        <!-- SIDEBAR -->
        @include('pemohon.includes.sidebar')

        <!-- CONTENT -->
        <main class="flex-1 p-10 overflow-y-auto">
            @yield('content')
        </main>

    </div>

</body>
</html>

