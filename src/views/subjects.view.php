<?php require VIEWS . "/partials/header.view.php"; ?>

<div class="max-w-7xl mx-auto p-6">
    <h1 class="text-3xl font-bold text-center mb-8 text-blue-700">📘 Gestión de Asignaturas</h1>

    <!-- Mensajes de éxito/error -->
    <?php if (isset($_GET['successSubject']) && $_GET['successSubject'] == 1): ?>
    <div class="alert alert-success text-green-600 font-bold mb-4">
        ✅ Asignatura creada con éxito.
    </div>
    <?php elseif ($_GET['successCourse'] == 1): ?>
    <div class="alert alert-success text-green-600 font-bold mb-4">
        ✅ Curso creado con éxito.
    </div>
    <?php elseif (isset($_GET['error'])): ?>
    <div class="alert alert-error text-red-600 font-bold mb-4">
        ❌ <?= htmlspecialchars($_GET['error']) ?>
    </div>
    <?php endif; ?>

    <!-- Form crear Curso -->
    <h2 class="text-2xl font-bold text-center text-blue-700 mb-6">Crear un Nuevo Curso</h2>
    <div class="bg-white p-6 rounded-lg shadow-lg mb-10">
        <form action="/create-course" method="POST" autocomplete="off" class="space-y-4">
            <div class="form-group">
                <label for="name" class="block font-semibold mb-1">Nombre del Curso:</label>
                <input type="text" id="name" name="name"
                    class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Ingrese el nombre" autocomplete="off" required>
            </div>

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                Crear Curso
            </button>
        </form>
    </div>

    <!-- Crear una nueva asignatura -->
    <h2 class="text-2xl font-bold text-center text-blue-700 mb-6">📚 Crear Nueva Asignatura</h2>
    <div class="bg-white p-6 rounded-lg shadow-lg mb-10">
        <form action="/create-subject" method="POST" class="space-y-4">
            <!-- Nombre de la asignatura -->
            <div class="form-group">
                <label for="subject_name" class="block font-semibold mb-1">Nombre de la Asignatura:</label>
                <input type="text" id="subject_name" name="subject_name"
                    class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Introduce el nombre de la asignatura" required>
            </div>

            <!-- Seleccionar curso -->
            <div class="form-group">
                <label for="course_id" class="block font-semibold mb-1">Curso Asociado:</label>
                <select id="course_id" name="course_id" required
                    class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="" disabled selected>Selecciona un Curso</option>
                    <?php foreach ($courses as $course): ?>
                    <option value="<?= $course->getId(); ?>"><?= htmlspecialchars($course->getName()); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit"
                class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg">
                Crear Asignatura
            </button>
        </form>
    </div>

    <!-- Listar asignaturas existentes -->
    <hr class="my-10 border-gray-300">
    <h2 class="text-2xl font-bold text-center text-blue-700 mb-6">📋 Lista de Asignaturas</h2>

    <?php if (!empty($subjects)): ?>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-lg shadow-lg">
            <thead>
                <tr>
                    <th class="py-3 px-4 bg-blue-700 text-white">ID</th>
                    <th class="py-3 px-4 bg-blue-700 text-white">Nombre</th>
                    <th class="py-3 px-4 bg-blue-700 text-white">Curso Asociado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($subjects as $subject): ?>
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-4 text-center"><?= htmlspecialchars($subject['subject_id']); ?></td>
                    <td class="py-3 px-4"><?= htmlspecialchars($subject['subject_name']); ?></td>
                    <td class="py-3 px-4"><?= htmlspecialchars($subject['course_name'] ?? 'Sin Curso'); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <p class="text-center text-red-600 font-bold mt-6">❌ No hay asignaturas disponibles.</p>
    <?php endif; ?>
</div>

<?php require VIEWS . "/partials/footer.view.php"; ?>