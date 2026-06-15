<aside id="sidebar"
       class="w-72 bg-white border-r border-gray-200 min-h-screen px-6 py-8 flex flex-col transition-all duration-300">

    <!-- TOP -->
    <div>

        <!-- HEADER -->
        <div class="flex items-center justify-between mb-14">

            <h1 id="logoText"
                class="text-4xl font-extrabold text-indigo-700 whitespace-nowrap">
                FINFLOW
            </h1>

            <button onclick="toggleSidebar()"
                    class="w-10 h-10 flex items-center justify-center rounded-xl border hover:bg-gray-100">
                ☰
            </button>

        </div>

        <!-- MENU -->
        <nav class="space-y-4">

            <!-- PENGAJUAN -->
            <a href="/pengajuan/create"
               class="menu-link flex items-center gap-4 px-5 py-4 rounded-2xl transition
               {{ request()->is('pengajuan/create')
                    ? 'bg-indigo-700 text-white shadow-lg'
                    : 'text-gray-700 hover:bg-gray-100'
               }}">

                <span class="text-2xl">📝</span>

                <span class="menu-text font-semibold text-lg">
                    Pengajuan
                </span>

            </a>

            <!-- STATUS -->
            <a href="/dashboard"
               class="menu-link flex items-center gap-4 px-5 py-4 rounded-2xl transition
               {{ request()->is('dashboard')
                    ? 'bg-indigo-700 text-white shadow-lg'
                    : 'text-gray-700 hover:bg-gray-100'
               }}">

                <span class="text-2xl">📋</span>

                <span class="menu-text font-semibold text-lg">
                    Status
                </span>

            </a>

        </nav>

    </div>

</aside>

<script>
function toggleSidebar() {

    const sidebar = document.getElementById('sidebar');

    sidebar.classList.toggle('w-72');
    sidebar.classList.toggle('w-24');

    document.querySelectorAll('.menu-text').forEach(el => {
        el.classList.toggle('hidden');
    });

    document.querySelectorAll('.menu-link').forEach(el => {
        el.classList.toggle('justify-center');
    });

    document.getElementById('logoText').classList.toggle('hidden');
}
</script>