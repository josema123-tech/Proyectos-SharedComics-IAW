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
$sql_comic = "SELECT titulo, descripcion FROM comics WHERE id = ?";
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
<!-- El resto del código HTML para mostrar el cómic y sus páginas -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($comic['titulo']); ?> - Lector</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Ajuste visual para el contenedor del lector de cómics */
        .carousel-item img {
            max-height: 85vh;
            object-fit: contain;
            background-color: #1a1a1a; 
        }
    </style>
</head>
<!-- contenido principal -->
<body class="bg-light">
    <div class="container  my-4">
        <div class="row container mb-4">
            <div class=" col-12">
<!-- Botón de volver al catálogo -->
                <a href="index.php" class="btn btn-outline-secondary btn-sm mb-3">← Volver al catálogo</a>
<!-- Título y descripción del cómic -->
                <h1 class="display-5 fw-bold"><?php echo ($comic['titulo']); ?></h1>
                <p class="text-muted"><?php echo ($comic['descripcion']); ?></p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-7">
<!-- si no hay paginas .... -->
                <?php if (empty($paginas)): ?>
                    <div class="alert alert-warning text-center" role="alert">
                        Este cómic no tiene páginas disponibles todavía.
                    </div>
<!-- carrousel para mostar las paginas -->            
                <?php else: ?>
                    <div id="lectorComic" class="carousel carousel-dark slide shadow-lg rounded" data-bs-ride="false" data-bs-interval="false">
                        <div class="text-center my-2 fw-bold text-muted">
                        Páginas <?php echo count($paginas); ?>
                        </div>
                        <div class="carousel-inner text-center">
                            <?php foreach ($paginas as $index => $ruta_imagen): ?>
                                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                    <img src="<?php echo ($ruta_imagen); ?>" class="d-block w-100" alt="Página del cómic">
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <button class="carousel-control-prev" type="button" data-bs-target="#lectorComic" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon bg-white rounded-circle p-3 shadow-sm" aria-hidden="true"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>

                        <button class="carousel-control-next" type="button" data-bs-target="#lectorComic" data-bs-slide="next">
                            <span class="carousel-control-next-icon bg-white rounded-circle p-3 shadow-sm" aria-hidden="true"></span>
                            <span class="visually-hidden">Siguiente</span>
                        </button>
                    </div><?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>