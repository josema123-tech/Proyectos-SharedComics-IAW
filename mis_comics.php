<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
}
$conexion = new mysqli("localhost", "root", "", "sharedcomics");
$username_sesion = $conexion->real_escape_string($_SESSION['user']);
$res_user = $conexion->query("SELECT id FROM usuarios WHERE username = '$username_sesion'");
$user_data = $res_user->fetch_assoc();
$user_id = (int) $user_data['id'];
$res_total = $conexion->query("SELECT obtener_total_comics_usuario($user_id) AS total");
$total_data = $res_total->fetch_assoc();
$total_comics = (int) $total_data['total'];
if (isset($_POST['eliminar_id']) && is_numeric($_POST['eliminar_id'])) {
    $comic_id = (int) $_POST['eliminar_id'];
    $stmt_archivos = $conexion->prepare("SELECT portada, pdf_comic FROM comics WHERE id = ?");
    $stmt_archivos->bind_param("i", $comic_id);
    $stmt_archivos->execute();
    $res_archivos = $stmt_archivos->get_result();
    if ($res_archivos && $res_archivos->num_rows > 0) {
        $comic_files = $res_archivos->fetch_assoc();
        $res_paginas = $conexion->query("SELECT ruta_imagen FROM paginas WHERE comic_id = $comic_id");
        if ($res_paginas) {
            while ($pagina = $res_paginas->fetch_assoc()) {
                if (file_exists($pagina['ruta_imagen']))
                    unlink($pagina['ruta_imagen']);
            }
        }
        if (!empty($comic_files['portada']) && file_exists($comic_files['portada'])) {
            unlink($comic_files['portada']);
        }
        if (!empty($comic_files['pdf_comic']) && file_exists($comic_files['pdf_comic'])) {
            unlink($comic_files['pdf_comic']);
        }
        $stmt_proc = $conexion->prepare("CALL eliminar_comic(?)");
        $stmt_proc->bind_param("i", $comic_id);
        $stmt_proc->execute();
        $stmt_proc->close();
    }
    $stmt_archivos->close();
    header("Location: mis_comics.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Mis Cómics - SharedComics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="custom.css">
</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<body class="bg-light">
    <header class="p-0 text-bg-dark custom-header">
        <div class="container-fluid ">
            <div class="d-flex align-items-center justify-content-center justify-content-lg-start">
                <a href="index.php" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none me-3">
                    <img src="imagenes/images.png" alt="Logo" height="70" class="d-inline-block align-text-top ">
                </a>
                <ul class='nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0'>
                    <li><a href='index.php' class='nav-link px-2 text-white fw-bolder'>HOME</a></li>
                    <li><a href='buscador.php' class='nav-link px-2 text-white fw-bolder'>BUSCADOR</a></li>
                    <li><a href='mis_comics.php' class='nav-link px-2 text-white fw-bolder'>MIS COMICS</a></li>
                    <li><a href='subir_comics.php' class='nav-link px-2 text-white fw-bolder'>SUBIR COMICS</a></li>
                </ul>
                <!-- menu estilo desplegable del apartado del usuario -->
                <div class='dropdown text-center me-5'>
                    <a href='#' class='d-inline-block text-white text-decoration-none' id='Menu'
                        data-bs-toggle='dropdown' aria-expanded='false' style='cursor: pointer;'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor'
                            class='bi bi-person-square ' viewBox='0 0 16 16'>
                            <path d='M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0' />
                            <path
                                d='M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z' />
                        </svg>
                        <p class='dropdown-item-text mb-0 fw-bold text-white fw-bolder'> <?php echo ($_SESSION['user'])?></p>
                    </a>
                    <ul class='dropdown-centrado dropdown-menu dropdown-menu-start text-medium p-2'
                        aria-labelledby='Menu'>
                        <li><a class='btn btn-outline-success d-grid gap-2' href='ver_perfil.php'>Ver Perfil</a></li>
                        <li><a class='btn btn-outline-success d-grid gap-2' href='editar_perfil.php'>Editar Perfil</a>
                        </li>
                        <li><a class='btn btn-outline-danger d-grid gap-2' href='logout.php'>Salir</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <main class="container my-5">
        <h2 class="text-center text-success fw-bold text-uppercase mb-1">Mis Cómics</h2>
        <p class="text-center text-muted mb-4fw-semibold">
            Total publicados: <span class="badge bg-success fs-6"><?php echo $total_comics; ?></span>
        </p>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4 justify-content-center">
            <?php
            $resultado = $conexion->query("SELECT id, titulo, descripcion, portada FROM comics WHERE usuario_id = $user_id ORDER BY id DESC");
            if ($resultado && $resultado->num_rows > 0) {
                while ($comic = $resultado->fetch_assoc()) {
                    $id_actual = $comic['id'];
                    ?>
                    <div class="col">
                        <div class="card h-100 border-success shadow-sm">
                            <img src="<?php echo htmlspecialchars($comic['portada']); ?>"
                                class="card-img-top w-100 object-fit-cover" style="height: 250px;">
                            <div class="card-body d-flex flex-column p-3">
                                <h5 class="card-title fw-bold text-uppercase text-truncate small mb-1"
                                    title="<?php echo htmlspecialchars($comic['titulo']); ?>">
                                    <?php echo htmlspecialchars($comic['titulo']); ?>
                                </h5>
                                <div class="mb-3">
                                    <a class="text-success small text-decoration-none fw-semibold" data-bs-toggle="collapse"
                                        href="#desc-<?php echo $id_actual; ?>">
                                        📄 Leer descripción...
                                    </a>
                                    <div class="collapse mt-1" id="desc-<?php echo $id_actual; ?>">
                                        <div class="card card-body bg-success text-white p-2 border-0 small"
                                            style="font-size: 0.8rem;">
                                            <?php echo htmlspecialchars($comic['descripcion']); ?>
                                        </div>
                                    </div>
                                </div>
                                <form action="mis_comics.php" method="POST" class="mt-auto w-100">
                                    <input type="hidden" name="eliminar_id" value="<?php echo $id_actual; ?>">
                                    <button type="submit" class="btn btn-sm btn-danger fw-bold w-100 text-uppercase">
                                        Eliminar Cómic
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<div class='col-12 text-center'><p class='alert alert-warning'>No has publicado ningún cómic todavía.</p></div>";
            }
            ?>
        </div>
    </main>
    <?php $conexion->close(); ?>
</body>

</html>