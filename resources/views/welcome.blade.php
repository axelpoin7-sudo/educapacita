<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduCapacita Master - Plataforma de Capacitación y Matrículas</title>
    
    <!-- Google Fonts Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="min-h-full bg-[#06090e] text-slate-100 flex flex-col justify-between relative overflow-x-hidden">
    <!-- Ambient glowing backgrounds -->
    <div class="absolute -top-40 -left-40 w-[500px] h-[500px] bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-1/3 -right-40 w-[600px] h-[600px] bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 left-1/4 w-[500px] h-[500px] bg-cyan-500/5 rounded-full blur-3xl pointer-events-none"></div>

    <!-- Barra Superior de Navegación -->
    <header class="w-full max-w-7xl mx-auto px-6 py-6 flex items-center justify-between relative z-10">
        <div class="flex items-center space-x-3.5">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-emerald-500 via-teal-500 to-cyan-400 flex items-center justify-center text-slate-950 font-black shadow-xl shadow-emerald-500/20">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <span class="text-xl font-black tracking-tight text-white leading-tight">EduCapacita</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-emerald-400/10 text-emerald-300 border border-emerald-400/20">Master Pro</span>
                </div>
                <span class="block text-[11px] text-teal-400 font-bold uppercase tracking-wider">Centro de Educación Superior & Certificación</span>
            </div>
        </div>

        <nav class="flex items-center space-x-3">
            <a href="{{ route('presentacion') }}" class="px-5 py-2.5 rounded-2xl bg-slate-900/90 hover:bg-slate-800 border border-slate-800 text-teal-300 font-bold text-xs transition">
                Presentación del Proyecto
            </a>
            @auth
                <a href="{{ route('dashboard') }}" class="px-6 py-2.5 rounded-2xl bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-black text-xs shadow-lg shadow-emerald-500/25 transition transform hover:-translate-y-0.5">
                    Ir al Panel &rarr;
                </a>
            @else
                <a href="{{ route('login') }}" class="px-6 py-2.5 rounded-2xl bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-black text-xs shadow-lg shadow-emerald-500/25 transition transform hover:-translate-y-0.5">
                    Iniciar Sesión
                </a>
            @endauth
        </nav>
    </header>

    <!-- Contenido Principal (Hero) -->
    <main class="w-full max-w-7xl mx-auto px-6 py-12 flex-1 flex flex-col justify-center relative z-10">
        <div class="text-center max-w-3xl mx-auto space-y-6">
            <div class="inline-flex items-center space-x-2 px-4 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-300 text-xs font-bold">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>Motor de Validación Académica en Tiempo Real Activo</span>
            </div>

            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white tracking-tight leading-tight">
                Gestión Integral de Cursos, <br/>
                <span class="bg-gradient-to-r from-emerald-400 via-teal-300 to-cyan-400 bg-clip-text text-transparent">Horarios y Matrículas Seguras</span>
            </h1>

            <p class="text-base sm:text-lg text-slate-400 leading-relaxed max-w-2xl mx-auto font-medium">
                Control estricto de fechas de vigencia, prevención de duplicados por alumno y curso, validación de cruce de horarios y emisión oficial de vouchers académicos.
            </p>

            <div class="pt-4 flex flex-wrap justify-center gap-4">
                <a href="{{ route('login') }}" class="px-8 py-4 rounded-2xl bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-black text-sm shadow-xl shadow-emerald-500/30 transition transform hover:-translate-y-0.5">
                    Acceder al Sistema Académico &rarr;
                </a>
                <a href="{{ route('presentacion') }}" class="px-8 py-4 rounded-2xl bg-slate-900/90 hover:bg-slate-800 border border-slate-700 text-teal-300 font-bold text-sm transition flex items-center gap-2">
                    <span>📖 Presentación del Proyecto</span>
                </a>
            </div>
        </div>

        <!-- Tarjetas de Módulos del Sistema -->
        <div id="caracteristicas" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-16">
            <!-- Módulo 1 -->
            <div class="bg-slate-900/60 backdrop-blur-md border border-slate-800/80 rounded-3xl p-6 hover:border-emerald-500/40 transition">
                <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h3 class="text-base font-black text-white mb-2">Cursos & Categorías</h3>
                <p class="text-xs text-slate-400 leading-relaxed font-medium">
                    Catálogo con títulos únicos verificados por base de datos, aranceles oficiales, carga horaria y portadas promocionales.
                </p>
            </div>

            <!-- Módulo 2 -->
            <div class="bg-slate-900/60 backdrop-blur-md border border-slate-800/80 rounded-3xl p-6 hover:border-teal-500/40 transition">
                <div class="w-12 h-12 rounded-2xl bg-teal-500/10 border border-teal-500/20 text-teal-400 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-base font-black text-white mb-2">Horarios & Aforos</h3>
                <p class="text-xs text-slate-400 leading-relaxed font-medium">
                    Paralelos con validación de hora fin posterior a inicio, nombres únicos por curso y medidores de ocupación en tiempo real.
                </p>
            </div>

            <!-- Módulo 3 -->
            <div class="bg-slate-900/60 backdrop-blur-md border border-slate-800/80 rounded-3xl p-6 hover:border-cyan-500/40 transition">
                <div class="w-12 h-12 rounded-2xl bg-cyan-500/10 border border-cyan-500/20 text-cyan-400 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h3 class="text-base font-black text-white mb-2">Validaciones Estrictas</h3>
                <p class="text-xs text-slate-400 leading-relaxed font-medium">
                    Bloqueo de inscripciones fuera de fecha de inicio/fin, filtrado dinámico de curso/paralelo y prevención de alumnos duplicados.
                </p>
            </div>

            <!-- Módulo 4 -->
            <div class="bg-slate-900/60 backdrop-blur-md border border-slate-800/80 rounded-3xl p-6 hover:border-emerald-500/40 transition">
                <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-base font-black text-white mb-2">Vouchers & Reportes</h3>
                <p class="text-xs text-slate-400 leading-relaxed font-medium">
                    Comprobantes académicos oficiales imprimibles con código hash de verificación, nómina de matriculados y balance financiero.
                </p>
            </div>
        </div>
    </main>

    <!-- Pie de Página -->
    <footer class="w-full max-w-7xl mx-auto px-6 py-6 border-t border-slate-900 text-xs text-slate-500 flex flex-col sm:flex-row items-center justify-between gap-3 relative z-10">
        <p>EduCapacita Master &bull; Sistema Académico de Formación Continua.</p>
        <p class="text-slate-400 font-medium">Desarrollado con Laravel 12 y PostgreSQL</p>
    </footer>
</body>
</html>
