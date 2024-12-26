<?php include('../includes/header.php'); ?>

<div class="flex min-h-screen">
  <!-- Sidebar -->
  <?php include('../includes/sidebar.php'); ?>

  <!-- Contenido Principal -->
  <div class="ml-64 p-8 w-full bg-gray-400">
    <div class="w-full p-6 bg-white shadow-lg rounded-lg">
        <form id="factura-form" action="../src/Util.php" method="post" class="space-y-6" onsubmit="event.preventDefault(); enviarFactura();">
          
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
                    <!-- Productos -->
                </div>
                <button type="button" onclick="agregarProducto()" 
                        class="mt-4 px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400">
                    Agregar Producto
                </button>
            </div>

            <!-- Botón para Generar Factura -->
            <div>
                <button type="submit" 
                        class="w-full px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    Generar Factura
                </button>
            </div>
        </form>

        <!-- Mostrar el botón para ver el PDF si la factura fue generada correctamente -->
        <div id="pdfLink" class="mt-4" style="display: none;">
            <a href="#" id="viewPdfBtn" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
                Ver PDF de la Factura
            </a>
        </div>

        <!-- Notificación de éxito o error -->
        <div id="notificacion" class="hidden p-4 mt-4 bg-green-200 text-green-800 rounded-lg">
            Factura generada con éxito.
        </div>
        <div id="notificacionError" class="hidden p-4 mt-4 bg-red-200 text-red-800 rounded-lg">
            Hubo un error al generar la factura.
        </div>
    </div>
  </div>
</div>

<script>
    // Función para agregar productos (sin cambios)
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

    // Función para enviar la factura utilizando AJAX
    function enviarFactura() {
        const form = document.getElementById('factura-form');
        const formData = new FormData(form);

        // Realizar la solicitud AJAX
        fetch('../src/Util.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json()) // Suponemos que la respuesta es JSON
        .then(data => {
            // Notificar al usuario si la factura fue generada con éxito
            if (data.success) {
                document.getElementById('notificacion').textContent = "Factura generada con éxito.";
                document.getElementById('notificacion').classList.remove('hidden');
                document.getElementById('pdfLink').style.display = 'block';
                document.getElementById('viewPdfBtn').href = data.pdfUrl; // Suponemos que el servidor devuelve la URL del PDF
            } else {
                document.getElementById('notificacionError').textContent = "Hubo un error al generar la factura.";
                document.getElementById('notificacionError').classList.remove('hidden');
            }
        })
        .catch(error => {
            // En caso de error, mostrar una notificación de error
            document.getElementById('notificacionError').textContent = "Hubo un error al generar la factura.";
            document.getElementById('notificacionError').classList.remove('hidden');
        });
    }
</script>

<?php include('../includes/footer.php'); ?>
