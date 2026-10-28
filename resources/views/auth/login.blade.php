<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - EduCapacita Master</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="min-h-full flex items-center justify-center p-4 sm:p-6 bg-[#06090e] relative overflow-hidden">
    <!-- Ambient glowing orbs -->
    <div class="absolute -top-40 -left-40 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-cyan-500/5 rounded-full blur-3xl pointer-events-none"></div>

    <div class="w-full max-w-md relative z-10">
        <!-- Brand Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-tr from-emerald-500 via-teal-500 to-cyan-400 text-slate-950 shadow-xl shadow-emerald-500/20 mb-4 font-black">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
            <div class="flex items-center justify-center gap-2">
                <h1 class="text-3xl font-black text-white tracking-tight">EduCapacita</h1>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-emerald-400/10 text-emerald-300 border border-emerald-400/20">Pro</span>
            </div>
            <p class="text-sm text-slate-400 mt-1 font-medium">Gestión Académica y Control de Matrículas</p>
        </div>

        <!-- Glassy Login Card -->
        <div class="bg-slate-900/70 backdrop-blur-xl border border-slate-800 rounded-3xl p-7 sm:p-9 shadow-2xl shadow-black/80">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-xl font-black text-white">Acceso al Sistema</h2>
                    <p class="text-xs text-slate-400">Ingresa tus credenciales autorizadas</p>
                </div>
                <div class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></div>
            </div>

            @if(session('info'))
                <div class="mb-5 rounded-2xl bg-teal-500/10 border border-teal-500/30 p-3.5 text-xs text-teal-300 flex items-center gap-2">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>{{ session('info') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-5 rounded-2xl bg-rose-500/10 border border-rose-500/30 p-3.5 text-xs text-rose-300 space-y-1">
                    @foreach($errors->all() as $error)
                        <div class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 shrink-0 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            <span>{{ $error }}</span>
                        </div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1.5">Correo Institucional</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                        </span>
                        <input type="email" id="email" name="email" value="{{ old('email', 'admin@capacitacion.com') }}" required autofocus
                               class="w-full pl-10 pr-4 py-3 rounded-2xl bg-slate-950/70 border border-slate-700/80 text-white placeholder-slate-500 focus:outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/15 text-sm transition">
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-xs font-bold text-slate-300 uppercase tracking-wider">Contraseña</label>
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </span>
                        <input type="password" id="password" name="password" value="password" required
                               class="w-full pl-10 pr-4 py-3 rounded-2xl bg-slate-950/70 border border-slate-700/80 text-white placeholder-slate-500 focus:outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/15 text-sm transition">
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs text-slate-400 pt-1">
                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-700 bg-slate-950 text-emerald-500 focus:ring-emerald-500/30 focus:ring-offset-0">
                        <span>Recordar este equipo</span>
                    </label>
                </div>

                <button type="submit"
                        class="w-full mt-2 py-3.5 px-4 rounded-2xl bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-black text-sm shadow-lg shadow-emerald-500/25 transition-all transform hover:-translate-y-0.5 active:translate-y-0">
                    Ingresar al Panel Académico &rarr;
                </button>
            </form>

            <!-- Quick Auto-Fill Demo Credentials -->
            <div class="mt-6 pt-5 border-t border-slate-800 text-xs text-slate-400">
                <p class="font-bold text-slate-300 uppercase tracking-wider text-[11px] mb-2.5">Acceso Rápido para Pruebas:</p>
                <div class="grid grid-cols-2 gap-2">
                    <button type="button" onclick="document.getElementById('email').value='admin@capacitacion.com'; document.getElementById('password').value='password';"
                            class="p-2.5 rounded-xl bg-slate-950/60 border border-slate-800 hover:border-emerald-500/40 text-left transition group">
                        <p class="text-[10px] font-bold text-emerald-400 uppercase">Rol Administrador</p>
                        <p class="text-[11px] text-slate-300 truncate font-mono mt-0.5">admin@...</p>
                    </button>
                    <button type="button" onclick="document.getElementById('email').value='user@capacitacion.com'; document.getElementById('password').value='password';"
                            class="p-2.5 rounded-xl bg-slate-950/60 border border-slate-800 hover:border-cyan-500/40 text-left transition group">
                        <p class="text-[10px] font-bold text-cyan-400 uppercase">Rol Coordinador</p>
                        <p class="text-[11px] text-slate-300 truncate font-mono mt-0.5">user@...</p>
                    </button>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-5">
            <a href="{{ route('presentacion') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-teal-400 hover:text-teal-300 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>¿De qué trata este proyecto? Ver Presentación Oficial &rarr;</span>
            </a>
        </div>

        <p class="text-center text-xs text-slate-600 mt-4 font-medium">
            &copy; {{ date('Y') }} EduCapacita Master. Todos los derechos reservados.
        </p>
    </div>
</body>
</html>
