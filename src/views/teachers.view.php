<?php require VIEWS . "/partials/header.view.php"; ?>

<div class="max-w-7xl mx-auto p-6">

    <h1 class="text-3xl font-bold text-center mb-8 text-blue-700">📘 Gestión de Profesores y Departamentos</h1>

    <!-- Mensajes de error-->
    <?php if ($_GET['success'] == 1): ?>
        <div class="alert alert-success text-green-600 font-bold mb-4">
            ✅ Profesor creado con éxito.
        </div>
    <?php elseif ($_GET['success'] == 2): ?>
        <div class="alert alert-success text-green-600 font-bold mb-4">
            ✅ Profesor asignado a un departamento con éxito.
        </div>
        <?php elseif ($_GET['success'] == 3): ?>
        <div class="alert alert-success text-green-600 font-bold mb-4">
            ✅ Departamento creado con éxito.
        </div>
    <?php elseif (isset($_GET['error'])): ?>
        <div class="alert alert-error text-red-600 font-bold mb-4">
            ❌ <?= ($_GET['error']) ?>
        </div>
    <?php endif; ?>

        <!-- Form crear Departamento -->
    <h2 class="text-2xl font-bold text-center text-blue-700 mb-6">Crear un Nuevo Departamento</h2>
    <div class="bg-white p-6 rounded-lg shadow-lg mb-10">
        <form action="/create-department" method="POST" autocomplete="off" class="space-y-4">
            <div class="form-group">
                <label for="name" class="block font-semibold mb-1">Nombre del Departamento:</label>
                <input type="text" id="name" name="name"
                    class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Ingrese el nombre" autocomplete="off" required>
            </div>

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                Crear Departamento
            </button>
        </form>
    </div>

    <!-- Form crear profesor -->
    <h2 class="text-2xl font-bold text-center text-blue-700 mb-6">📝 Crear un Nuevo Profesor</h2>
    <div class="bg-white p-6 rounded-lg shadow-lg mb-10">
        <form action="/teacherPostForm" method="POST" autocomplete="off" class="space-y-4">
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
                Crear Profesor
            </button>
        </form>
    </div>

    <hr class="my-10 border-gray-300">

    <!-- Form asignar dept a prof-->
    <h2 class="text-2xl font-bold text-center text-blue-700 mb-6">📋 Asignar Profesor a un Departamento</h2>

    <div class="bg-white p-6 rounded-lg shadow-lg mb-10">
        <form action="/assign-department" method="POST" class="space-y-4">
            <div>
                <label for="teacher_id" class="block font-semibold mb-1">Profesor:</label>
                <select id="teacher_id" name="teacher_id" required class="w-full p-2 border border-gray-300 rounded-lg">
                    <option value="" disabled selected>Selecciona un profesor</option>
                    <?php foreach ($teachers as $teacher): ?>
                    <option value="<?= ($teacher->getId()) ?>">
                        <?= ($teacher->getFirstName() . ' ' . $teacher->getLastName()) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="department_id" class="block font-semibold mb-1">Departamento:</label>
                <select id="department_id" name="department_id" required
                    class="w-full p-2 border border-gray-300 rounded-lg">
                    <option value="" disabled selected>Selecciona un departamento</option>
                    <?php foreach ($departments as $department): ?>
                    <option value="<?= ($department->getId()) ?>">
                        <?= ($department->getName()) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg">
                Asignar Departamento
            </button>
        </form>
    </div>

    <hr class="my-10 border-gray-300">

    <!-- Lista de prof -->
    <h2 class="text-2xl font-bold text-center text-blue-700 mb-6">📋 Lista de Profesores</h2>

    <?php if (!empty($teachers)): ?>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-lg shadow-lg ">
            <thead>
                <tr>
                    <th class="py-3 px-4 bg-blue-700 text-white">ID</th>
                    <th class="py-3 px-4 bg-blue-700 text-white">Nombre</th>
                    <th class="py-3 px-4 bg-blue-700 text-white">Apellido</th>
                    <th class="py-3 px-4 bg-blue-700 text-white">Email</th>
                    <th class="py-3 px-4 bg-blue-700 text-white">DNI</th>
                    <th class="py-3 px-4 bg-blue-700 text-white">Departamento</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($teachers as $teacher): ?>
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-4 text-center"><?= ($teacher->getId()) ?></td>
                    <td class="py-3 px-4"><?= ($teacher->getFirstName()) ?></td>
                    <td class="py-3 px-4"><?= ($teacher->getLastName()) ?></td>
                    <td class="py-3 px-4"><?= ($teacher->getEmail()) ?></td>
                    <td class="py-3 px-4"><?= ($teacher->getDni()) ?></td>
                    <td class="py-3 px-4"><?= ($teacher->getDepartmentName() ?? 'Sin Departamento') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <p class="text-center text-red-600 font-bold mt-6">❌ No hay profesores disponibles.</p>
    <?php endif; ?>
</div>

<?php require VIEWS . "/partials/footer.view.php"; ?>
