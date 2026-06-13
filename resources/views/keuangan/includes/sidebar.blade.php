<div class="w-72 bg-white border-r border-gray-100 min-h-screen p-6 flex flex-col justify-between">

    <!-- TOP -->
    <div>

        <!-- LOGO -->
        <div class="mb-10">

            <h1 class="text-3xl font-extrabold text-indigo-700">
                FINFLOW
            </h1>

        </div>

        <!-- MENU -->
        <div class="space-y-3">

            <!-- DASHBOARD -->
            <a href="/keuangan/dashboard"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl transition
               {{ request()->is('keuangan/dashboard') ? 'bg-indigo-700 text-white shadow-lg' : 'text-gray-600 hover:bg-gray-100' }}">

                <span class="text-lg">🏠</span>

                <span class="font-semibold text-sm">
                    Dashboard
                </span>

            </a>

            <!-- PERMOHONAN -->
            <a href="/keuangan/permohonan"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl transition
               {{ request()->is('keuangan/permohonan') ? 'bg-indigo-700 text-white shadow-lg' : 'text-gray-600 hover:bg-gray-100' }}">

                <span class="text-lg">📝</span>

                <span class="font-semibold text-sm">
                    Permohonan
                </span>

            </a>

            <!-- PEMBUKUAN -->
            <a href="/keuangan/pembukuan"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl transition
               {{ request()->is('keuangan/pembukuan') ? 'bg-indigo-700 text-white shadow-lg' : 'text-gray-600 hover:bg-gray-100' }}">

                <span class="text-lg">📚</span>

                <span class="font-semibold text-sm">
                    Pembukuan
                </span>

            </a>

            <!-- REJECTED -->
            <a href="/keuangan/rejected"
            class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-red-50 text-red-600">

                ❌ Rejected

            </a>

            <!-- KELOLA USER -->
            <a href="/keuangan/user"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl transition
               {{ request()->is('keuangan/user') ? 'bg-indigo-700 text-white shadow-lg' : 'text-gray-600 hover:bg-gray-100' }}">

                <span class="text-lg">👥</span>

                <span class="font-semibold text-sm">
                    Kelola User
                </span>

            </a>

        </div>

    </div>

</div>