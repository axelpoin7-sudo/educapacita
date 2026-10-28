# Informe de Normalización y Migración a Español

## 1. Resumen Ejecutivo
Se realizó la revisión completa del proyecto académico **EduCapacita (Plataforma de Capacitación y Gestión de Inscripciones)**. Todos los componentes de software (modelos, controladores, peticiones de validación, fábricas, rutas, migraciones y vistas Blade) fueron normalizados al idioma **Español**, eliminando duplicados, resolviendo conflictos de dependencias y optimizando la base de datos para los estándares de un proyecto universitario.

---

## 2. Eliminación de Duplicados y Carpetas en Inglés

### 2.1 Modelos (`app/Models`)
- **Eliminados (Inglés):** `Category.php`, `Course.php`, `Enrollment.php`, `Parallel.php`, `Participant.php`.
- **Mantenidos y Unificados (Español):**
  - `Categoria.php`
  - `Curso.php`
  - `Instructor.php`
  - `Paralelo.php`
  - `Participante.php`
  - `Inscripcion.php`
  - `User.php`

### 2.2 Controladores (`app/Http/Controllers`)
- **Eliminados (Inglés):** `CategoryController.php`, `CourseController.php`, `EnrollmentController.php`, `ParallelController.php`, `ParticipantController.php`, `ReportController.php`.
- **Mantenidos y Unificados (Español):**
  - `CategoriaController.php`
  - `CursoController.php`
  - `InstructorController.php`
  - `ParaleloController.php`
  - `ParticipanteController.php`
  - `InscripcionController.php`
  - `ReporteController.php`
  - `DashboardController.php`
  - `AuthController.php`
  - `Controller.php`

### 2.3 Peticiones de Formulario (`app/Http/Requests`)
- **Eliminados (Inglés):** `CategoryRequest.php`, `CourseRequest.php`, `EnrollmentRequest.php`, `ParallelRequest.php`, `ParticipantRequest.php`.
- **Mantenidos y Unificados (Español):**
  - `CategoriaRequest.php`
  - `CursoRequest.php`
  - `InstructorRequest.php`
  - `ParaleloRequest.php`
  - `ParticipanteRequest.php`
  - `InscripcionRequest.php` (con validación de cupo máximo y horario cruzado)

### 2.4 Fábricas de Datos (`database/factories`)
- **Eliminados (Inglés):** `CategoryFactory.php`, `CourseFactory.php`, `EnrollmentFactory.php`, `ParallelFactory.php`, `ParticipantFactory.php`.
- **Mantenidos y Unificados (Español):**
  - `CategoriaFactory.php`, `CursoFactory.php`, `InstructorFactory.php`, `ParaleloFactory.php`, `ParticipanteFactory.php`, `InscripcionFactory.php`, `UserFactory.php`.

### 2.5 Vistas Blade (`resources/views`)
- **Carpetas en inglés eliminadas:** `categories/`, `courses/`, `enrollments/`, `instructors/`, `parallels/`, `participants/`, `reports/`.
- **Carpetas oficiales en español creadas:**
  - `categorias/` (`index`, `create`, `edit`)
  - `cursos/` (`index`, `create`, `edit`, `show`)
  - `instructores/` (`index`, `create`, `edit`, `show`)
  - `paralelos/` (`index`, `create`, `edit`, `show`)
  - `participantes/` (`index`, `create`, `edit`, `show`)
  - `inscripciones/` (`index`, `create`, `edit`, `show` - Comprobante de Matrícula)
  - `reportes/` (`inscritos_por_paralelo`, `ingresos_por_curso`)
  - `auth/` (`login`)
  - `layouts/` (`app`)
  - `dashboard.blade.php`

---

## 3. Base de Datos y Relaciones

### 3.1 Depuración de Tablas Innecesarias
De acuerdo con las observaciones del proyecto académico, se eliminaron las migraciones y tablas por defecto de Laravel que no tienen relación con el dominio universitario:
- **Tablas Eliminadas:**
  - `cache` y `cache_locks` (migración eliminada).
  - `jobs`, `job_batches` y `failed_jobs` (migración eliminada).
  - `sessions` (el almacenamiento de sesiones se configuró en `file` en `.env`).
- **Configuración en `.env`:**
  - `SESSION_DRIVER=file`
  - `CACHE_STORE=file`
  - `QUEUE_CONNECTION=sync`

### 3.2 Tablas Oficiales del Sistema en PostgreSQL (`capacitacion_db`)
1. **`users`**: Administradores y coordinadores académicos (`admin@capacitacion.com`, `user@capacitacion.com`).
2. **`categorias`**: Áreas de estudio (Ofimática, Programación, Multimedia, Redes, Marketing, Inteligencia Artificial).
3. **`instructores`**: Datos del cuerpo docente con especialidad, biografía y foto.
4. **`cursos`**: Catálogo formativo con precio, horas, categoría e imagen.
5. **`paralelos`**: Oferta de horarios, aulas, días, fechas de inicio/fin y cupo máximo de participantes.
6. **`participantes`**: Alumnos matriculados con DNI/CI único, teléfono y correo electrónico.
7. **`inscripciones`**: Relación entre participantes y paralelos, registrando fecha de inscripción, monto cobrado y estado (`pendiente`, `pagada`, `anulada`).

### 3.3 Relaciones de Integridad Referencial
- `cursos.categoria_id` $\rightarrow$ `categorias.id` (`ON DELETE CASCADE`)
- `paralelos.curso_id` $\rightarrow$ `cursos.id` (`ON DELETE CASCADE`)
- `paralelos.instructor_id` $\rightarrow$ `instructores.id` (`ON DELETE CASCADE`)
- `inscripciones.participante_id` $\rightarrow$ `participantes.id` (`ON DELETE CASCADE`)
- `inscripciones.paralelo_id` $\rightarrow$ `paralelos.id` (`ON DELETE CASCADE`)

### 3.4 Reglas de Negocio Implementadas
1. **Control de Cupo Máximo:** Antes de guardar o actualizar una inscripción, el sistema verifica que la cantidad de inscritos activos no exceda el `cupo_maximo` del paralelo. Si se llena, la matrícula es rechazada y se alerta al usuario.
2. **Control de Horario Cruzado:** Valida automáticamente que un participante no esté matriculado en otro curso activo que coincida en rango de fechas, días de clase y horario solapado.

---

## 4. Estado de Pruebas y Verificación
- **Migraciones y Seeder ejecutados con éxito:**
  - Base de datos: `capacitacion_db` en PostgreSQL 16.
  - Registros generados: 5 usuarios, 6 categorías, 25 instructores, 50 cursos, 100 paralelos, 320 participantes, 550 inscripciones.
- **Suite de Pruebas Automatizadas:** 9 pruebas pasadas con 26 aserciones satisfactorias (`php artisan test`).
