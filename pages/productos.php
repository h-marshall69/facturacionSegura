<?php include('../includes/header.php'); ?>

<div class="flex min-h-screen">
  <!-- Sidebar -->
  <?php include('../includes/sidebar.php'); ?>

  <!-- Contenido Principal -->
  <div class="ml-64 p-8 w-full bg-gray-100">
    <h2 class="text-3xl font-semibold text-gray-800">Bienvenido a la Página Principal</h2>
    <p class="mt-4 text-lg text-gray-600">Este es el contenido principal de tu página. Aquí puedes agregar textos, imágenes, tablas o cualquier otro tipo de contenido.</p>

    <!-- Sección de estadísticas o resumen -->
    <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
      <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition-shadow duration-200">
        <h3 class="text-xl font-medium text-gray-800">Estadística 1</h3>
        <p class="text-lg text-gray-600 mt-2">Descripción breve de la estadística o datos relevantes.</p>
      </div>
      <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition-shadow duration-200">
        <h3 class="text-xl font-medium text-gray-800">Estadística 2</h3>
        <p class="text-lg text-gray-600 mt-2">Otra sección de estadísticas o información importante.</p>
      </div>
      <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition-shadow duration-200">
        <h3 class="text-xl font-medium text-gray-800">Estadística 3</h3>
        <p class="text-lg text-gray-600 mt-2">Descripción adicional o resumen de otro dato importante.</p>
      </div>
    </div>
    
    <!-- Otra sección de contenido -->
    <div class="mt-8 p-6 bg-white rounded-lg shadow-lg">
      <h3 class="text-2xl font-semibold text-gray-800">Sección Adicional</h3>
      <p class="mt-4 text-gray-600">Aquí puedes agregar cualquier tipo de contenido adicional, como formularios, tablas, o cualquier cosa que necesites.</p>
    </div>
  </div>
</div>

<?php include('../includes/footer.php'); ?>
