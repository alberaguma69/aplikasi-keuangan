<div id="sidebar"
     class="w-72 bg-white border-r border-gray-100 min-h-screen p-6 flex flex-col transition-all duration-300">

    <!-- HEADER -->
    <div>

        <div class="flex items-center justify-between mb-10">

            <h1 id="logoText"
                class="text-3xl font-extrabold text-indigo-700 whitespace-nowrap">
                FINFLOW
            </h1>

            <button onclick="toggleSidebar()"
                    class="w-10 h-10 flex items-center justify-center rounded-xl border hover:bg-gray-100">
                ☰
            </button>

        </div>

        <!-- MENU -->
        <div class="space-y-3">

            <!-- DASHBOARD -->
            <a href="/keuangan/dashboard"
               class="menu-link flex items-center gap-3 px-4 py-3 rounded-2xl transition
               {{ request()->is('keuangan/dashboard') ? 'bg-indigo-700 text-white shadow-lg' : 'text-gray-600 hover:bg-gray-100' }}">

                <span class="text-xl">🏠</span>

                <span class="menu-text font-semibold text-sm">
                    Dashboard
                </span>

            </a>

            <!-- PERMOHONAN -->
            <a href="/keuangan/permohonan"
               class="menu-link flex items-center gap-3 px-4 py-3 rounded-2xl transition
               {{ request()->is('keuangan/permohonan') ? 'bg-indigo-700 text-white shadow-lg' : 'text-gray-600 hover:bg-gray-100' }}">

                <span class="text-xl">📝</span>

                <span class="menu-text font-semibold text-sm">
                    Permohonan
                </span>

            </a>

            <!-- PEMBUKUAN -->
            <a href="/keuangan/pembukuan"
               class="menu-link flex items-center gap-3 px-4 py-3 rounded-2xl transition
               {{ request()->is('keuangan/pembukuan') ? 'bg-indigo-700 text-white shadow-lg' : 'text-gray-600 hover:bg-gray-100' }}">

                <span class="text-xl">📚</span>

                <span class="menu-text font-semibold text-sm">
                    Pembukuan
                </span>

            </a>

            <!-- REJECTED -->
            <a href="/keuangan/rejected"
               class="menu-link flex items-center gap-3 px-4 py-3 rounded-2xl transition
               {{ request()->is('keuangan/rejected') ? 'bg-red-100 text-red-600' : 'text-red-600 hover:bg-red-50' }}">

                <span class="text-xl">❌</span>

                <span class="menu-text font-semibold text-sm">
                    Rejected
                </span>

            </a>

            <!-- USER -->
            <a href="/keuangan/user"
               class="menu-link flex items-center gap-3 px-4 py-3 rounded-2xl transition
               {{ request()->is('keuangan/user') ? 'bg-indigo-700 text-white shadow-lg' : 'text-gray-600 hover:bg-gray-100' }}">

                <span class="text-xl">👥</span>

                <span class="menu-text font-semibold text-sm">
                    Kelola User
                </span>

            </a>

        </div>

    </div>

</div>

<script>
function toggleSidebar() {

    const sidebar = document.getElementById('sidebar');

    // ukuran sidebar
    sidebar.classList.toggle('w-72');
    sidebar.classList.toggle('w-24');

    // sembunyikan text
    document.querySelectorAll('.menu-text').forEach(el => {
        el.classList.toggle('hidden');
    });

    // center icon saat collapse
    document.querySelectorAll('.menu-link').forEach(el => {
        el.classList.toggle('justify-center');
    });

    // sembunyikan logo
    document.getElementById('logoText').classList.toggle('hidden');
}
</script>