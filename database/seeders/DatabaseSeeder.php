<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Curso;
use App\Models\Inscripcion;
use App\Models\Instructor;
use App\Models\Paralelo;
use App\Models\Participante;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Llena la base de datos con ~1000 registros en español.
     */
    public function run(): void
    {
        // 1. Usuarios (5 registros: 1 Administrador, 4 de Personal)
        User::firstOrCreate(
            ['email' => 'admin@capacitacion.com'],
            [
                'name' => 'Administrador del Sistema',
                'password' => Hash::make('password'),
                'es_admin' => true,
            ]
        );

        User::firstOrCreate(
            ['email' => 'user@capacitacion.com'],
            [
                'name' => 'Coordinador Académico',
                'password' => Hash::make('password'),
                'es_admin' => false,
            ]
        );

        User::factory(3)->create();

        // 2. Categorías (6 registros)
        $datosCategorias = [
            [
                'nombre' => 'Ofimática Empresarial',
                'descripcion' => 'Cursos de productividad, hojas de cálculo, presentaciones y procesamiento de textos corporativos.',
            ],
            [
                'nombre' => 'Programación & Software',
                'descripcion' => 'Formación integral en desarrollo web, móvil, bases de datos y algoritmos modernos.',
            ],
            [
                'nombre' => 'Diseño Gráfico & Multimedia',
                'descripcion' => 'Creación visual, retoque digital, identidad de marca, UX/UI y producción audiovisual.',
            ],
            [
                'nombre' => 'Redes y Ciberseguridad',
                'descripcion' => 'Administración de servidores, infraestructuras en la nube y protección de datos.',
            ],
            [
                'nombre' => 'Marketing Digital y Ventas',
                'descripcion' => 'Estrategias de posicionamiento SEO, pauta digital, analítica y gestión de redes.',
            ],
            [
                'nombre' => 'Inteligencia Artificial y Datos',
                'descripcion' => 'Ciencia de datos, aprendizaje automático, modelos de lenguaje y automatización.',
            ],
        ];

        $categorias = collect();
        foreach ($datosCategorias as $cat) {
            $categorias->push(Categoria::firstOrCreate(['nombre' => $cat['nombre']], $cat));
        }

        // 3. Instructores (25 registros)
        $instructores = Instructor::factory(25)->create();

        // 4. Cursos (50 registros)
        $plantillasCursos = [
            // Ofimática
            ['cat' => 0, 'titulo' => 'Excel Avanzado y Tablas Dinámicas', 'precio' => 150.00, 'horas' => 30, 'img' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=600&auto=format&fit=crop&q=80'],
            ['cat' => 0, 'titulo' => 'Microsoft Power BI para Toma de Decisiones', 'precio' => 220.00, 'horas' => 40, 'img' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=600&auto=format&fit=crop&q=80'],
            ['cat' => 0, 'titulo' => 'Automatización de Tareas con Macros y VBA', 'precio' => 180.00, 'horas' => 35, 'img' => 'https://images.unsplash.com/photo-1504868584819-f8e8b4b6d7e3?w=600&auto=format&fit=crop&q=80'],
            ['cat' => 0, 'titulo' => 'Gestión Documental y Redacción con Word Profesional', 'precio' => 100.00, 'horas' => 20, 'img' => 'https://images.unsplash.com/photo-1455390582262-044cdead277a?w=600&auto=format&fit=crop&q=80'],
            ['cat' => 0, 'titulo' => 'Presentaciones de Alto Impacto con PowerPoint', 'precio' => 110.00, 'horas' => 20, 'img' => 'https://images.unsplash.com/photo-1475721027785-f74eccf877e2?w=600&auto=format&fit=crop&q=80'],
            ['cat' => 0, 'titulo' => 'Google Workspace y Colaboración en la Nube', 'precio' => 130.00, 'horas' => 25, 'img' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=600&auto=format&fit=crop&q=80'],

            // Programación
            ['cat' => 1, 'titulo' => 'Desarrollo Web Fullstack con Laravel y Vue', 'precio' => 280.00, 'horas' => 60, 'img' => 'https://images.unsplash.com/photo-1587620962725-abab7fe55159?w=600&auto=format&fit=crop&q=80'],
            ['cat' => 1, 'titulo' => 'Fundamentos de Programación con Python Moderno', 'precio' => 190.00, 'horas' => 40, 'img' => 'https://images.unsplash.com/photo-1526379095098-d400fd0bf935?w=600&auto=format&fit=crop&q=80'],
            ['cat' => 1, 'titulo' => 'Desarrollo de Aplicaciones Móviles con Flutter', 'precio' => 260.00, 'horas' => 50, 'img' => 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=600&auto=format&fit=crop&q=80'],
            ['cat' => 1, 'titulo' => 'Diseño y Administración de Bases de Datos PostgreSQL', 'precio' => 200.00, 'horas' => 40, 'img' => 'https://images.unsplash.com/photo-1544383835-bda2bc66a55d?w=600&auto=format&fit=crop&q=80'],
            ['cat' => 1, 'titulo' => 'Desarrollo Frontend React.js y TypeScript', 'precio' => 250.00, 'horas' => 50, 'img' => 'https://images.unsplash.com/photo-1633356122544-f134324a6cee?w=600&auto=format&fit=crop&q=80'],
            ['cat' => 1, 'titulo' => 'Construcción de APIs RESTful Seguras y Escalables', 'precio' => 210.00, 'horas' => 40, 'img' => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=600&auto=format&fit=crop&q=80'],

            // Diseño Gráfico
            ['cat' => 2, 'titulo' => 'Diseño Gráfico Publicitario con Adobe Photoshop', 'precio' => 190.00, 'horas' => 40, 'img' => 'https://images.unsplash.com/photo-1626785774573-4b799315345d?w=600&auto=format&fit=crop&q=80'],
            ['cat' => 2, 'titulo' => 'Ilustración Digital y Branding con Adobe Illustrator', 'precio' => 190.00, 'horas' => 40, 'img' => 'https://images.unsplash.com/photo-1572044160443-379364f840ec?w=600&auto=format&fit=crop&q=80'],
            ['cat' => 2, 'titulo' => 'Diseño de Experiencia de Usuario y Prototipado con Figma', 'precio' => 240.00, 'horas' => 45, 'img' => 'https://images.unsplash.com/photo-1581291518857-4e27b48ff24e?w=600&auto=format&fit=crop&q=80'],
            ['cat' => 2, 'titulo' => 'Edición de Video y Postproducción con Premiere Pro', 'precio' => 230.00, 'horas' => 45, 'img' => 'https://images.unsplash.com/photo-1574717024653-61fd2cf4d44d?w=600&auto=format&fit=crop&q=80'],
            ['cat' => 2, 'titulo' => 'Motion Graphics y Animación 2D con After Effects', 'precio' => 250.00, 'horas' => 45, 'img' => 'https://images.unsplash.com/photo-1550745165-9bc0b252726f?w=600&auto=format&fit=crop&q=80'],

            // Redes y Ciberseguridad
            ['cat' => 3, 'titulo' => 'Fundamentos de Redes CCNA y Enrutamiento IP', 'precio' => 220.00, 'horas' => 50, 'img' => 'https://images.unsplash.com/photo-1544197150-b99a580bb7a8?w=600&auto=format&fit=crop&q=80'],
            ['cat' => 3, 'titulo' => 'Seguridad Informática y Hacking Ético Defensivo', 'precio' => 320.00, 'horas' => 60, 'img' => 'https://images.unsplash.com/photo-1563986768609-322da13575f3?w=600&auto=format&fit=crop&q=80'],
            ['cat' => 3, 'titulo' => 'Administración de Servidores Linux para Empresas', 'precio' => 240.00, 'horas' => 45, 'img' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?w=600&auto=format&fit=crop&q=80'],

            // Marketing
            ['cat' => 4, 'titulo' => 'Estrategias de Marketing Digital y Meta Ads', 'precio' => 170.00, 'horas' => 30, 'img' => 'https://images.unsplash.com/photo-1533750516457-a7f992034fec?w=600&auto=format&fit=crop&q=80'],
            ['cat' => 4, 'titulo' => 'Posicionamiento Web SEO y Analítica con Google GA4', 'precio' => 190.00, 'horas' => 35, 'img' => 'https://images.unsplash.com/photo-1571721795195-a2ca2d3370a9?w=600&auto=format&fit=crop&q=80'],

            // IA y Datos
            ['cat' => 5, 'titulo' => 'Introducción a la Inteligencia Artificial y Machine Learning', 'precio' => 310.00, 'horas' => 55, 'img' => 'https://images.unsplash.com/photo-1677442136019-21780efad99a?w=600&auto=format&fit=crop&q=80'],
            ['cat' => 5, 'titulo' => 'Ingeniería de Prompts y Automatización con LLMs', 'precio' => 190.00, 'horas' => 25, 'img' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?w=600&auto=format&fit=crop&q=80'],
        ];

        $cursos = collect();
        foreach ($plantillasCursos as $p) {
            $categoria = $categorias[$p['cat']] ?? $categorias->first();
            $curso = Curso::create([
                'categoria_id' => $categoria->id,
                'titulo' => $p['titulo'],
                'descripcion' => "Capacitación práctica orientada al mercado laboral en {$p['titulo']}. Aprende con casos reales.",
                'precio' => $p['precio'],
                'duracion_horas' => $p['horas'],
                'imagen' => $p['img'],
            ]);
            $cursos->push($curso);
        }

        // Completar hasta 50 cursos
        $cursosRestantes = 50 - $cursos->count();
        for ($i = 0; $i < $cursosRestantes; $i++) {
            $cat = $categorias->random();
            $c = Curso::create([
                'categoria_id' => $cat->id,
                'titulo' => "Taller Profesional en " . fake()->jobTitle(),
                'descripcion' => fake()->paragraph(2),
                'precio' => fake()->randomElement([140.00, 180.00, 220.00, 260.00]),
                'duracion_horas' => fake()->randomElement([20, 30, 40, 50]),
                'imagen' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=600&auto=format&fit=crop&q=80',
            ]);
            $cursos->push($c);
        }

        // 5. Paralelos (100 registros)
        $paralelos = collect();
        $aulas = ['Aula 101', 'Aula 102', 'Aula 201', 'Aula 202', 'Lab Cómputo 1', 'Lab Cómputo 2', 'Lab Multimedia', 'Aula Virtual A', 'Auditorio'];
        $horariosPlantilla = [
            ['dias' => 'Lunes, Miércoles, Viernes', 'inicio' => '08:00:00', 'fin' => '10:00:00'],
            ['dias' => 'Lunes, Miércoles, Viernes', 'inicio' => '10:00:00', 'fin' => '12:00:00'],
            ['dias' => 'Lunes, Miércoles, Viernes', 'inicio' => '14:00:00', 'fin' => '16:00:00'],
            ['dias' => 'Lunes, Miércoles, Viernes', 'inicio' => '18:30:00', 'fin' => '20:30:00'],
            ['dias' => 'Martes, Jueves', 'inicio' => '08:30:00', 'fin' => '11:30:00'],
            ['dias' => 'Martes, Jueves', 'inicio' => '15:00:00', 'fin' => '18:00:00'],
            ['dias' => 'Martes, Jueves', 'inicio' => '18:30:00', 'fin' => '21:30:00'],
            ['dias' => 'Sábados', 'inicio' => '08:00:00', 'fin' => '13:00:00'],
            ['dias' => 'Sábados', 'inicio' => '14:00:00', 'fin' => '19:00:00'],
        ];

        $letrasParalelo = ['Paralelo A', 'Paralelo B', 'Paralelo C', 'Grupo Matutino', 'Grupo Nocturno'];

        foreach ($cursos as $indice => $curso) {
            for ($p = 0; $p < 2; $p++) {
                $sch = $horariosPlantilla[($indice + $p) % count($horariosPlantilla)];
                $fechaInicio = Carbon::now()->subDays(rand(10, 45))->addDays(rand(0, 30));
                $fechaFin = (clone $fechaInicio)->addWeeks(6);

                $paralelo = Paralelo::create([
                    'curso_id' => $curso->id,
                    'instructor_id' => $instructores->random()->id,
                    'nombre' => $letrasParalelo[$p] ?? "Paralelo " . chr(65 + $p),
                    'aula' => $aulas[($indice + $p) % count($aulas)],
                    'dias' => $sch['dias'],
                    'hora_inicio' => $sch['inicio'],
                    'hora_fin' => $sch['fin'],
                    'fecha_inicio' => $fechaInicio->format('Y-m-d'),
                    'fecha_fin' => $fechaFin->format('Y-m-d'),
                    'cupo_maximo' => rand(15, 25),
                ]);

                $paralelos->push($paralelo);
            }
        }

        // 6. Participantes (320 registros)
        $participantes = Participante::factory(320)->create();

        // 7. Inscripciones (550 registros respetando cupo y sin horario cruzado)
        $inscripcionesCreadas = 0;
        $metaInscripciones = 550;
        $listaParticipantes = $participantes->shuffle();
        $listaParalelos = $paralelos->shuffle();

        $paresInscritos = [];

        foreach ($listaParticipantes as $participante) {
            if ($inscripcionesCreadas >= $metaInscripciones) {
                break;
            }

            $cantidadCursos = rand(1, 3);
            $paralelosAleatorios = $listaParalelos->shuffle();

            foreach ($paralelosAleatorios as $paralelo) {
                if ($cantidadCursos <= 0 || $inscripcionesCreadas >= $metaInscripciones) {
                    break;
                }

                $clavePar = "{$participante->id}_{$paralelo->id}";
                if (isset($paresInscritos[$clavePar])) {
                    continue;
                }

                // Verificar cupo
                $conteoActivos = Inscripcion::where('paralelo_id', $paralelo->id)
                    ->where('estado', '!=', 'anulada')
                    ->count();

                if ($conteoActivos >= $paralelo->cupo_maximo) {
                    continue;
                }

                // Verificar horario cruzado
                $conflicto = $participante->buscarParaleloEnConflicto($paralelo);
                if ($conflicto) {
                    continue;
                }

                $azarEstado = rand(1, 100);
                $estado = ($azarEstado <= 75) ? 'pagada' : (($azarEstado <= 90) ? 'pendiente' : 'anulada');
                $monto = ($estado === 'anulada') ? 0.00 : (float) $paralelo->curso->precio;

                Inscripcion::create([
                    'participante_id' => $participante->id,
                    'paralelo_id' => $paralelo->id,
                    'fecha_inscripcion' => Carbon::now()->subDays(rand(1, 40))->format('Y-m-d'),
                    'monto_pagado' => $monto,
                    'estado' => $estado,
                ]);

                $paresInscritos[$clavePar] = true;
                $inscripcionesCreadas++;
                $cantidadCursos--;
            }
        }

        // Si falta para 550, completar
        if ($inscripcionesCreadas < $metaInscripciones) {
            foreach ($participantes as $participante) {
                if ($inscripcionesCreadas >= $metaInscripciones) {
                    break;
                }

                foreach ($paralelos as $paralelo) {
                    if ($inscripcionesCreadas >= $metaInscripciones) {
                        break;
                    }

                    $clavePar = "{$participante->id}_{$paralelo->id}";
                    if (isset($paresInscritos[$clavePar])) {
                        continue;
                    }

                    if ($paralelo->estaLleno() || $participante->buscarParaleloEnConflicto($paralelo)) {
                        continue;
                    }

                    Inscripcion::create([
                        'participante_id' => $participante->id,
                        'paralelo_id' => $paralelo->id,
                        'fecha_inscripcion' => Carbon::now()->subDays(rand(1, 20))->format('Y-m-d'),
                        'monto_pagado' => (float) $paralelo->curso->precio,
                        'estado' => 'pagada',
                    ]);

                    $paresInscritos[$clavePar] = true;
                    $inscripcionesCreadas++;
                }
            }
        }
    }
}
