<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presentación del Proyecto - EduCapacita Master</title>
    
    <!-- Google Fonts Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="min-h-full bg-[#06090e] text-slate-100 flex flex-col justify-between relative overflow-x-hidden selection:bg-emerald-500 selection:text-slate-950">
    <!-- Ambient glowing backgrounds -->
    <div class="absolute -top-40 -left-40 w-[600px] h-[600px] bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-1/3 -right-40 w-[600px] h-[600px] bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-10 left-1/4 w-[500px] h-[500px] bg-cyan-500/5 rounded-full blur-3xl pointer-events-none"></div>

    <!-- Barra de Navegación Superior -->
    <header class="w-full max-w-7xl mx-auto px-6 py-6 flex items-center justify-between relative z-10 border-b border-slate-900/80">
        <div class="flex items-center space-x-3.5">
            <a href="{{ url('/') }}" class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-emerald-500 via-teal-500 to-cyan-400 flex items-center justify-center text-slate-950 font-black shadow-xl shadow-emerald-500/20 hover:scale-105 transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </a>
            <div>
                <div class="flex items-center gap-2">
                    <span class="text-xl font-black tracking-tight text-white leading-tight">EduCapacita</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-emerald-400/10 text-emerald-300 border border-emerald-400/20">Master Pro</span>
                </div>
                <span class="block text-[11px] text-teal-400 font-bold uppercase tracking-wider">Presentación y Memoria Técnica</span>
            </div>
        </div>

        <nav class="flex items-center space-x-3">
            @auth
                <a href="{{ route('dashboard') }}" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-black text-xs shadow-lg shadow-emerald-500/20 transition transform hover:-translate-y-0.5">
                    Volver al Panel &rarr;
                </a>
            @else
                <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-black text-xs shadow-lg shadow-emerald-500/20 transition transform hover:-translate-y-0.5">
                    Iniciar Sesión
                </a>
            @endauth
        </nav>
    </header>

    <!-- Contenido Principal -->
    <main class="w-full max-w-7xl mx-auto px-6 py-12 flex-1 space-y-20 relative z-10">

        <!-- 1. Hero Section -->
        <section class="text-center max-w-4xl mx-auto space-y-6 pt-6">
            <div class="inline-flex items-center space-x-2 px-4 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-300 text-xs font-bold">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>Documento Oficial de Alcance y Reglas de Negocio</span>
            </div>

            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white tracking-tight leading-tight">
                ¿De qué trata <span class="bg-gradient-to-r from-emerald-400 via-teal-300 to-cyan-400 bg-clip-text text-transparent">EduCapacita Master</span>?
            </h1>

            <p class="text-base sm:text-lg text-slate-400 leading-relaxed max-w-3xl mx-auto font-medium">
                EduCapacita Master es una plataforma integral de nivel empresarial diseñada para coordinar programas de capacitación continua, control de vacantes en tiempo real, matriculación académica segura y emisión de comprobantes oficiales con firma autorizada.
            </p>

            <div class="pt-4 flex flex-wrap items-center justify-center gap-4">
                <a href="#diferencia-roles" class="px-7 py-3.5 rounded-2xl bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-black text-xs shadow-xl shadow-emerald-500/20 transition transform hover:-translate-y-0.5">
                    Ver Matriz de Roles (Admin vs Usuario) &darr;
                </a>
                <a href="#motor-validaciones" class="px-7 py-3.5 rounded-2xl bg-slate-900 hover:bg-slate-800 border border-slate-800 text-slate-300 font-bold text-xs transition">
                    Ver Motor de 5 Validaciones &rarr;
                </a>
            </div>
        </section>

        <!-- 2. Problemática y Solución -->
        <section class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-slate-900/50 backdrop-blur-md border border-rose-500/20 rounded-3xl p-8 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-rose-500/5 rounded-full blur-2xl pointer-events-none"></div>
                <div class="flex items-center gap-3 mb-4">
                    <span class="w-10 h-10 rounded-xl bg-rose-500/10 text-rose-400 font-black flex items-center justify-center text-lg">⚠️</span>
                    <h2 class="text-xl font-black text-white">Problemática Detectada</h2>
                </div>
                <p class="text-xs text-slate-400 leading-relaxed font-medium mb-4">
                    En los sistemas tradicionales de capacitación suelen presentarse fallos críticos de integridad:
                </p>
                <ul class="space-y-2.5 text-xs text-slate-300">
                    <li class="flex items-start gap-2">
                        <span class="text-rose-400 font-bold shrink-0">&times;</span>
                        <span><strong>Fechas inconsistentes:</strong> Alumnos inscritos semanas después de que el curso concluyó o antes de su apertura formal.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-rose-400 font-bold shrink-0">&times;</span>
                        <span><strong>Cursos y horarios no correspondientes:</strong> Asignación equivocada de un paralelo que pertenece a una materia completamente distinta.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-rose-400 font-bold shrink-0">&times;</span>
                        <span><strong>Duplicidad de inscripciones:</strong> Mismo estudiante matriculado múltiples veces en un mismo curso pagando doble arancel innecesariamente.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-rose-400 font-bold shrink-0">&times;</span>
                        <span><strong>Sobrecupo y colisión:</strong> Aulas saturadas más allá del aforo máximo permitido e incompatibilidad horaria con otras materias.</span>
                    </li>
                </ul>
            </div>

            <div class="bg-slate-900/50 backdrop-blur-md border border-emerald-500/20 rounded-3xl p-8 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/5 rounded-full blur-2xl pointer-events-none"></div>
                <div class="flex items-center gap-3 mb-4">
                    <span class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-400 font-black flex items-center justify-center text-lg">🛡️</span>
                    <h2 class="text-xl font-black text-white">Solución con EduCapacita</h2>
                </div>
                <p class="text-xs text-slate-400 leading-relaxed font-medium mb-4">
                    Implementación de un motor robusto de verificación a nivel de controlador, base de datos y vistas reactivas:
                </p>
                <ul class="space-y-2.5 text-xs text-slate-300">
                    <li class="flex items-start gap-2">
                        <span class="text-emerald-400 font-bold shrink-0">&#10003;</span>
                        <span><strong>Ventana de matrícula estricta:</strong> Bloqueo absoluto antes de la fecha de inicio y después de la fecha de fin del paralelo.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-emerald-400 font-bold shrink-0">&#10003;</span>
                        <span><strong>Sincronización Curso & Paralelo:</strong> Filtrado interactivo en JavaScript y validación de correspondencia en el backend.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-emerald-400 font-bold shrink-0">&#10003;</span>
                        <span><strong>Anti-duplicidad por programa:</strong> Verificación de unicidad por participante y curso en todos los paralelos activos.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-emerald-400 font-bold shrink-0">&#10003;</span>
                        <span><strong>Medidor de aforo y cruce horario:</strong> Rechazo instantáneo si no hay cupo o si las horas chocan con otra clase del alumno.</span>
                    </li>
                </ul>
            </div>
        </section>

        <!-- 3. Matriz de Autoridad: Admin vs Usuario -->
        <section id="diferencia-roles" class="space-y-8">
            <div class="text-center max-w-2xl mx-auto space-y-2">
                <span class="px-3 py-1 rounded-full text-xs font-bold bg-teal-500/10 text-teal-300 border border-teal-500/20 uppercase tracking-wider">
                    Seguridad y Autorizaciones
                </span>
                <h2 class="text-3xl font-black text-white">Diferencia de Autoridad: Administrador vs Usuario</h2>
                <p class="text-xs text-slate-400">
                    El sistema separa estrictamente los privilegios operativos. Un usuario regular tiene acceso a consultar la oferta y matricularse, pero no puede alterar la oferta académica ni el cuerpo docente.
                </p>
            </div>

            <!-- Role Cards Comparison -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Tarjeta Administrador -->
                <div class="bg-gradient-to-b from-slate-900 to-slate-950 border-2 border-amber-500/40 rounded-3xl p-8 relative shadow-2xl">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-amber-500/20 text-amber-300 flex items-center justify-center font-black text-xl border border-amber-500/30">
                                👑
                            </div>
                            <div>
                                <h3 class="text-xl font-black text-white">Rol Administrador</h3>
                                <p class="text-xs text-amber-400 font-mono font-bold">admin@capacitacion.com &bull; es_admin = true</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-500/20 text-amber-300 border border-amber-500/30">
                            Autoridad Total
                        </span>
                    </div>

                    <p class="text-xs text-slate-300 font-medium mb-5">
                        Diseñado para la dirección académica y gerencia institucional. Posee control absoluto sobre la plataforma:
                    </p>

                    <div class="space-y-3 text-xs">
                        <div class="p-3 rounded-2xl bg-slate-950/80 border border-slate-800 flex items-start gap-3">
                            <span class="text-emerald-400 font-black">✓</span>
                            <div>
                                <strong class="text-white">Crear, Editar y Eliminar Cursos:</strong>
                                <p class="text-slate-400 text-[11px] mt-0.5">Define nuevos cursos, establece aranceles, horas lectivas y portadas promocionales.</p>
                            </div>
                        </div>
                        <div class="p-3 rounded-2xl bg-slate-950/80 border border-slate-800 flex items-start gap-3">
                            <span class="text-emerald-400 font-black">✓</span>
                            <div>
                                <strong class="text-white">Aperturar y Gestionar Paralelos:</strong>
                                <p class="text-slate-400 text-[11px] mt-0.5">Asigna aulas físicas o virtuales, franjas horarias, cupo máximo y fechas de inicio/fin.</p>
                            </div>
                        </div>
                        <div class="p-3 rounded-2xl bg-slate-950/80 border border-slate-800 flex items-start gap-3">
                            <span class="text-emerald-400 font-black">✓</span>
                            <div>
                                <strong class="text-white">Administración de Instructores y Categorías:</strong>
                                <p class="text-slate-400 text-[11px] mt-0.5">Registra nuevos docentes, actualiza su currículum y organiza las áreas de conocimiento.</p>
                            </div>
                        </div>
                        <div class="p-3 rounded-2xl bg-slate-950/80 border border-slate-800 flex items-start gap-3">
                            <span class="text-emerald-400 font-black">✓</span>
                            <div>
                                <strong class="text-white">Gestión y Anulación de Inscripciones:</strong>
                                <p class="text-slate-400 text-[11px] mt-0.5">Modifica estados de pago (pagada, pendiente, anulada) y libera cupos cuando sea necesario.</p>
                            </div>
                        </div>
                        <div class="p-3 rounded-2xl bg-slate-950/80 border border-slate-800 flex items-start gap-3">
                            <span class="text-emerald-400 font-black">✓</span>
                            <div>
                                <strong class="text-white">Acceso al Reporte Financiero de Ingresos:</strong>
                                <p class="text-slate-400 text-[11px] mt-0.5">Visualiza el balance económico total recaudado por curso y saldos pendientes.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta Usuario Regular -->
                <div class="bg-gradient-to-b from-slate-900 to-slate-950 border-2 border-teal-500/40 rounded-3xl p-8 relative shadow-2xl">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-teal-500/20 text-teal-300 flex items-center justify-center font-black text-xl border border-teal-500/30">
                                🎓
                            </div>
                            <div>
                                <h3 class="text-xl font-black text-white">Rol Usuario Regular</h3>
                                <p class="text-xs text-teal-400 font-mono font-bold">user@capacitacion.com &bull; es_admin = false</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-teal-500/20 text-teal-300 border border-teal-500/30">
                            Consulta y Matrícula
                        </span>
                    </div>

                    <p class="text-xs text-slate-300 font-medium mb-5">
                        Diseñado para estudiantes y participantes. Permite autogestionar su proceso de capacitación:
                    </p>

                    <div class="space-y-3 text-xs">
                        <div class="p-3 rounded-2xl bg-slate-950/80 border border-slate-800 flex items-start gap-3">
                            <span class="text-teal-400 font-black">✓</span>
                            <div>
                                <strong class="text-white">Consultar Catálogo de Cursos Ofertados:</strong>
                                <p class="text-slate-400 text-[11px] mt-0.5">Explora temarios, objetivos, aranceles, horas y paralelos disponibles.</p>
                            </div>
                        </div>
                        <div class="p-3 rounded-2xl bg-slate-950/80 border border-slate-800 flex items-start gap-3">
                            <span class="text-teal-400 font-black">✓</span>
                            <div>
                                <strong class="text-white">Ver Cuerpo Docente e Instructores:</strong>
                                <p class="text-slate-400 text-[11px] mt-0.5">Conoce la trayectoria curricular de los instructores a cargo de cada paralelo.</p>
                            </div>
                        </div>
                        <div class="p-3 rounded-2xl bg-slate-950/80 border border-slate-800 flex items-start gap-3">
                            <span class="text-teal-400 font-black">✓</span>
                            <div>
                                <strong class="text-white">Inscribirse en Cursos y Paralelos:</strong>
                                <p class="text-slate-400 text-[11px] mt-0.5">Realiza su matrícula oficial validando fechas y cupos en tiempo real.</p>
                            </div>
                        </div>
                        <div class="p-3 rounded-2xl bg-slate-950/80 border border-slate-800 flex items-start gap-3">
                            <span class="text-teal-400 font-black">✓</span>
                            <div>
                                <strong class="text-white">Comprobante Oficial Imprimible (Voucher):</strong>
                                <p class="text-slate-400 text-[11px] mt-0.5">Descarga o imprime su comprobante académico con código hash de autenticidad.</p>
                            </div>
                        </div>
                        <div class="p-3 rounded-2xl bg-rose-500/10 border border-rose-500/30 flex items-start gap-3">
                            <span class="text-rose-400 font-black">&times;</span>
                            <div>
                                <strong class="text-rose-300">Restricciones de Seguridad Activas (Middleware 403):</strong>
                                <p class="text-slate-400 text-[11px] mt-0.5">No puede crear, modificar ni eliminar cursos, horarios, docentes ni ver finanzas.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Comparative Table -->
            <div class="bg-slate-900/60 border border-slate-800 rounded-3xl overflow-hidden shadow-xl">
                <div class="p-5 bg-slate-950/80 border-b border-slate-800">
                    <h3 class="text-sm font-black text-white uppercase tracking-wider">Matriz Detallada de Permisos del Sistema</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-950/50 text-slate-400 font-bold uppercase border-b border-slate-800">
                            <tr>
                                <th class="px-6 py-3.5">Módulo / Acción del Sistema</th>
                                <th class="px-6 py-3.5 text-center">Administrador</th>
                                <th class="px-6 py-3.5 text-center">Usuario Regular</th>
                                <th class="px-6 py-3.5">Mecanismo de Protección</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/80 font-medium text-slate-300">
                            <tr class="hover:bg-slate-800/30 transition">
                                <td class="px-6 py-3 font-bold text-white">Ver Catálogo de Cursos & Paralelos</td>
                                <td class="px-6 py-3 text-center text-emerald-400 font-black">&#10003; Sí</td>
                                <td class="px-6 py-3 text-center text-emerald-400 font-black">&#10003; Sí</td>
                                <td class="px-6 py-3 text-slate-400 text-[11px]">Acceso Autenticado Libre</td>
                            </tr>
                            <tr class="hover:bg-slate-800/30 transition">
                                <td class="px-6 py-3 font-bold text-white">Ver Instructores y Especialidades</td>
                                <td class="px-6 py-3 text-center text-emerald-400 font-black">&#10003; Sí</td>
                                <td class="px-6 py-3 text-center text-emerald-400 font-black">&#10003; Sí</td>
                                <td class="px-6 py-3 text-slate-400 text-[11px]">Acceso Autenticado Libre</td>
                            </tr>
                            <tr class="hover:bg-slate-800/30 transition">
                                <td class="px-6 py-3 font-bold text-white">Matricularse / Registrar Inscripción</td>
                                <td class="px-6 py-3 text-center text-emerald-400 font-black">&#10003; Sí</td>
                                <td class="px-6 py-3 text-center text-emerald-400 font-black">&#10003; Sí</td>
                                <td class="px-6 py-3 text-slate-400 text-[11px]">Validación en InscripcionRequest</td>
                            </tr>
                            <tr class="hover:bg-slate-800/30 transition">
                                <td class="px-6 py-3 font-bold text-white">Crear / Editar / Eliminar Cursos</td>
                                <td class="px-6 py-3 text-center text-emerald-400 font-black">&#10003; Sí</td>
                                <td class="px-6 py-3 text-center text-rose-400 font-black">&#10007; Bloqueado</td>
                                <td class="px-6 py-3 text-amber-400 font-mono text-[11px]">AdminMiddleware (403)</td>
                            </tr>
                            <tr class="hover:bg-slate-800/30 transition">
                                <td class="px-6 py-3 font-bold text-white">Aperturar / Editar Paralelos y Horarios</td>
                                <td class="px-6 py-3 text-center text-emerald-400 font-black">&#10003; Sí</td>
                                <td class="px-6 py-3 text-center text-rose-400 font-black">&#10007; Bloqueado</td>
                                <td class="px-6 py-3 text-amber-400 font-mono text-[11px]">AdminMiddleware (403)</td>
                            </tr>
                            <tr class="hover:bg-slate-800/30 transition">
                                <td class="px-6 py-3 font-bold text-white">Crear / Editar Instructores y Categorías</td>
                                <td class="px-6 py-3 text-center text-emerald-400 font-black">&#10003; Sí</td>
                                <td class="px-6 py-3 text-center text-rose-400 font-black">&#10007; Bloqueado</td>
                                <td class="px-6 py-3 text-amber-400 font-mono text-[11px]">AdminMiddleware (403)</td>
                            </tr>
                            <tr class="hover:bg-slate-800/30 transition">
                                <td class="px-6 py-3 font-bold text-white">Modificar / Anular Matrículas Existentes</td>
                                <td class="px-6 py-3 text-center text-emerald-400 font-black">&#10003; Sí</td>
                                <td class="px-6 py-3 text-center text-rose-400 font-black">&#10007; Bloqueado</td>
                                <td class="px-6 py-3 text-amber-400 font-mono text-[11px]">AdminMiddleware (403)</td>
                            </tr>
                            <tr class="hover:bg-slate-800/30 transition">
                                <td class="px-6 py-3 font-bold text-white">Reporte Financiero de Ingresos ($)</td>
                                <td class="px-6 py-3 text-center text-emerald-400 font-black">&#10003; Sí</td>
                                <td class="px-6 py-3 text-center text-rose-400 font-black">&#10007; Bloqueado</td>
                                <td class="px-6 py-3 text-amber-400 font-mono text-[11px]">AdminMiddleware (403)</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- 4. Motor de 5 Validaciones Académicas -->
        <section id="motor-validaciones" class="space-y-8">
            <div class="text-center max-w-2xl mx-auto space-y-2">
                <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-500/10 text-emerald-300 border border-emerald-500/20 uppercase tracking-wider">
                    Integridad de Datos
                </span>
                <h2 class="text-3xl font-black text-white">Motor de Validación Académica en 5 Capas</h2>
                <p class="text-xs text-slate-400">
                    Garantiza que ninguna inscripción inválida sea procesada, tanto por interfaz gráfica como por peticiones directas.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Capa 1 -->
                <div class="bg-slate-900/60 border border-slate-800/80 rounded-3xl p-6 relative">
                    <span class="text-3xl font-black text-emerald-500/20 absolute top-4 right-4">01</span>
                    <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center font-black mb-3">📅</div>
                    <h3 class="text-base font-black text-white mb-1.5">Límite de Fecha Final</h3>
                    <p class="text-xs text-slate-400 leading-relaxed font-medium">
                        Rechaza cualquier inscripción con fecha posterior a la culminación del paralelo (<code class="text-emerald-300 font-mono text-[11px]">fecha_inscripcion > fecha_fin</code>).
                    </p>
                </div>

                <!-- Capa 2 -->
                <div class="bg-slate-900/60 border border-slate-800/80 rounded-3xl p-6 relative">
                    <span class="text-3xl font-black text-teal-500/20 absolute top-4 right-4">02</span>
                    <div class="w-10 h-10 rounded-xl bg-teal-500/10 text-teal-400 flex items-center justify-center font-black mb-3">⏳</div>
                    <h3 class="text-base font-black text-white mb-1.5">Límite de Fecha Inicial</h3>
                    <p class="text-xs text-slate-400 leading-relaxed font-medium">
                        Rechaza inscripciones anteriores a la fecha oficial de inicio del curso (<code class="text-teal-300 font-mono text-[11px]">fecha_inscripcion < fecha_inicio</code>).
                    </p>
                </div>

                <!-- Capa 3 -->
                <div class="bg-slate-900/60 border border-slate-800/80 rounded-3xl p-6 relative">
                    <span class="text-3xl font-black text-cyan-500/20 absolute top-4 right-4">03</span>
                    <div class="w-10 h-10 rounded-xl bg-cyan-500/10 text-cyan-400 flex items-center justify-center font-black mb-3">🔗</div>
                    <h3 class="text-base font-black text-white mb-1.5">Integridad Curso & Paralelo</h3>
                    <p class="text-xs text-slate-400 leading-relaxed font-medium">
                        Impide seleccionar un horario o paralelo que pertenece a otro curso diferente. Filtrado dinámico en frontend y validación forzada en backend.
                    </p>
                </div>

                <!-- Capa 4 -->
                <div class="bg-slate-900/60 border border-slate-800/80 rounded-3xl p-6 relative">
                    <span class="text-3xl font-black text-amber-500/20 absolute top-4 right-4">04</span>
                    <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-400 flex items-center justify-center font-black mb-3">👥</div>
                    <h3 class="text-base font-black text-white mb-1.5">Anti-Duplicidad de Estudiante</h3>
                    <p class="text-xs text-slate-400 leading-relaxed font-medium">
                        Un participante no puede estar matriculado dos veces en el mismo curso, independientemente del paralelo elegido.
                    </p>
                </div>

                <!-- Capa 5 -->
                <div class="bg-slate-900/60 border border-slate-800/80 rounded-3xl p-6 relative">
                    <span class="text-3xl font-black text-rose-500/20 absolute top-4 right-4">05</span>
                    <div class="w-10 h-10 rounded-xl bg-rose-500/10 text-rose-400 flex items-center justify-center font-black mb-3">⏰</div>
                    <h3 class="text-base font-black text-white mb-1.5">Cruce de Horarios & Cupo</h3>
                    <p class="text-xs text-slate-400 leading-relaxed font-medium">
                        Monitorea el aforo máximo en tiempo real y detecta si el estudiante ya tiene clases asignadas en el mismo día y rango de horas.
                    </p>
                </div>

                <!-- Capa 6 -->
                <div class="bg-slate-900/60 border border-slate-800/80 rounded-3xl p-6 relative">
                    <span class="text-3xl font-black text-indigo-500/20 absolute top-4 right-4">06</span>
                    <div class="w-10 h-10 rounded-xl bg-indigo-500/10 text-indigo-400 flex items-center justify-center font-black mb-3">🏷️</div>
                    <h3 class="text-base font-black text-white mb-1.5">Unicidad de Títulos</h3>
                    <p class="text-xs text-slate-400 leading-relaxed font-medium">
                        Títulos de curso únicos en el catálogo y nombres de paralelos únicos por materia, asegurando orden en la oferta académica.
                    </p>
                </div>
            </div>
        </section>

        <!-- 5. Credenciales Demo -->
        <section class="bg-gradient-to-r from-slate-900 via-teal-950 to-slate-900 border border-slate-800 rounded-3xl p-8 sm:p-10 text-center space-y-6">
            <h2 class="text-2xl font-black text-white">Credenciales Configuradas para Pruebas</h2>
            <p class="text-xs text-slate-300 max-w-xl mx-auto">
                Puedes iniciar sesión con cualquiera de los dos perfiles para comprobar de inmediato la diferencia de autoridad:
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-w-2xl mx-auto text-left">
                <div class="bg-slate-950/80 p-5 rounded-2xl border border-amber-500/30">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-black text-amber-400 uppercase">Perfil Administrador</span>
                        <span class="text-[10px] px-2 py-0.5 rounded bg-amber-500/20 text-amber-300">Gestión Total</span>
                    </div>
                    <p class="text-xs text-slate-300 font-mono">admin@capacitacion.com</p>
                    <p class="text-xs text-slate-400 font-mono mt-0.5">Clave: <strong class="text-white">password</strong></p>
                </div>

                <div class="bg-slate-950/80 p-5 rounded-2xl border border-teal-500/30">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-black text-teal-400 uppercase">Perfil Usuario Regular</span>
                        <span class="text-[10px] px-2 py-0.5 rounded bg-teal-500/20 text-teal-300">Estudiante / Consulta</span>
                    </div>
                    <p class="text-xs text-slate-300 font-mono">user@capacitacion.com</p>
                    <p class="text-xs text-slate-400 font-mono mt-0.5">Clave: <strong class="text-white">password</strong></p>
                </div>
            </div>

            <div class="pt-2">
                <a href="{{ route('login') }}" class="inline-flex items-center px-8 py-3.5 rounded-2xl bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-black text-sm shadow-xl shadow-emerald-500/25 transition transform hover:-translate-y-0.5">
                    Ir al Inicio de Sesión &rarr;
                </a>
            </div>
        </section>

    </main>

    <!-- Pie de Página -->
    <footer class="w-full max-w-7xl mx-auto px-6 py-6 border-t border-slate-900 text-xs text-slate-500 flex flex-col sm:flex-row items-center justify-between gap-3 relative z-10">
        <p>EduCapacita Master &bull; Sistema Académico de Formación Continua y Matrículas.</p>
        <p class="text-slate-400 font-medium">Desarrollado con Laravel 12 y PostgreSQL</p>
    </footer>
</body>
</html>
