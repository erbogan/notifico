<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Admin Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#0F172A',
                        accent: '#6366F1',
                        navbar: '#111827',
                    },
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui'],
                    },
                    boxShadow: {
                        "xl-soft": "0 6px 32px 0 rgba(0,0,0,0.25)",
                        "inner-focus": "inset 0 0 0 2px #6366F1"
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap" rel="stylesheet">
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body
    x-data="{
        sidebarOpen: false,
        darkMode: false,
        profileOpen: false,
        kurse: { usd: null, eur: null, gold: null, btc: null },
        weather: { temp: null, desc: null, icon: null, city: 'Berlin' },
        loading: true,
        async fetchData() {
            const res = await fetch('https://api.frankfurter.app/latest?from=EUR&to=USD,TRY');
            const data = await res.json();
            this.kurse.eur = 1;
            this.kurse.usd = data.rates.USD;
            this.kurse.gold = 2523;
            try {
                const btcRes = await fetch('https://api.coingecko.com/api/v3/simple/price?ids=bitcoin&vs_currencies=eur');
                const btcData = await btcRes.json();
                this.kurse.btc = btcData.bitcoin.eur;
            } catch (e) {
                this.kurse.btc = null;
            }
            try {
                const weatherRes = await fetch('https://api.open-meteo.com/v1/forecast?latitude=52.52&longitude=13.41&current_weather=true');
                const weatherData = await weatherRes.json();
                this.weather.temp = Math.round(weatherData.current_weather.temperature);
                this.weather.desc = weatherData.current_weather.weathercode === 0
                    ? 'Klar'
                    : (weatherData.current_weather.weathercode === 3 ? 'Bewölkt' : 'Teilweise bewölkt');
                this.weather.icon = weatherData.current_weather.weathercode === 0
                    ? '☀️'
                    : (weatherData.current_weather.weathercode === 3 ? '☁️' : '🌤️');
            } catch (e) {
                this.weather.temp = null;
                this.weather.desc = null;
            }
            this.loading = false;
        }
    }"
    x-init="fetchData()"
    @keydown.escape="profileOpen = false"
    :class="{ 'dark': darkMode }"
    class="font-sans bg-white text-primary dark:bg-primary dark:text-white min-h-screen antialiased transition-colors duration-300 flex flex-col"
>
<!-- Topbar -->
<header class="flex items-center justify-between h-16 px-4 lg:px-10 bg-white border-b border-gray-200 dark:bg-navbar dark:border-gray-800 shadow-sm z-30 transition-all duration-300">
    <div class="flex items-center gap-3">
        <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none">
            <svg class="w-7 h-7" fill="none"
                 :class="darkMode ? 'stroke-white' : 'stroke-accent'"
                 stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
        <span class="text-2xl font-black tracking-tight text-accent dark:text-white"><span class="hidden sm:inline">Notifico</span></span>
    </div>
    <div class="flex items-center gap-2 relative">
        <button @click="darkMode = !darkMode"
                class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none transition"
                :aria-label="darkMode ? 'Lichtmodus' : 'Dunkelmodus'">
            <svg x-show="!darkMode" class="w-6 h-6" fill="none"
                 stroke="#6366F1" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 3v1m0 16v1m8.66-8.66l-.71.71M4.05 4.05l.71.71M21 12h-1M4 12H3m16.24 4.24l-.71-.71M4.05 19.95l.71-.71M12 5a7 7 0 100 14a7 7 0 000-14z"/>
            </svg>
            <svg x-show="darkMode" class="w-6 h-6" fill="none"
                 stroke="#FBBF24" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M21 12.79A9 9 0 1111.21 3a7 7 0 109.79 9.79z"/>
            </svg>
        </button>
        <!-- Notification Bell -->
        <button class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none relative transition">
            <svg class="w-6 h-6"
                 :class="darkMode ? 'stroke-white' : 'stroke-accent'"
                 fill="none" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M15 17h5l-1.405-1.405M15 17l-1.405-1.405M15 17V3M9 7h.01M6 10h.01M3 13h.01M12 19h.01M21 3h.01"/>
            </svg>
            <span class="absolute top-1 right-1 block w-2 h-2 bg-red-500 rounded-full"></span>
        </button>
        <!-- Profile Avatar & Dropdown -->
        <div class="relative">
            <button @click="profileOpen = !profileOpen" @keydown.escape.stop="profileOpen = false"
                    class="ml-2 p-1 rounded-full border-2 border-accent/20 shadow-inner focus:outline-none focus:ring-2 focus:ring-accent"
                    aria-haspopup="true" :aria-expanded="profileOpen">
                <img src="https://i.pravatar.cc/40" class="w-9 h-9 rounded-full" alt="avatar">
            </button>
            <!-- Dropdown -->
            <div x-cloak x-show="profileOpen" @click.away="profileOpen = false"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute right-0 z-50 mt-2 w-48 rounded-xl shadow-xl bg-white dark:bg-navbar ring-1 ring-black/5 border border-gray-100 dark:border-gray-800 py-2 origin-top-right"
            >
                <div class="px-4 py-2 border-b border-gray-100 dark:border-gray-800 flex flex-col items-start">
                    <span class="font-semibold text-gray-800 dark:text-white">Eyüp Erboğan</span>
                    <span class="text-xs text-gray-500 dark:text-gray-400">admin@yourcompany.com</span>
                </div>
                <a href="#" class="flex items-center gap-2 px-4 py-2 hover:bg-accent/10 dark:hover:bg-white/10 text-gray-700 dark:text-gray-200 transition">
                    <svg class="w-5 h-5" fill="none" :class="darkMode ? 'stroke-white' : 'stroke-accent'" stroke-width="2"
                         viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
                                                   d="M5.121 17.804A13.937 13.937 0 0112 15c2.485 0 4.797.682 6.879 1.804M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Mein Profil
                </a>
                <a href="#" class="flex items-center gap-2 px-4 py-2 hover:bg-accent/10 dark:hover:bg-white/10 text-gray-700 dark:text-gray-200 transition">
                    <svg class="w-5 h-5" fill="none" :class="darkMode ? 'stroke-white' : 'stroke-accent'" stroke-width="2"
                         viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
                                                   d="M12 4v16m8-8H4"/></svg>
                    Einstellungen
                </a>
                <a href="#" class="flex items-center gap-2 px-4 py-2 hover:bg-accent/10 dark:hover:bg-white/10 text-gray-700 dark:text-gray-200 transition">
                    <svg class="w-5 h-5" fill="none" :class="darkMode ? 'stroke-white' : 'stroke-accent'" stroke-width="2"
                         viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
                                                   d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Abmelden
                </a>
            </div>
        </div>
    </div>
