<?php include('includes/header.php'); ?>

<div class="flex min-h-screen bg-gray-100">
  <!-- Sidebar -->
  <?php include('includes/sidebar.php'); ?>

  <!-- Contenido Principal -->
  <div class="ml-64 p-8 w-full bg-gray-100">
    <h2 class="text-3xl font-semibold text-gray-800">Bienvenido al Sistema de Facturación Electrónica</h2>
    
    <p class="mt-4 text-lg text-gray-600 leading-relaxed">
      Aquí podrás gestionar todas tus facturas electrónicas de forma sencilla y eficiente. 
      Navega por el menú para comenzar a utilizar todas las funcionalidades que ofrecemos.
    </p>

    <!-- Botón de Acción (Ejemplo de CTA) -->
    <div class="mt-8">
      <a href="nueva_factura.php" 
         class="px-6 py-3 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 transition-all duration-300">
        Crear Nueva Factura
      </a>
    </div>
  </div>
</div>

<?php include('includes/footer.php'); ?>
