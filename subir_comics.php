<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: loguearse.php');
    exit();
}

$conexion = new mysqli('localhost', 'root', '', 'sharedcomics');
$errors = [];
$success = false;

// Conseguir el ID del usuario actual
$username = $_SESSION['user'];
$res_user = $conexion->query("SELECT id FROM usuarios WHERE username = '$username'");
$user_data = $res_user->fetch_assoc();
$user_id = $user_data['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $categoria_id = $_POST['categoria'];

    if (empty($titulo) || empty($descripcion) || empty($categoria_id)) {
        $errors[] = 'Todos los campos de texto y la categoría son obligatorios.';
    }

    // Validar que se haya subido la portada
    if (!isset($_FILES['portada']) || $_FILES['portada']['error'] !== UPLOAD_ERR_OK) {
        $errors[] = 'Es obligatorio subir una portada.';
    }

    // Validar que se hayan subido páginas del cómic
    if (!isset($_FILES['paginas']) || empty($_FILES['paginas']['name'][0])) {
        $errors[] = 'Debes subir las imágenes que componen las páginas del cómic.';
    }

    if (empty($errors)) {

        // 1. Crear directorios base si no existen
        if (!is_dir('imagenes/comics_portada')) {
            mkdir('imagenes/comics_portada', 0777, true);
        }

        // 2. Mover la Portada principal
        $portadaNombre = time() . "_" . $_FILES['portada']['name'];
        $portadaDestino = 'imagenes/comics_portada/' . $portadaNombre;
        move_uploaded_file($_FILES['portada']['tmp_name'], $portadaDestino);

        // 3. Mover el PDF (opcional)
        $pdf_ruta = "";
        if (isset($_FILES['pdf_comic']) && $_FILES['pdf_comic']['error'] === UPLOAD_ERR_OK) {
            if (!is_dir('PDF')) {
                mkdir('PDF', 0777, true);
            }
            $pdfNombre = time() . "_" . $_FILES['pdf_comic']['name'];
            $pdf_ruta = 'PDF/' . $pdfNombre;
            move_uploaded_file($_FILES['pdf_comic']['tmp_name'], $pdf_ruta);
        }

        // 4. Insertar el cómic en la tabla 'comics'
        $insertarComic = "INSERT INTO comics (titulo, descripcion, portada, usuario_id, pdf_comic, fecha_subida) 
                          VALUES ('$titulo', '$descripcion', '$portadaDestino', '$user_id', '$pdf_ruta', NOW())";

        if ($conexion->query($insertarComic)) {
            $new_comic_id = $conexion->insert_id;

            // 5. Insertar la categoría asociada
            $insertarCategoria = "INSERT INTO comic_categoria (comic_id, categoria_id) 
                                  VALUES ('$new_comic_id', '$categoria_id')";
            $conexion->query($insertarCategoria);

            // 6. PROCESAR Y SUBIR LAS PÁGINAS (ESTRUCTURA: imagenes/paginascomics/[nombre-comic]/)
            // Limpiamos el título para que el nombre de la carpeta no tenga caracteres raros ni espacios molestos
            $nombreCarpetaComic = str_replace(' ', '_', $titulo);
            $dirPaginas = 'imagenes/paginascomics/' . $nombreCarpetaComic;

            // Creamos la carpeta del cómic si no existe
            if (!is_dir($dirPaginas)) {
                mkdir($dirPaginas, 0777, true);
            }

            // Recorremos todas las imágenes que el usuario seleccionó
            $total_archivos = count($_FILES['paginas']['name']);
            for ($i = 0; $i < $total_archivos; $i++) {
                if ($_FILES['paginas']['error'][$i] === UPLOAD_ERR_OK) {

                    // Definimos el número de página (empezando en 1)
                    $numero_pagina = $i + 1;

                    // Extraemos la extensión original (.jpg, .png, etc.)
                    $extension = pathinfo($_FILES['paginas']['name'][$i], PATHINFO_EXTENSION);

                    // Construimos el nombre exacto como pides: pagina1.jpg, pagina2.jpg...
                    $nombrePaginaArchivo = "pagina" . $numero_pagina . "." . $extension;
                    $rutaCompletaImagen = $dirPaginas . "/" . $nombrePaginaArchivo;

                    // Movemos el archivo temporal a su carpeta correspondiente
                    if (move_uploaded_file($_FILES['paginas']['tmp_name'][$i], $rutaCompletaImagen)) {
                        $insertarPagina = "INSERT INTO paginas (comic_id, ruta_imagen, numero_pagina) 
                                           VALUES ('$new_comic_id', '$rutaCompletaImagen', '$numero_pagina')";
                        $conexion->query($insertarPagina);
                    }
                }
            }

            $success = true;
        } else {
            $errors[] = 'Error al guardar el cómic en la base de datos.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Cómic - SharedComics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-success shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="text-center mb-4 fw-bold text-success">Subir Cómic</h2>

                        <?php if ($success): ?>
                            <div class="alert alert-success">¡Cómic y todas sus páginas publicados con éxito!</div>
                        <?php endif; ?>

                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger">
                                <?php foreach ($errors as $error)
                                    echo "<p class='mb-0'>$error</p>"; ?>
                            </div>
                        <?php endif; ?>

                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="titulo" class="form-label fw-bold text-success">Título del Cómic</label>
                                <input type="text" class="form-control border-success" id="titulo" name="titulo"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="descripcion" class="form-label fw-bold text-success">Descripción</label>
                                <textarea class="form-control border-success" id="descripcion" name="descripcion"
                                    rows="3" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="categoria" class="form-label fw-bold text-success">Categoría</label>
                                <select class="form-select border-success" id="categoria" name="categoria" required>
                                    <option value="">Selecciona una categoría...</option>
                                    <?php
                                    $categorias = $conexion->query("SELECT id, nombre FROM categorias ORDER BY nombre ASC");
                                    while ($cat = $categorias->fetch_assoc()) {
                                        echo "<option value='" . $cat['id'] . "'>" . $cat['nombre'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="portada" class="form-label fw-bold text-success">Imagen de Portada
                                    (Miniatura)</label>
                                <input type="file" class="form-control border-success" id="portada" name="portada"
                                    accept="image/*" required>
                            </div>

                            <div class="mb-3">
                                <label for="paginas" class="form-label fw-bold text-success">Seleccionar Páginas del
                                    Cómic (Imágenes)</label>
                                <input type="file" class="form-control border-success" id="paginas" name="paginas[]"
                                    accept="image/*" multiple required>
                                <div class="form-text text-muted">Puedes seleccionar varios archivos de imagen a la vez
                                    (Se nombrarán automáticamente ordenados).</div>
                            </div>

                            <div class="mb-4">
                                <label for="pdf_comic" class="form-label fw-bold text-success">Archivo PDF
                                    (Opcional)</label>
                                <input type="file" class="form-control border-success" id="pdf_comic" name="pdf_comic"
                                    accept="application/pdf">
                            </div>

                            <button type="submit" class="btn btn-success w-100 fw-bold">Publicar Cómic Completo</button>

                            <div class="d-flex justify-content-between mt-3">
                                <a href="index.php" class="btn btn-sm btn-outline-secondary">Volver al Inicio</a>
                                <a href="mis_comics.php" class="btn btn-sm btn-outline-success">Mis Cómics</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>