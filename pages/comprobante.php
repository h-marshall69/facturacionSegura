<?php include('../includes/header.php'); ?>

<div class="flex min-h-screen">
  <!-- Sidebar -->
  <?php include('../includes/sidebar.php'); ?>

  <!-- Contenido Principal -->
  <div class="ml-64 p-8 w-full bg-gray-400">
    <div class="w-full p-6 bg-white shadow-lg rounded-lg">
        <form action="../src/Util.php" method="POST" class="space-y-6">
          
            <!-- Detalles de la Factura -->
            <div class="space-y-4">
                <h2 class="text-xl font-semibold text-gray-700">Detalles de la Factura</h2>
                <div>
                    <label for="serie" class="block font-medium">Serie:</label>
                    <input type="text" id="serie" name="serie" required value="F001" placeholder="F001" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <div>
                    <label for="correlativo" class="block font-medium">Correlativo:</label>
                    <input type="text" id="correlativo" name="correlativo" required value="1" placeholder="1" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <div>
                    <label for="fechaEmision" class="block font-medium">Fecha de Emisión:</label>
                    <input type="datetime-local" id="fechaEmision" name="fechaEmision" required 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <div>
                    <label for="moneda" class="block font-medium">Tipo de Moneda:</label>
                    <input type="text" id="moneda" name="moneda" required value="PEN" placeholder="PEN" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
            </div>

            <!-- Datos del Cliente -->
            <div class="space-y-4">
                <h2 class="text-xl font-semibold text-gray-700">Datos del Cliente</h2>
                <div>
                    <label for="tipoDoc" class="block font-medium">Tipo de Documento:</label>
                    <select id="tipoDoc" name="tipoDoc" required 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="6">RUC</option>
                        <option value="1">DNI</option>
                    </select>
                </div>
                <div>
                    <label for="numDoc" class="block font-medium">Número de Documento:</label>
                    <input type="text" id="numDoc" name="numDoc" required value="20000000001" placeholder="20000000001" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <div>
                    <label for="rznSocial" class="block font-medium">Razón Social:</label>
                    <input type="text" id="rznSocial" name="rznSocial" required value="EMPRESA X" placeholder="EMPRESA X" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
            </div>

            <!-- Detalles de los Productos -->
            <div class="space-y-4">
                <h2 class="text-xl font-semibold text-gray-700">Detalles de los Productos</h2>
                <div id="productos" class="space-y-4">
                    <div class="producto border p-4 rounded-lg bg-gray-50">
                        <h3 class="font-semibold text-lg text-gray-700">Producto 1</h3>
                        <div>
                            <label for="codigo_1" class="block font-medium">Código del Producto:</label>
                            <input type="text" id="codigo_1" name="productos[1][codigo]" required 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>
                        <div>
                            <label for="descripcion_1" class="block font-medium">Descripción:</label>
                            <input type="text" id="descripcion_1" name="productos[1][descripcion]" required 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>
                        <div>
                            <label for="cantidad_1" class="block font-medium">Cantidad:</label>
                            <input type="number" id="cantidad_1" name="productos[1][cantidad]" step="1" required 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>
                        <div>
                            <label for="precio_1" class="block font-medium">Precio Unitario:</label>
                            <input type="number" id="precio_1" name="productos[1][precio]" step="0.01" required 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>
                    </div>
                </div>
                <button type="button" onclick="agregarProducto()" 
                        class="mt-4 px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400">
                    Agregar Producto
                </button>
            </div>

            <!-- Botón para Generar Factura -->
            <div>
                <button type="submit" id="generarFactura" 
                        class="w-full px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    Generar Factura
                </button>
            </div>
        </form>
        <!-- Notificación -->
        <div id="notificacion" class="mt-4 hidden text-green-600"></div>
    </div>
  </div>
</div>

<script>
    function agregarProducto() {
        const container = document.getElementById('productos');
        const index = container.children.length + 1;

        const div = document.createElement('div');
        div.classList.add('producto', 'border', 'p-4', 'rounded-lg', 'bg-gray-50', 'mt-4');

        div.innerHTML = `
            <label for="producto${index}_descripcion" class="block font-medium">Descripción:</label>
            <input type="text" id="producto${index}_descripcion" name="productos[${index}][descripcion]" class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="Descripción del producto">

            <label for="producto${index}_cantidad" class="block font-medium mt-2">Cantidad:</label>
            <input type="number" id="producto${index}_cantidad" name="productos[${index}][cantidad]" class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="Cantidad">

            <label for="producto${index}_precio" class="block font-medium mt-2">Precio:</label>
            <input type="number" id="producto${index}_precio" name="productos[${index}][precio]" class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="Precio">
        `;

        container.appendChild(div);
    }
</script>

<?php include('../includes/footer.php'); ?>
