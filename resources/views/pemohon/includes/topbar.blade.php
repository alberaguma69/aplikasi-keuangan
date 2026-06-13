@php

$notifications = \App\Models\Notification::where('user_id', auth()->id())
    ->latest()
    ->take(10)
    ->get();

$unreadCount = \App\Models\Notification::where('user_id', auth()->id())
    ->where('is_read', false)
    ->count();

@endphp

<div class="flex items-center gap-4">

    <!-- NOTIFICATION -->
    <div x-data="{ notifOpen: false }" class="relative">

        <button
            @click="
            notifOpen = !notifOpen;
            fetch('/notifications/read-all', {
                method:'POST',
                headers:{
                    'X-CSRF-TOKEN':'{{ csrf_token() }}'
                }
            });
            "
            class="w-12 h-12 bg-white rounded-2xl shadow-sm hover:shadow-md transition flex items-center justify-center text-xl relative">

            🔔

            @if($unreadCount > 0)

                <span
                    class="absolute top-2 right-2 min-w-[18px] h-[18px] px-1 bg-red-500 text-white text-[10px] rounded-full flex items-center justify-center">

                    {{ $unreadCount }}

                </span>

            @endif

        </button>

        <!-- DROPDOWN -->
        <div
            x-show="notifOpen"
            x-cloak
            @click.away="notifOpen = false"
            class="absolute right-0 mt-3 w-96 bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden z-50">

            <!-- HEADER -->
            <div class="px-5 py-4 border-b border-gray-100 bg-gray-50 flex items-center justify-between">

                <h2 class="font-bold text-gray-800">
                    Notifikasi
                </h2>

                @if($notifications->count())

                    <form action="/pemohon/notifications/delete-all" method="POST">

                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="text-xs text-red-500 hover:text-red-700 font-semibold">

                            Hapus Semua

                        </button>

                    </form>

                @endif

            </div>
            <!-- LIST -->
            <div class="max-h-96 overflow-y-auto">

                @forelse($notifications as $notif)

                    <div class="px-5 py-4 border-b border-gray-100 hover:bg-gray-50">

                        <div class="flex items-start gap-3">

                            <!-- ICON -->
                            <div
                                class="w-10 h-10 rounded-2xl flex items-center justify-center flex-shrink-0

                                @if(str_contains(strtolower($notif->title), 'ditolak'))
                                    bg-red-100 text-red-600

                                @elseif(str_contains(strtolower($notif->title), 'dicairkan') || str_contains(strtolower($notif->title), 'done'))
                                    bg-green-100 text-green-600

                                @elseif(str_contains(strtolower($notif->title), 'diproses'))
                                    bg-blue-100 text-blue-600

                                @else
                                    bg-yellow-100 text-yellow-600
                                @endif">

                                @if(str_contains(strtolower($notif->title), 'ditolak'))

                                    ✖

                                @elseif(str_contains(strtolower($notif->title), 'dicairkan') || str_contains(strtolower($notif->title), 'done'))

                                    ✔

                                @elseif(str_contains(strtolower($notif->title), 'diproses'))

                                    ⚙️

                                @else

                                    ⏳

                                @endif

                            </div>

                            <!-- CONTENT -->
                            <div class="flex-1">

                                <h3 class="font-semibold text-gray-800 text-sm">

                                    {{ $notif->title }}

                                </h3>

                                <p class="text-xs text-gray-500 mt-1">

                                    {{ $notif->message }}

                                </p>

                                <p class="text-[11px] text-gray-400 mt-2">

                                    {{ $notif->created_at->diffForHumans() }}

                                </p>

                            </div>

                            <form
                                action="/pemohon/notification/{{ $notif->id }}"
                                method="POST">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="text-red-500 hover:text-red-700 text-sm ml-2">

                                    🗑

                                </button>

                            </form>

                            <!-- UNREAD DOT -->
                            @if(!$notif->is_read)

                                <div class="w-2 h-2 bg-indigo-600 rounded-full mt-2"></div>

                            @endif

                        </div>

                    </div>

                @empty

                    <div class="p-10 text-center">

                        <div class="text-5xl opacity-30 mb-2">

                            🔕

                        </div>

                        <p class="text-sm text-gray-400">

                            Belum ada notifikasi

                        </p>

                    </div>

                @endforelse

            </div>

        </div>

    </div>

    <!-- PROFILE -->
    <div x-data="{ profileOpen: false }" class="relative">

        <button
            @click="profileOpen = !profileOpen"
            class="flex items-center gap-3 bg-white px-3 py-2 rounded-2xl shadow-sm hover:shadow-md transition">

            <div
                class="w-11 h-11 rounded-2xl bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold">

                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

            </div>

            <div class="hidden md:block text-left">

                <h1 class="text-sm font-bold text-gray-800">

                    {{ auth()->user()->name }}

                </h1>

                <p class="text-xs text-gray-400">

                    Pemohon

                </p>

            </div>

        </button>

        <!-- DROPDOWN -->
        <div
            x-show="profileOpen"
            x-cloak
            @click.away="profileOpen = false"
            class="absolute right-0 mt-3 w-64 bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden z-50">

            <div class="p-4 border-b border-gray-100 bg-gray-50">

                <h2 class="font-bold text-gray-800 truncate">

                    {{ auth()->user()->name }}

                </h2>

                <p class="text-xs text-gray-500 truncate">

                    {{ auth()->user()->email }}

                </p>

            </div>

            <a
                href="/profile"
                class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 transition">

                👤 Profil Saya

            </a>

            <a
                href="/password"
                class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 transition">

                🔑 Ubah Password

            </a>

            <div class="border-t border-gray-100">

                <form action="{{ route('logout') }}" method="POST">

                    @csrf

                    <button
                        type="submit"
                        class="w-full text-left flex items-center gap-3 px-4 py-3 text-red-600 hover:bg-red-50 transition">

                        🚪 Logout

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>
