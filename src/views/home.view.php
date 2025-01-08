<?php require VIEWS . "/partials/header.view.php";?>

<div class="max-w-7xl mx-auto p-6">
    <div class="text-center">
        <h1 class="text-4xl font-extrabold text-blue-700 mb-4">🏫 Bienvenido a <?=$name;?></h1>
        <p class="text-lg text-gray-700">Tu plataforma para gestionar profesores, estudiantes y cursos de forma eficiente.</p>
    </div>

    <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Card: Admin Teachers -->
        <a href="/teacher" class="block bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition transform hover:scale-105 text-center">
            <h2 class="text-2xl font-bold text-blue-700 mb-2">👨‍🏫 Admin Teachers</h2>
            <p class="text-gray-600">Gestiona la información de los profesores.</p>
        </a>

        <!-- Card: Add Student -->
        <a href="/student" class="block bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition transform hover:scale-105 text-center">
            <h2 class="text-2xl font-bold text-green-700 mb-2">👩‍🎓 Add Student</h2>
            <p class="text-gray-600">Gestiona la información de los Alumnos.</p>
        </a>

        <!-- Card: Enroll Course -->
        <a href="/course" class="block bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition transform hover:scale-105 text-center">
            <h2 class="text-2xl font-bold text-purple-700 mb-2">📚 Enroll Course</h2>
            <p class="text-gray-600">Asigna estudiantes a cursos fácilmente.</p>
        </a>

        <!-- Card: Admin Tasks -->
        <a href="/tasks" class="block bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition transform hover:scale-105 text-center">
            <h2 class="text-2xl font-bold text-yellow-700 mb-2">📝 Admin Tasks</h2>
            <p class="text-gray-600">Administra las tareas y actividades de la escuela.</p>
        </a>
    </div>
</div>

<?php require VIEWS . "/partials/footer.view.php";?>
