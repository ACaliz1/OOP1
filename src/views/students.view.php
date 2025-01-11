<?php require VIEWS . "/partials/header.view.php"; ?>

<div class="max-w-7xl mx-auto p-6">

    <h1 class="text-3xl font-bold text-center mb-8 text-blue-700">📘 Gestión de Alumnos y Asignaturas</h1>

    <!-- Mensajes de error-->
    <?php if ($_GET['successCourse'] == 1): ?>
    <div class="alert alert-success text-green-600 font-bold mb-4">
        ✅ Curso creado con éxito.
    </div>
    <?php elseif ($_GET['success'] == 1): ?>
    <div class="alert alert-success text-green-600 font-bold mb-4">
        ✅ Alumno creado con éxito.
    </div>
    <?php elseif ($_GET['CourseAssign'] == 1): ?>
    <div class="alert alert-success text-green-600 font-bold mb-4">
        ✅ Alumno asignado a curso con éxito.
    </div>
    <?php elseif (isset($_GET['error'])): ?>
    <div class="alert alert-error text-red-600 font-bold mb-4">
        ❌ <?=($_GET['error'])?>
    </div>
    <?php endif; ?>

    <!-- Form crear Student -->
    <h2 class="text-2xl font-bold text-center text-blue-700 mb-6">📝 Crear un Nuevo Estudiante</h2>
    <div class="bg-white p-6 rounded-lg shadow-lg mb-10">
        <form action="/create-student" method="POST" autocomplete="off" class="space-y-4">
            <div class="form-group">
                <label for="first_name" class="block font-semibold mb-1">Nombre:</label>
                <input type="text" id="first_name" name="first_name"
                    class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Ingrese el nombre" autocomplete="off" required>
            </div>

            <div class="form-group">
                <label for="last_name" class="block font-semibold mb-1">Apellido:</label>
                <input type="text" id="last_name" name="last_name"
                    class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Ingrese el apellido" autocomplete="off" required>
            </div>

            <div class="form-group">
                <label for="email" class="block font-semibold mb-1">Email:</label>
                <input type="email" id="email" name="email"
                    class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Ingrese el email" autocomplete="off" required>
            </div>

            <div class="form-group">
                <label for="password" class="block font-semibold mb-1">Contraseña:</label>
                <input type="password" id="password" name="password"
                    class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Ingrese la contraseña" autocomplete="new-password" required>
            </div>

            <div class="form-group">
                <label for="dni" class="block font-semibold mb-1">DNI:</label>
                <input type="text" id="dni" name="dni"
                    class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Ingrese el DNI" autocomplete="off" required>
            </div>

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                Crear Estudiante
            </button>
        </form>
    </div>

    <hr class="my-10 border-gray-300">

    <!-- Form asignar Curso a Estudiante-->
    <h2 class="text-2xl font-bold text-center text-blue-700 mb-6">📋 Asignar Estudiante a un Curso</h2>

    <div class="bg-white p-6 rounded-lg shadow-lg mb-10">
    <form action="/assign-course" method="POST" class="space-y-4">
    <!-- Selección de estudiante -->
    <div>
        <label for="student_id" class="block font-semibold mb-1">Estudiante:</label>
        <select id="student_id" name="student_id" required class="w-full p-2 border border-gray-300 rounded-lg">
            <option value="" disabled selected>Selecciona un Estudiante</option>
            <?php foreach ($students as $student): ?>
                <option value="<?= $student->getStudentId() ?>">
                    <?= $student->getFirstName() . ' ' . $student->getLastName() . ' (' . $student->getStudentId() . ')' ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Selección de curso -->
    <div>
        <label for="course_id" class="block font-semibold mb-1">Curso:</label>
        <select id="course_id" name="course_id" required
            class="w-full p-2 border border-gray-300 rounded-lg">
            <option value="" disabled selected>Selecciona un Curso</option>
            <?php foreach ($courses as $course): ?>
                <option value="<?= $course->getId() ?>">
                    <?= $course->getName() ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Selección de asignatura (se llena dinámicamente) -->
    <div id="subjects-container">
        <label for="subject_id" class="block font-semibold mb-1">Asignatura:</label>
        <select id="subject_id" name="subject_id" required class="w-full p-2 border border-gray-300 rounded-lg">
            <option value="" disabled selected>Primero selecciona un curso</option>
        </select>
    </div>

    <!-- Botón de envío -->
    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg">
        Asignar Estudiante a Asignatura
    </button>
</form>
    </div>

    <hr class="my-10 border-gray-300">

    <!-- Lista de prof -->
    <h2 class="text-2xl font-bold text-center text-blue-700 mb-6">📋 Lista de Alumnos</h2>

    <?php if (!empty($students)): ?>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-lg shadow-lg ">
            <thead>
                <tr>
                    <th class="py-3 px-4 bg-blue-700 text-white">ID</th>
                    <th class="py-3 px-4 bg-blue-700 text-white">Nombre</th>
                    <th class="py-3 px-4 bg-blue-700 text-white">Apellido</th>
                    <th class="py-3 px-4 bg-blue-700 text-white">Email</th>
                    <th class="py-3 px-4 bg-blue-700 text-white">DNI</th>
                    <th class="py-3 px-4 bg-blue-700 text-white">Curso</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-4 text-center"><?=($student->getStudentId())?></td>
                    <td class="py-3 px-4"><?=($student->getFirstName())?></td>
                    <td class="py-3 px-4"><?=($student->getLastName())?></td>
                    <td class="py-3 px-4"><?=($student->getEmail())?></td>
                    <td class="py-3 px-4"><?=($student->getDni())?></td>
                    <td class="py-3 px-4"><?=($student->getCourseName() ?? 'Sin Curso')?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <p class="text-center text-red-600 font-bold mt-6">❌ No hay Alumnos disponibles.</p>
    <?php endif; ?>
</div>
<script>
    document.getElementById('course_id').addEventListener('change', function () {
        const courseId = this.value;

        // Petición AJAX para obtener las asignaturas relacionadas
        fetch(`/get-subjects?course_id=${courseId}`)
            .then(response => response.json())
            .then(data => {
                const subjectSelect = document.getElementById('subject_id');
                subjectSelect.innerHTML = '<option value="" disabled selected>Selecciona una Asignatura</option>';
                data.forEach(subject => {
                    subjectSelect.innerHTML += `<option value="${subject.id}">${subject.name}</option>`;
                });
            })
            .catch(error => {
                console.error('Error al cargar las asignaturas:', error);
            });
    });
</script>

<?php require VIEWS . "/partials/footer.view.php"; ?>