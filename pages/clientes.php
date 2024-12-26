<?php include('../includes/header.php'); ?>

<div class="flex min-h-screen">
  <!-- Sidebar -->
  <?php include('../includes/sidebar.php'); ?>

  <!-- Contenido Principal -->
  <div class="ml-64 p-8 w-full bg-gray-400">
    
    <!-- Formulario para crear un nuevo cliente -->
    <div class="mt-8 p-6 bg-white rounded-lg shadow-lg">
      <h3 class="text-2xl font-semibold text-gray-800">Crear Cliente</h3>

      <?php
      // Verificar si se ha enviado el formulario
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $nombre = $_POST['nombre'] ?? '';
          $email = $_POST['email'] ?? '';
          $telefono = $_POST['telefono'] ?? '';
          $direccion = $_POST['direccion'] ?? '';

          // Validación básica
          if ($nombre && $email && $telefono && $direccion) {
              try {
                  // Conectar a la base de datos SQLite
                  $db = new PDO('sqlite:../database/clients.db');
                  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                  // Preparar la inserción
                  $stmt = $db->prepare("INSERT INTO clientes (nombre, email, telefono, direccion) VALUES (?, ?, ?, ?)");
                  $stmt->execute([$nombre, $email, $telefono, $direccion]);

                  // Mostrar mensaje de éxito
                  echo '<p class="text-green-600">Cliente creado con éxito!</p>';
              } catch (Exception $e) {
                  echo '<p class="text-red-600">Error al guardar el cliente: ' . $e->getMessage() . '</p>';
              }
          } else {
              echo '<p class="text-red-600">Por favor, completa todos los campos.</p>';
          }
      }
      ?>

      <form method="POST" action="">
        <div class="mt-4">
          <label for="nombre" class="block font-medium">Nombre del Cliente:</label>
          <input type="text" id="nombre" name="nombre" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required placeholder="Nombre completo">
        </div>
        <div class="mt-4">
          <label for="email" class="block font-medium">Correo Electrónico:</label>
          <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required placeholder="Correo electrónico">
        </div>
        <div class="mt-4">
          <label for="telefono" class="block font-medium">Teléfono:</label>
          <input type="text" id="telefono" name="telefono" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required placeholder="Teléfono del cliente">
        </div>
        <div class="mt-4">
          <label for="direccion" class="block font-medium">Dirección:</label>
          <input type="text" id="direccion" name="direccion" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required placeholder="Dirección del cliente">
        </div>

        <div class="mt-6">
          <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
            Crear Cliente
          </button>
        </div>
      </form>
    </div>

    <!-- Mostrar lista de clientes -->
    <div class="mt-8 p-6 bg-white rounded-lg shadow-lg">
      <h3 class="text-2xl font-semibold text-gray-800">Lista de Clientes</h3>
      <?php
      // Mostrar los clientes existentes
      $db = new PDO('sqlite:../database/clients.db');
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $stmt = $db->query("SELECT * FROM clientes");
      $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if (count($clientes) > 0) {
          echo '<ul>';
          foreach ($clientes as $cliente) {
              echo '<li>' . htmlspecialchars($cliente['nombre']) . ' - ' . htmlspecialchars($cliente['email']) . '</li>';
          }
          echo '</ul>';
      } else {
          echo '<p>No hay clientes registrados.</p>';
      }
      ?>
    </div>

  </div>
</div>

<?php include('../includes/footer.php'); ?>
