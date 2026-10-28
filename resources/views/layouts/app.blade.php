<!DOCTYPE html>
<html lang="es" class="h-full bg-[#f8fafc]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'EduCapacita') - Plataforma Académica y Gestión de Matrículas</title>
    
    <!-- Google Fonts: Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS (Vite + CDN fallback con tema Outfit y paleta personalizada) -->
    @if(file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Outfit', 'sans-serif'],
                            outfit: ['Outfit', 'sans-serif'],
                        },
                        colors: {
                            brand: {
                                50: '#ecfdf5',
                                100: '#d1fae5',
                                200: '#a7f3d0',
                                300: '#6ee7b7',
                                400: '#34d399',
                                500: '#10b981',
                                600: '#059669',
                                700: '#047857',
                                800: '#065f46',
                                900: '#064e3b',
                            },
                            navy: {
                                800: '#0f172a',
                                900: '#0b1322',
                                950: '#070c18',
                            }
                        }
                    }
                }
            }
        </script>
    @endif

    <style>
        * { font-family: 'Outfit', sans-serif; }
        
        /* Efecto de scrollbar moderno y elegante */
        ::-webkit-scrollbar {
            width: 7px;
            height: 7px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        @media print {
            .no-print { display: none !important; }
            .print-only { display: block !important; }
            body { background: white !important; }
            main { padding: 0 !important; margin: 0 !important; }
        }
    </style>
</head>
<body class="h-full antialiased text-slate-800 bg-[#f8fafc] flex flex-col md:flex-row min-h-screen">

    <!-- Fondo de superposición móvil -->
    <div id="mobile-sidebar-backdrop" onclick="toggleMobileSidebar()" class="fixed inset-0 bg-slate-950/60 backdrop-blur-sm z-40 hidden md:hidden transition-opacity"></div>

    <!-- Barra Lateral de Navegación Exclusiva -->
    <aside id="sidebar" class="fixed md:static inset-y-0 left-0 z-50 w-72 bg-gradient-to-b from-[#09111e] via-[#0d1829] to-[#070d18] text-white flex-shrink-0 flex flex-col justify-between no-print shadow-2xl border-r border-teal-500/10 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">
        <div class="flex-1 overflow-y-auto">
            <!-- Logotipo y Marca Institucional -->
            <div class="p-6 border-b border-slate-800/80 bg-slate-950/40 flex items-center justify-between">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3.5 group">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-teal-400 via-emerald-500 to-cyan-500 flex items-center justify-center text-slate-950 font-black shadow-lg shadow-teal-500/25 group-hover:scale-105 group-hover:rotate-2 transition-all">
                        <svg class="w-6 h-6 text-slate-950" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center space-x-1.5">
                            <span class="text-lg font-black tracking-tight text-white">EduCapacita</span>
                            <span class="px-1.5 py-0.5 text-[9px] font-black uppercase tracking-wider bg-teal-500/20 text-teal-300 border border-teal-500/30 rounded-md">PRO</span>
                        </div>
                        <p class="text-[11px] text-teal-400/80 font-medium tracking-wide">Plataforma Académica</p>
                    </div>
                </a>
                <button type="button" onclick="toggleMobileSidebar()" class="md:hidden text-slate-400 hover:text-white p-1 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Navegación y Enlaces -->
            <nav class="p-4 space-y-1.5 text-sm font-medium">
                
                <div class="pt-2 pb-1.5 px-3 text-[10px] font-black text-teal-400/60 uppercase tracking-widest">Principal</div>

                <a href="{{ route('dashboard') }}" class="flex items-center px-3.5 py-2.5 rounded-xl transition-all duration-200 group {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-teal-500/25 via-cyan-500/15 to-transparent text-white font-semibold border-l-4 border-teal-400 shadow-[0_0_20px_rgba(20,184,166,0.15)]' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-colors {{ request()->routeIs('dashboard') ? 'bg-teal-500 text-slate-950 font-bold shadow-md shadow-teal-500/30' : 'bg-slate-800/80 text-slate-400 group-hover:bg-slate-700 group-hover:text-teal-300' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </div>
                    <span>Panel de Control</span>
                </a>

                <div class="pt-5 pb-1.5 px-3 text-[10px] font-black text-teal-400/60 uppercase tracking-widest">Gestión Académica</div>

                <!-- Cursos -->
                <a href="{{ route('cursos.index') }}" class="flex items-center px-3.5 py-2.5 rounded-xl transition-all duration-200 group {{ request()->routeIs('cursos.*') ? 'bg-gradient-to-r from-teal-500/25 via-cyan-500/15 to-transparent text-white font-semibold border-l-4 border-teal-400 shadow-[0_0_20px_rgba(20,184,166,0.15)]' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-colors {{ request()->routeIs('cursos.*') ? 'bg-teal-500 text-slate-950 font-bold shadow-md shadow-teal-500/30' : 'bg-slate-800/80 text-slate-400 group-hover:bg-slate-700 group-hover:text-teal-300' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <span>Cursos Ofertados</span>
                </a>

                <!-- Paralelos y Horarios -->
                <a href="{{ route('paralelos.index') }}" class="flex items-center px-3.5 py-2.5 rounded-xl transition-all duration-200 group {{ request()->routeIs('paralelos.*') ? 'bg-gradient-to-r from-teal-500/25 via-cyan-500/15 to-transparent text-white font-semibold border-l-4 border-teal-400 shadow-[0_0_20px_rgba(20,184,166,0.15)]' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-colors {{ request()->routeIs('paralelos.*') ? 'bg-teal-500 text-slate-950 font-bold shadow-md shadow-teal-500/30' : 'bg-slate-800/80 text-slate-400 group-hover:bg-slate-700 group-hover:text-teal-300' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <span>Paralelos y Horarios</span>
                </a>

                <!-- Inscripciones / Matrículas -->
                <a href="{{ route('inscripciones.index') }}" class="flex items-center px-3.5 py-2.5 rounded-xl transition-all duration-200 group {{ request()->routeIs('inscripciones.*') ? 'bg-gradient-to-r from-teal-500/25 via-cyan-500/15 to-transparent text-white font-semibold border-l-4 border-teal-400 shadow-[0_0_20px_rgba(20,184,166,0.15)]' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-colors {{ request()->routeIs('inscripciones.*') ? 'bg-teal-500 text-slate-950 font-bold shadow-md shadow-teal-500/30' : 'bg-slate-800/80 text-slate-400 group-hover:bg-slate-700 group-hover:text-teal-300' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1 flex items-center justify-between">
                        <span>Inscripciones</span>
                        <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-teal-500/20 text-teal-300 border border-teal-500/30">Activas</span>
                    </div>
                </a>

                <!-- Participantes -->
                <a href="{{ route('participantes.index') }}" class="flex items-center px-3.5 py-2.5 rounded-xl transition-all duration-200 group {{ request()->routeIs('participantes.*') ? 'bg-gradient-to-r from-teal-500/25 via-cyan-500/15 to-transparent text-white font-semibold border-l-4 border-teal-400 shadow-[0_0_20px_rgba(20,184,166,0.15)]' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-colors {{ request()->routeIs('participantes.*') ? 'bg-teal-500 text-slate-950 font-bold shadow-md shadow-teal-500/30' : 'bg-slate-800/80 text-slate-400 group-hover:bg-slate-700 group-hover:text-teal-300' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <span>Participantes</span>
                </a>

                <!-- Instructores -->
                <a href="{{ route('instructores.index') }}" class="flex items-center px-3.5 py-2.5 rounded-xl transition-all duration-200 group {{ request()->routeIs('instructores.*') ? 'bg-gradient-to-r from-teal-500/25 via-cyan-500/15 to-transparent text-white font-semibold border-l-4 border-teal-400 shadow-[0_0_20px_rgba(20,184,166,0.15)]' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-colors {{ request()->routeIs('instructores.*') ? 'bg-teal-500 text-slate-950 font-bold shadow-md shadow-teal-500/30' : 'bg-slate-800/80 text-slate-400 group-hover:bg-slate-700 group-hover:text-teal-300' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <span>Cuerpo Docente</span>
                </a>

                <!-- Categorías -->
                <a href="{{ route('categorias.index') }}" class="flex items-center px-3.5 py-2.5 rounded-xl transition-all duration-200 group {{ request()->routeIs('categorias.*') ? 'bg-gradient-to-r from-teal-500/25 via-cyan-500/15 to-transparent text-white font-semibold border-l-4 border-teal-400 shadow-[0_0_20px_rgba(20,184,166,0.15)]' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-colors {{ request()->routeIs('categorias.*') ? 'bg-teal-500 text-slate-950 font-bold shadow-md shadow-teal-500/30' : 'bg-slate-800/80 text-slate-400 group-hover:bg-slate-700 group-hover:text-teal-300' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <span>Áreas / Categorías</span>
                </a>

                <div class="pt-5 pb-1.5 px-3 text-[10px] font-black text-teal-400/60 uppercase tracking-widest">Reportes & Analítica</div>

                <!-- Reporte Inscritos -->
                <a href="{{ route('reportes.inscritos_por_paralelo') }}" class="flex items-center px-3.5 py-2.5 rounded-xl transition-all duration-200 group {{ request()->routeIs('reportes.inscritos_por_paralelo') ? 'bg-gradient-to-r from-teal-500/25 via-cyan-500/15 to-transparent text-white font-semibold border-l-4 border-teal-400 shadow-[0_0_20px_rgba(20,184,166,0.15)]' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-colors {{ request()->routeIs('reportes.inscritos_por_paralelo') ? 'bg-teal-500 text-slate-950 font-bold shadow-md shadow-teal-500/30' : 'bg-slate-800/80 text-slate-400 group-hover:bg-slate-700 group-hover:text-teal-300' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <span>Inscritos por Paralelo</span>
                </a>

                <!-- Reporte Ingresos (Solo Administrador) -->
                @can('admin')
                <a href="{{ route('reportes.ingresos_por_curso') }}" class="flex items-center px-3.5 py-2.5 rounded-xl transition-all duration-200 group {{ request()->routeIs('reportes.ingresos_por_curso') ? 'bg-gradient-to-r from-teal-500/25 via-cyan-500/15 to-transparent text-white font-semibold border-l-4 border-teal-400 shadow-[0_0_20px_rgba(20,184,166,0.15)]' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-colors {{ request()->routeIs('reportes.ingresos_por_curso') ? 'bg-teal-500 text-slate-950 font-bold shadow-md shadow-teal-500/30' : 'bg-slate-800/80 text-slate-400 group-hover:bg-slate-700 group-hover:text-teal-300' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span>Ingresos Económicos</span>
                </a>
                @endcan

                <div class="pt-5 pb-1.5 px-3 text-[10px] font-black text-teal-400/60 uppercase tracking-widest">Información & Alcance</div>

                <!-- Presentación del Proyecto -->
                <a href="{{ route('presentacion') }}" class="flex items-center px-3.5 py-2.5 rounded-xl transition-all duration-200 group {{ request()->routeIs('presentacion') ? 'bg-gradient-to-r from-teal-500/25 via-cyan-500/15 to-transparent text-white font-semibold border-l-4 border-teal-400 shadow-[0_0_20px_rgba(20,184,166,0.15)]' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-colors {{ request()->routeIs('presentacion') ? 'bg-teal-500 text-slate-950 font-bold shadow-md shadow-teal-500/30' : 'bg-slate-800/80 text-slate-400 group-hover:bg-slate-700 group-hover:text-teal-300' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1 flex items-center justify-between">
                        <span>Presentación</span>
                        <span class="px-1.5 py-0.5 text-[9px] font-black uppercase tracking-wider bg-cyan-500/20 text-cyan-300 border border-cyan-500/30 rounded">Info</span>
                    </div>
                </a>

            </nav>
        </div>

        <!-- Tarjeta de Usuario en Barra Lateral -->
        <div class="p-4 border-t border-slate-800/80 bg-slate-950/70">
            @auth
                <div class="flex items-center justify-between p-2 rounded-xl bg-slate-900/90 border border-slate-800">
                    <div class="flex items-center space-x-3 overflow-hidden">
                        <div class="relative">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-teal-400 to-cyan-500 text-slate-950 font-black flex items-center justify-center text-sm shadow-md">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-emerald-400 border-2 border-slate-950 rounded-full"></span>
                        </div>
                        <div class="truncate">
                            <p class="text-xs font-bold text-white truncate">{{ Auth::user()->name }}</p>
                            @if(Auth::user()->esAdmin())
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-black uppercase tracking-wider bg-amber-500/20 text-amber-300 border border-amber-500/30">Administrador</span>
                            @else
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-black uppercase tracking-wider bg-teal-500/20 text-teal-300 border border-teal-500/30">Usuario Regular</span>
                            @endif
                        </div>
                    </div>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" title="Cerrar Sesión" class="p-2 text-slate-400 hover:text-rose-400 hover:bg-rose-500/10 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            @endauth
        </div>
    </aside>

    <!-- Área Principal de Contenido -->
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto min-h-screen">
        
        <!-- Barra Superior (Topbar) Moderna y Estilizada -->
        <header class="sticky top-0 z-30 bg-white/90 backdrop-blur-md border-b border-slate-200/80 px-4 sm:px-8 py-3.5 flex items-center justify-between no-print shadow-xs">
            <div class="flex items-center space-x-3 sm:space-x-4">
                <button type="button" onclick="toggleMobileSidebar()" class="md:hidden p-2 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-xl transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>

                <div>
                    <div class="flex items-center space-x-2">
                        <span class="text-xs font-semibold text-teal-600 uppercase tracking-wider flex items-center">
                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            EduCapacita
                        </span>
                        <span class="text-slate-300">&bull;</span>
                        <span class="text-xs text-slate-500 font-medium">@yield('titulo', 'Gestión')</span>
                    </div>
                    <h2 class="text-base sm:text-lg font-black text-slate-900 tracking-tight leading-tight">@yield('titulo', 'Panel Principal')</h2>
                </div>
            </div>

            <!-- Acciones y Estado en Barra Superior -->
            <div class="flex items-center space-x-2 sm:space-x-4">
                <!-- Badge de Período Académico -->
                <div class="hidden lg:flex items-center space-x-2 px-3 py-1.5 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>Período Académico 2026-I &bull; Activo</span>
                </div>

                <!-- Botón de Presentación del Proyecto -->
                <a href="{{ route('presentacion') }}" class="hidden sm:inline-flex items-center space-x-1.5 px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                    <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Presentación</span>
                </a>

                <!-- Botón de Acción Rápida: Nueva Matrícula -->
                <a href="{{ route('inscripciones.create') }}" class="inline-flex items-center px-3.5 py-2 rounded-xl bg-gradient-to-r from-teal-500 via-emerald-500 to-cyan-500 hover:from-teal-600 hover:to-cyan-600 text-slate-950 font-bold text-xs uppercase tracking-wider shadow-md shadow-teal-500/20 transition-all hover:scale-102">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Nueva Matrícula</span>
                </a>

                @auth
                    <!-- Avatar con Inicial en Topbar -->
                    <div class="hidden sm:flex items-center space-x-2 pl-2 border-l border-slate-200">
                        <div class="w-8 h-8 rounded-lg bg-slate-900 text-white font-bold flex items-center justify-center text-xs">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <span class="text-xs font-semibold text-slate-700 hidden xl:inline">{{ Auth::user()->name }}</span>
                    </div>
                @endauth
            </div>
        </header>

        <!-- Contenedor Principal de la Página -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-7xl w-full mx-auto">
            <!-- Mensaje Flash: Éxito -->
            @if(session('success') || session('exito'))
                <div class="mb-6 rounded-2xl bg-gradient-to-r from-emerald-500/10 via-teal-500/5 to-transparent border-l-4 border-emerald-500 p-4.5 flex items-center space-x-3.5 text-emerald-950 shadow-xs no-print">
                    <div class="w-9 h-9 rounded-xl bg-emerald-500 text-white flex items-center justify-center flex-shrink-0 shadow-md shadow-emerald-500/30">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-bold text-emerald-800 uppercase tracking-wider">Operación Exitosa</p>
                        <p class="text-sm font-semibold text-emerald-950 mt-0.5">{{ session('success') ?? session('exito') }}</p>
                    </div>
                </div>
            @endif

            <!-- Mensaje Flash: Información -->
            @if(session('info'))
                <div class="mb-6 rounded-2xl bg-gradient-to-r from-teal-500/10 via-cyan-500/5 to-transparent border-l-4 border-teal-500 p-4.5 flex items-center space-x-3.5 text-teal-950 shadow-xs no-print">
                    <div class="w-9 h-9 rounded-xl bg-teal-500 text-white flex items-center justify-center flex-shrink-0 shadow-md shadow-teal-500/30">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-bold text-teal-800 uppercase tracking-wider">Aviso Informativo</p>
                        <p class="text-sm font-semibold text-teal-950 mt-0.5">{{ session('info') }}</p>
                    </div>
                </div>
            @endif

            <!-- Mensaje Flash: Error General -->
            @if(session('error') || session('alerta'))
                <div class="mb-6 rounded-2xl bg-gradient-to-r from-rose-500/10 via-red-500/5 to-transparent border-l-4 border-rose-500 p-4.5 flex items-center space-x-3.5 text-rose-950 shadow-xs no-print">
                    <div class="w-9 h-9 rounded-xl bg-rose-500 text-white flex items-center justify-center flex-shrink-0 shadow-md shadow-rose-500/30">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-bold text-rose-800 uppercase tracking-wider">Alerta del Sistema</p>
                        <p class="text-sm font-semibold text-rose-950 mt-0.5">{{ session('error') ?? session('alerta') }}</p>
                    </div>
                </div>
            @endif

            <!-- Banner de Errores de Validación Académica (Para rechazo por cupo, horario cruzado, fechas inválidas o participantes repetidos) -->
            @if($errors->any())
                <div class="mb-6 rounded-2xl bg-rose-50/90 border-2 border-rose-300/80 p-5 text-rose-950 shadow-sm no-print">
                    <div class="flex items-start space-x-3.5">
                        <div class="w-10 h-10 rounded-xl bg-rose-600 text-white flex items-center justify-center flex-shrink-0 mt-0.5 shadow-md shadow-rose-600/30">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-extrabold text-rose-900 tracking-tight">Atención: Se presentaron las siguientes validaciones académicas:</h3>
                            <ul class="mt-2.5 list-disc list-inside text-sm font-semibold text-rose-800 space-y-1.5 bg-white/80 p-3.5 rounded-xl border border-rose-200">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            @yield('contenido')
        </main>
    </div>

    <!-- Script de control móvil de navegación -->
    <script>
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('mobile-sidebar-backdrop');
            
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
            }
        }
    </script>
</body>
</html>
