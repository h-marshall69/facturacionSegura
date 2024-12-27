<?php include('../includes/header.php'); ?>
<div class="flex min-h-screen">
    <!-- Sidebar -->
    <?php include('../includes/sidebar.php'); ?>

    <div class="ml-64 p-8 w-full bg-gray-400">
    <div class="w-full p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-xl font-semibold text-gray-700">Modificar Datos del Emisor</h2>
        <?php
        // Verificar si se ha enviado el formulario para actualizar los datos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ruc = $_POST['ruc'] ?? '';
    $razon_social = $_POST['razon_social'] ?? '';
    $nombre_comercial = $_POST['nombre_comercial'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    $ubigueo = $_POST['ubigueo'] ?? '';
    $departamento = $_POST['departamento'] ?? '';
    $provincia = $_POST['provincia'] ?? '';
    $distrito = $_POST['distrito'] ?? '';

    // Validación básica
    if ($ruc && $razon_social && $nombre_comercial && $direccion && $ubigueo && $departamento && $provincia && $distrito) {
        try {
            // Preparar la actualización en la base de datos
            $stmt = $db->prepare("UPDATE emisor SET 
                razon_social = ?, 
                nombre_comercial = ?, 
                direccion = ?, 
                ubigueo = ?, 
                departamento = ?, 
                provincia = ?, 
                distrito = ? 
                WHERE ruc = ?");
            $stmt->execute([$razon_social, $nombre_comercial, $direccion, $ubigueo, $departamento, $provincia, $distrito, $ruc]);

            echo '<p class="text-green-600">Datos del emisor actualizados con éxito!</p>';
        } catch (Exception $e) {
            echo '<p class="text-red-600">Error al actualizar los datos: ' . $e->getMessage() . '</p>';
        }
    } else {
        echo '<p class="text-red-600">Por favor, completa todos los campos.</p>';
    }
}
        ?>
        <form method="post">
            <div>
                <label for="ruc" class="block font-medium">RUC:</label>
                <input type="text" id="ruc" name="ruc" value="<?php echo htmlspecialchars($emisor['ruc'] ?? ''); ?>" readonly
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label for="razon_social" class="block font-medium">Razón Social:</label>
                <input type="text" id="razon_social" name="razon_social" value="<?php echo htmlspecialchars($emisor['razon_social'] ?? ''); ?>" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label for="nombre_comercial" class="block font-medium">Nombre Comercial:</label>
                <input type="text" id="nombre_comercial" name="nombre_comercial" value="<?php echo htmlspecialchars($emisor['nombre_comercial'] ?? ''); ?>" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label for="direccion" class="block font-medium">Dirección:</label>
                <input type="text" id="direccion" name="direccion" value="<?php echo htmlspecialchars($emisor['direccion'] ?? ''); ?>" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label for="ubigueo" class="block font-medium">Ubigeo:</label>
                <input type="text" id="ubigueo" name="ubigueo" value="<?php echo htmlspecialchars($emisor['ubigueo'] ?? ''); ?>" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label for="departamento" class="block font-medium">Departamento:</label>
                <input type="text" id="departamento" name="departamento" value="<?php echo htmlspecialchars($emisor['departamento'] ?? ''); ?>" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label for="provincia" class="block font-medium">Provincia:</label>
                <input type="text" id="provincia" name="provincia" value="<?php echo htmlspecialchars($emisor['provincia'] ?? ''); ?>" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label for="distrito" class="block font-medium">Distrito:</label>
                <input type="text" id="distrito" name="distrito" value="<?php echo htmlspecialchars($emisor['distrito'] ?? ''); ?>" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <button type="submit" 
                    class="w-full px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
                Guardar Cambios
            </button>
        </form>
    </div>
</div>
</div>
<?php include('../includes/footer.php'); ?>
