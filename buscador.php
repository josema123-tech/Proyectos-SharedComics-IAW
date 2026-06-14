<?php
session_start();
$conexion = new mysqli("localhost", "root", "", "sharedcomics");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
$nombre = isset($_GET['nombre']) ? trim($_GET['nombre']) : '';
$categoria_id = isset($_GET['categoria']) ? trim($_GET['categoria']) : '';
$autor_id = isset($_GET['autor']) ? trim($_GET['autor']) : '';
$query = "SELECT DISTINCT comic_id, comic_titulo, comic_descripcion, comic_portada
FROM vista_completa_sharedcomics
WHERE 1=1";
if ($nombre !== '') {
    $nombre_limpio = $conexion->real_escape_string($nombre);
    $query .= " AND comic_titulo LIKE '%$nombre_limpio%'";
}
if ($categoria_id !== '') {
    $categoria_id_limpio = $categoria_id;
    $query .= " AND categoria_id = $categoria_id_limpio";
}
if ($autor_id !== '') {
    $autor_id_limpio = $autor_id;
    $query .= " AND usuario_id = $autor_id_limpio";
}
$query .= " ORDER BY comic_fecha_subida DESC";
$resultado_comics = $conexion->query($query);
$numerototalcomics = $resultado_comics->num_rows;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscador Avanzado - SharedComics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="custom.css">
</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<body class="bg-light">
    <header class="p-0 text-bg-dark">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between p-3">
                <a href="index.php" class="text-white text-decoration-none fw-bold fs-4">SharedComics - Buscador</a>
                <a href="index.php" class="btn btn-outline-light btn-sm">Volver al Home</a>
            </div>
        </div>
    </header>
    <main class="container my-5">
        <div class="card p-4 border border border-3 rounded shadow-sm bg-white mb-5">
            <h2 class="text-center mb-4 fw-bold text-uppercase" style="letter-spacing: 1px;">Buscador de Cómics</h2>
            <form action="buscador.php" method="GET">
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="input-group input-group-lg">
                            <input type="text" name="nombre" class="form-control border"
                                placeholder="Escribe el título del cómic..." value="<?php echo ($nombre); ?>" >
                        </div>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label fw-bold">Filtrar por Género</label>
                        <select name="categoria" class="form-select border">
                            <option value="">Todas las categorías</option>
                            <?php
                            $res_cat = $conexion->query("SELECT id, nombre FROM categorias ORDER BY nombre ASC");
                            while ($cat = $res_cat->fetch_assoc()) {
                                $selected = ($categoria_id == $cat['id']) ? 'selected' : '';
                                echo "<option value='{$cat['id']}' $selected>{$cat['nombre']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label fw-bold">Subido por (Usuario)</label>
                        <select name="autor" class="form-select border">
                            <option value="">Cualquier usuario</option>
                            <?php
                            $res_user = $conexion->query("SELECT id, username FROM usuarios ORDER BY username ASC");
                            while ($user = $res_user->fetch_assoc()) {
                                $selected = ($autor_id == $user['id']) ? 'selected' : '';
                                echo "<option value='{$user['id']}' $selected>{$user['username']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-dark w-100 fw-bold py-2 text-uppercase"> Buscar</button>
                    </div>
                </div>
            </form>
        </div>
        <section class=" py-4">
            <h3 class="mb-4 text-secondary border-bottom pb-2"><?php echo ($numerototalcomics) ?> Resultados</h3>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4 justify-content-center">
                <?php
                if ($resultado_comics && $resultado_comics->num_rows > 0) {
                    while ($comic = $resultado_comics->fetch_assoc()) {
                        $id_comic = $comic['comic_id'];
                        ?>
                        <div class="col">
                            <div class="card h-100 text-bg-light border shadow-sm">
                                <img src="<?php echo ($comic['comic_portada']); ?>" class="card-img-top w-100 object-fit-cover"
                                    alt="<?php echo ($comic['comic_titulo']); ?>" style="height: 250px;">
                                <div class="card-body d-flex flex-column p-3">
                                    <h5 class="card-title fw-bold text-uppercase text-truncate small mb-1"
                                        title="<?php echo ($comic['comic_titulo']); ?>">
                                        <?php echo ($comic['comic_titulo']); ?>
                                    </h5>
                                    <div class="mb-3">
                                        <a class="small text-decoration-none fw-semibold d-inline-block mb-1"
                                            data-bs-toggle="collapse" href="#desc-<?php echo $id_comic; ?>"
                                            aria-controls="desc-<?php echo $id_comic; ?>"> 📄 Leer descripción...</a>
                                        <div class="collapse" id="desc-<?php echo $id_comic; ?>">
                                            <div class="card card-body text-dark p-2 border-0 mt-1 small"
                                                style="font-size: 0.8rem; line-height: 1.4;">
                                                <?php echo ($comic['comic_descripcion']); ?> </div>
                                        </div>
                                    </div>
                                    <a href="comic.php?id=<?php echo $id_comic; ?>"
                                        class="btn btn-sm btn-outline-dark fw-bold mt-auto w-100"> Ver Comic </a>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "
                        <div class='col-12 w-100 text-center mt-3'>
                            <div class='alert alert-warning border border-warning' role='alert'>
                                <h5 class='fw-bold mb-1'>No se encontraron cómics</h5>
                                <p class='small mb-0'>Prueba ajustando los criterios de los menús desplegables o cambiando el texto.</p>
                            </div>
                        </div>";
                }
                ?>
            </div>
        </section>
    </main>
</body>

</html>