</header>

<div class="flex flex-1 min-h-0 relative w-full">
    <!-- Sidebar -->
    <aside
        x-cloak
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed z-40 inset-y-0 left-0 w-72 bg-gradient-to-br from-white/95 to-gray-100/80 dark:from-navbar dark:to-primary border-r border-gray-200 dark:border-gray-800 shadow-xl transition-transform duration-300 ease-in-out lg:static lg:translate-x-0 flex flex-col"
    >
        <div class="flex items-center justify-between h-16 px-6 border-b border-gray-200 dark:border-gray-800">
            <span class="text-2xl font-extrabold tracking-tight text-accent dark:text-white">Panel</span>
            <button @click="sidebarOpen = false" class="lg:hidden text-gray-400 hover:text-accent focus:outline-none">
                <svg class="w-6 h-6" fill="none" :class="darkMode ? 'stroke-white' : 'stroke-accent'" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <nav class="flex-1 flex flex-col gap-1 px-5 py-8">
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-accent dark:text-white bg-accent/10 dark:bg-white/10 hover:bg-accent/20 dark:hover:bg-white/20 transition group">
                <svg class="w-5 h-5"
                     :class="darkMode ? 'stroke-white' : 'stroke-accent'"
                     fill="none" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6"
                          stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Dashboard
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium text-gray-700 dark:text-gray-200 hover:bg-accent/10 dark:hover:bg-white/10 hover:text-accent dark:hover:text-white transition group">
                <svg class="w-5 h-5"
                     :class="darkMode ? 'stroke-gray-300' : 'stroke-gray-400 group-hover:stroke-accent'"
                     fill="none" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M17 20h5v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2h5" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="12" cy="7" r="4" stroke-width="2"/>
                </svg>
                Nutzer
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium text-gray-700 dark:text-gray-200 hover:bg-accent/10 dark:hover:bg-white/10 hover:text-accent dark:hover:text-white transition group">
                <svg class="w-5 h-5"
                     :class="darkMode ? 'stroke-gray-300' : 'stroke-gray-400 group-hover:stroke-accent'"
                     fill="none" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 17v-2a4 4 0 00-4-4H3m0 0V7a4 4 0 014-4h10a4 4 0 014 4v4m-2 4v2m-4 0h-4"
                          stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Berichte
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium text-gray-700 dark:text-gray-200 hover:bg-accent/10 dark:hover:bg-white/10 hover:text-accent dark:hover:text-white transition group">
                <svg class="w-5 h-5"
                     :class="darkMode ? 'stroke-gray-300' : 'stroke-gray-400 group-hover:stroke-accent'"
                     fill="none" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                          stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Einstellungen
            </a>
        </nav>
        <div class="p-5 mt-auto border-t border-gray-200 dark:border-gray-800 text-xs text-gray-400 dark:text-gray-500">
            © {{ now()->year }} Company Inc.
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col items-center justify-start py-10 px-4 md:px-10 bg-gray-50 dark:bg-primary transition-all">
        <!-- Orta kısımda İstatistik Kartları -->
        <section class="w-full max-w-4xl grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
            <!-- Dollar -->
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg p-4 flex flex-col items-center">
                <div class="flex items-center gap-2">
                    <span class="text-2xl font-black text-green-500">$</span>
                    <div class="text-lg font-bold text-gray-900 dark:text-white">US-Dollar</div>
                </div>
                <div class="text-lg font-bold mt-2 text-gray-800 dark:text-gray-100" x-text="loading ? '...' : kurse.usd ? kurse.usd.toFixed(2) : 'Fehler'"></div>
                <div class="flex items-center mt-1 text-xs">
                    <span class="text-green-500">Aktuell</span>
                    <span class="ml-2 text-gray-400">EUR / USD</span>
                </div>
            </div>
            <!-- Euro -->
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg p-4 flex flex-col items-center">
                <div class="flex items-center gap-2">
                    <span class="text-2xl font-black text-indigo-500">€</span>
                    <div class="text-lg font-bold text-gray-900 dark:text-white">Euro</div>
                </div>
                <div class="text-lg font-bold mt-2 text-gray-800 dark:text-gray-100" x-text="loading ? '...' : kurse.eur ? kurse.eur.toFixed(2) : 'Fehler'"></div>
                <div class="flex items-center mt-1 text-xs">
                    <span class="text-green-500">Basis</span>
                    <span class="ml-2 text-gray-400">EUR</span>
                </div>
            </div>
            <!-- Gold -->
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg p-4 flex flex-col items-center">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg>
                    <div class="text-lg font-bold text-gray-900 dark:text-white">Gold (g)</div>
                </div>
                <div class="text-lg font-bold mt-2 text-gray-800 dark:text-gray-100" x-text="loading ? '...' : kurse.gold ? kurse.gold + ' TRY' : 'N/A'"></div>
                <div class="flex items-center mt-1 text-xs">
                    <span class="text-yellow-500">Ungefähre Angabe</span>
                </div>
            </div>
            <!-- Wetter -->
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg p-4 flex flex-col items-center">
                <div class="flex items-center gap-2">
                    <span class="text-2xl" x-text="weather.icon || '🌤️'"></span>
                    <div class="text-lg font-bold text-gray-900 dark:text-white" x-text="weather.city"></div>
                </div>
                <div class="text-lg font-bold mt-2 text-gray-800 dark:text-gray-100">
                    <span x-text="loading ? '...' : weather.temp ? (weather.temp + '°C') : 'N/A'"></span>
                </div>
                <div class="flex items-center mt-1 text-xs">
                    <span class="text-blue-500" x-text="weather.desc || '-'"></span>
                </div>
            </div>
        </section>
        <!-- Diğer içerikler (trends, haberler vs.) ... aşağıya bırakılabilir ... -->
    </main>
</div>

<!-- Footer: Daha sade, dar, soft -->
<footer class="w-full border-t border-gray-200 dark:border-gray-800 bg-white/90 dark:bg-navbar/80 backdrop-blur-sm mt-auto">
    <div class="max-w-3xl mx-auto px-4 py-4 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-2">
                <span class="inline-block p-1 rounded-full bg-accent/20">
                    <svg class="w-5 h-5 text-accent dark:text-white" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 4v16m8-8H4" />
                    </svg>
                </span>
            <span class="font-bold text-base text-primary dark:text-white">erbogan</span>
        </div>
        <div class="flex flex-wrap items-center gap-4 text-xs text-gray-500 dark:text-gray-300">
            <a href="https://github.com/erbogan" target="_blank" class="hover:text-accent dark:hover:text-white transition">GitHub</a>
            <a href="mailto:erbogan@protonmail.com" class="hover:text-accent dark:hover:text-white transition">E-Mail</a>
        </div>
        <div class="text-xs text-gray-400 dark:text-gray-500 text-center sm:text-right">
            © {{ now()->year }} erbogan.
        </div>
    </div>
</footer>
</body>
<script src="//unpkg.com/alpinejs" defer></script>
</html>
