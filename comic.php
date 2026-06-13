<?php
// Conexión a la base de datos
$conexion = new mysqli('localhost', 'root', '', 'sharedcomics');
// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
// Obtener el ID del cómic de la URL 
$id_comic = filter_input(INPUT_GET, 'id');
if (!$id_comic) {
    header('Location: index.php'); 
    exit;
}
// Preparar y ejecutar la consulta para obtener los datos del cómic
$sql_comic = "SELECT titulo, descripcion, pdf_comic FROM comics WHERE id = ?";
$stmt_comic = $conexion->prepare($sql_comic);
$stmt_comic->bind_param("i", $id_comic); 
$stmt_comic->execute();
$resultado_comic = $stmt_comic->get_result();
$comic = $resultado_comic->fetch_assoc();
// Verificar si el cómic existe
if (!$comic) {
    echo "El cómic solicitado no existe.";
    exit;
}
// Preparar y ejecutar la consulta para obtener las páginas del cómic
$sql_paginas = "SELECT ruta_imagen FROM paginas WHERE comic_id = ? ORDER BY numero_pagina ASC";
$stmt_paginas = $conexion->prepare($sql_paginas);
$stmt_paginas->bind_param("i", $id_comic);
$stmt_paginas->execute();
$resultado_paginas = $stmt_paginas->get_result();
// Almacenar las rutas de las páginas en un array
$paginas = [];
while ($fila = $resultado_paginas->fetch_assoc()) {
    $paginas[] = $fila['ruta_imagen'];
}
// Cerrar las consultas y la conexión
$stmt_comic->close();
$stmt_paginas->close();
$conexion->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($comic['titulo']); ?> - Lector</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container my-4">
        <div class="row justify-content-center">
           <div class="container-fluid p-2">
                <div class="p-3 bg-white border border-secondary-subtle rounded shadow-sm text-center">
                    <a href="index.php" class="btn btn-outline-secondary btn-sm mb-3 d-inline-block">← Volver al catálogo</a>
                    <h1 class="display-5 fw-bold text-dark"><?php echo htmlspecialchars($comic['titulo']); ?></h1>
                    <hr class="my-3 mx-auto text-secondary" style="max-width: 100px;">
                    <p class="text-muted mx-auto mb-0" style="max-width: 600px;"><?php echo htmlspecialchars($comic['descripcion']); ?></p>
                </div>
            </div>
    
         </div>

    </div>
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-7">
                <?php if (empty($paginas)): ?>
                    <div class="alert alert-warning text-center" role="alert">
                        Este cómic no tiene páginas disponibles todavía.
                    </div>
               <?php else: ?>
                    <div id="lectorComic" class="carousel carousel-dark slide shadow-lg rounded bg-dark p-2 mb-4" data-bs-ride="false" data-bs-interval="false">
                        <div class="text-center my-2 fw-bold text-white-50">
                            Total: <?php echo count($paginas); ?> páginas
                        </div>
                        
                        <div class="carousel-inner text-center">
                            <?php foreach ($paginas as $index => $ruta_imagen): ?>
                                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                    <img src="<?php echo htmlspecialchars($ruta_imagen); ?>" class="d-block mx-auto img-fluid" alt="Página del cómic" style="max-height: 80vh; object-fit: contain;">
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="d-flex justify-content-center align-items-center gap-2 mt-3 mb-2">
                            <span class="text-white-50 small">Ir a la página:</span>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-light dropdown-toggle" type="button" id="desplegablePaginas" data-bs-toggle="dropdown" aria-expanded="false">
                                    Seleccionar...
                                </button>
                                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="desplegablePaginas" style="max-height: 250px; overflow-y: auto;">
                                    <?php foreach ($paginas as $index => $ruta_imagen): ?>
                                        <li>
                                            <button type="button" 
                                                    class="dropdown-item small" 
                                                    data-bs-target="#lectorComic" 
                                                    data-bs-slide-to="<?php echo $index; ?>">
                                                Página <?php echo $index + 1; ?>
                                            </button>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>

                    </div>
                <?php endif; ?>

                <div class="card m-2">
                    <div class="card-body text-center">
                        <p class="fw-bold">¿TAMBIÉN PUEDES DESCARGAR EL PDF AQUÍ?</p>
                        <?php if (!empty($comic['pdf_comic']) && file_exists($comic['pdf_comic'])): ?>
                            <a href="<?php echo htmlspecialchars($comic['pdf_comic']); ?>" download="<?php echo htmlspecialchars($comic['titulo']); ?>.pdf" class="btn btn-success btn-sm mb-3">
                                📥 Descargar PDF
                            </a>
                        <?php else: ?>
                            <button class="btn btn-secondary btn-sm mb-3" disabled title="PDF no disponible">
                                📥 PDF no disponible
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>