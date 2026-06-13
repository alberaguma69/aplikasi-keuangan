<aside class="w-72 bg-white border-r border-gray-200 min-h-screen px-6 py-8 flex flex-col justify-between">

    <!-- TOP -->
    <div>

        <!-- LOGO -->
        <div class="mb-14">

            <h1 class="text-4xl font-extrabold text-indigo-700">
                FINFLOW
            </h1>

        </div>

        <!-- MENU -->
        <nav class="space-y-4">

            <!-- PENGAJUAN -->
            <a href="/pengajuan/create"
               class="flex items-center gap-4 px-5 py-4 rounded-2xl transition
               {{ request()->is('pengajuan/create')
                    ? 'bg-indigo-700 text-white shadow-lg'
                    : 'text-gray-700 hover:bg-gray-100'
               }}">

                <span class="text-2xl">📝</span>

                <span class="font-semibold text-lg">
                    Pengajuan
                </span>

            </a>

            <!-- STATUS -->
            <a href="/dashboard"
               class="flex items-center gap-4 px-5 py-4 rounded-2xl transition
               {{ request()->is('dashboard')
                    ? 'bg-indigo-700 text-white shadow-lg'
                    : 'text-gray-700 hover:bg-gray-100'
               }}">

                <span class="text-2xl">↩</span>

                <span class="font-semibold text-lg">
                    Status
                </span>

            </a>

        </nav>

    </div>

</aside>