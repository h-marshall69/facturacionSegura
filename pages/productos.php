<?php include('../includes/header.php'); ?>

<div class="flex min-h-screen">
  <!-- Sidebar -->
  <?php include('../includes/sidebar.php'); ?>

  <!-- Contenido Principal -->
  <div class="ml-64 p-8 w-full bg-gray-400">

    <!-- Formulario para crear un nuevo producto -->
    <div class="mt-8 p-6 bg-white rounded-lg shadow-lg">
      <h3 class="text-2xl font-semibold text-gray-800">Crear Producto</h3>

      <?php
      // Verificar si se ha enviado el formulario
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $codigo = $_POST['codigo'] ?? '';
          $nombre = $_POST['nombre'] ?? '';
          $descripcion = $_POST['descripcion'] ?? '';
          $precio_unitario = $_POST['precio_unitario'] ?? 0;
          $cantidad = $_POST['cantidad'] ?? 0;

          // Validación básica
          if ($codigo && $nombre && $precio_unitario >= 0 && $cantidad >= 0) {
              try {
                  // Conectar a la base de datos SQLite
                  $db = new PDO('sqlite:../database/products.db');
                  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                  // Preparar la inserción
                  $stmt = $db->prepare("INSERT INTO productos (codigo, nombre, descripcion, precio_unitario, cantidad) VALUES (?, ?, ?, ?, ?)");
                  $stmt->execute([$codigo, $nombre, $descripcion, $precio_unitario, $cantidad]);

                  // Mostrar mensaje de éxito
                  echo '<p class="text-green-600">Producto creado con éxito!</p>';
              } catch (Exception $e) {
                  echo '<p class="text-red-600">Error al guardar el producto: ' . $e->getMessage() . '</p>';
              }
          } else {
              echo '<p class="text-red-600">Por favor, completa todos los campos correctamente.</p>';
          }
      }
      ?>

      <form method="POST" action="">
        <div class="mt-4">
          <label for="codigo" class="block font-medium">Código del Producto:</label>
          <input type="text" id="codigo" name="codigo" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required placeholder="Código único del producto">
        </div>
        <div class="mt-4">
          <label for="nombre" class="block font-medium">Nombre del Producto:</label>
          <input type="text" id="nombre" name="nombre" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required placeholder="Nombre del producto">
        </div>
        <div class="mt-4">
          <label for="descripcion" class="block font-medium">Descripción:</label>
          <textarea id="descripcion" name="descripcion" class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="Descripción del producto"></textarea>
        </div>
        <div class="mt-4">
          <label for="precio_unitario" class="block font-medium">Precio Unitario:</label>
          <input type="number" id="precio_unitario" name="precio_unitario" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required placeholder="Precio del producto" step="0.01" min="0">
        </div>
        <div class="mt-4">
          <label for="cantidad" class="block font-medium">Cantidad:</label>
          <input type="number" id="cantidad" name="cantidad" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required placeholder="Cantidad en stock" step="1" min="0">
        </div>

        <div class="mt-6">
          <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
            Crear Producto
          </button>
        </div>
      </form>
    </div>

    <!-- Mostrar lista de productos -->
    <div class="mt-8 p-6 bg-white rounded-lg shadow-lg">
      <h3 class="text-2xl font-semibold text-gray-800">Lista de Productos</h3>
      <?php
      // Mostrar los productos existentes
      $db = new PDO('sqlite:../database/products.db');
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $stmt = $db->query("SELECT * FROM productos");
      $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if (count($productos) > 0) {
          echo '<ul>';
          foreach ($productos as $producto) {
              echo '<li>' . htmlspecialchars($producto['nombre']) . ' - ' . htmlspecialchars($producto['codigo']) . ' - ' . '$' . number_format($producto['precio_unitario'], 2) . ' - ' . $producto['cantidad'] . ' unidades</li>';
          }
          echo '</ul>';
      } else {
          echo '<p>No hay productos registrados.</p>';
      }
      ?>
    </div>

  </div>
</div>

<?php include('../includes/footer.php'); ?>
