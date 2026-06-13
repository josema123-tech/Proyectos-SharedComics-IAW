<?php
session_start();
$conexion = new mysqli("localhost", "root", "", "sharedcomics");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SharedComics</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="custom.css">
</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<body>
    <!-- HEADER -->
    <header class="p-0 text-bg-dark custom-header">
        <div class="container-fluid ">
            <div class="d-flex align-items-center justify-content-center justify-content-lg-start">

<!-- Cambiado: Insertado el logo dentro del enlace -->
                <a href="index.php" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none me-3">
                    <img src="imagenes/images.png" alt="Logo" height="70" class="d-inline-block align-text-top ">
                </a>

                <?php
                if (!isset($_SESSION['user'])) {
// MENÚ PARA USUARIOS NO LOGUEADOS
                    echo "<ul class='nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0'> 
                    <li><a href='index.php' class='nav-link px-2 text-white fw-bolder'>HOME</a></li> 
                    <li><a href='categorias.php' class='nav-link px-2 text-white fw-bolder'>CATEGORÍAS</a></li> 
                    <li><a href='buscador.php' class='nav-link px-2 text-white fw-bolder'>BUSCADOR</a></li> 
                </ul>
                <div class='text-end'> 
                    <a class='btn btn-outline-light me-2' href='/dashboard/loguearse.php' role='button'>Login</a> 
                    <a class='btn btn-warning' href='/dashboard/suscribirse.php' role='button'>Sign-up</a>
                </div>";
                } else {
// MENÚ PARA USUARIOS AUTENTICADOS
                    echo "<ul class='nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0'> 
                    <li><a href='index.php' class='nav-link px-2 text-white fw-bolder'>HOME</a></li> 
                    <li><a href='categorias.php' class='nav-link px-2 text-white fw-bolder'>CATEGORÍAS</a></li> 
                    <li><a href='buscador.php' class='nav-link px-2 text-white fw-bolder'>BUSCADOR</a></li> 
                    <li><a href='favoritos.php' class='nav-link px-2 text-white fw-bolder'>MIS COMICS</a></li> 
                    <li><a href='subir_comics.php' class='nav-link px-2 text-white fw-bolder'>SUBIR COMICS</a></li> 
                </ul>
                
                <div class='dropdown text-center me-5'> 
                    <a href='#' class='d-inline-block text-white text-decoration-none' 
                       id='Menu' 
                       data-bs-toggle='dropdown' 
                       aria-expanded='false' 
                       style='cursor: pointer;'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-person-square ' viewBox='0 0 16 16'>
                            <path d='M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0'/>
                            <path d='M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z'/>
                        </svg>
                        <p class='dropdown-item-text mb-0 fw-bold text-white fw-bolder'>" . ($_SESSION['user']) . "</p>
                    </a> 

                    <ul class='dropdown-centrado dropdown-menu dropdown-menu-start text-medium p-2' aria-labelledby='Menu'> 
                        <li><a class='btn btn-outline-success d-grid gap-2' href='ver_perfil.php'>Ver Perfil</a></li> 
                        <li><a class='btn btn-outline-success d-grid gap-2' href='editar_perfil.php'>Editar Perfil</a></li> 
                        <li><a class='btn btn-outline-danger d-grid gap-2' href='logout.php'>Salir</a></li> 
                    </ul> 
                </div>";
                }
                ?>
<!-- Fin del menú de navegación -->
            </div>
        </div>
    </header>
<!-- Contenido principal de la página -->
    <main class="container-fluid p-2">
<!-- Carrusel de imágenes plublicitarias -->
        <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="imagenes/Carrusel1.PNG" class="d-block w-100" alt="foto1">
                </div>
                <div class="carousel-item">
                    <img src="imagenes/Carrusel2.PNG" class="d-block w-100" alt="foto2">
                </div>
                <div class="carousel-item">
                    <img src="imagenes/Carrusel3.PNG" class="d-block w-100" alt="foto3">
                </div>
            </div>
        </div>
<!-- Fin del carrusel de imágenes plublicitarias -->
<!-- Sección de Últimas Novedades -->
        <section class="bg-light text-white py-5 border-top border-warning border-3">
            <div class="container">
                <h2 class="text-start text-uppercase mb-1 fw-bold display-5 text-success" style="letter-spacing: 1px;">
                    Últimas Novedades
                </h2>
                <p class="text-start text-success mb-4 small">
                    Descubre los últimos comics subidos por nuestros usuarios. ¡Explora y disfruta de nuevas historias!
                </p>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4 justify-content-center">
                    <?php
// Consulta con la sintaxis de MySQLi obtener los 30 comics más recientes de la base de datos, ordenados por fecha de subida en orden descendente.
                    $query = "SELECT id, titulo, descripcion, portada, usuario_id
                  FROM comics 
                  ORDER BY fecha_subida DESC 
                  LIMIT 30";

                    $resultado = mysqli_query($conexion, $query);
                    if ($resultado) {
                        while ($comic = mysqli_fetch_assoc($resultado)) {
                            ?>
<!-- Mostrar cada comic en una tarjeta -->
                            <div class="col">
                                <div class="card h-100 text-bg-light border-success shadow-sm">

                                    <img src="<?php echo ($comic['portada']); ?>" class="card-img-top w-100 object-fit-cover"
                                        alt="<?php echo ($comic['titulo']); ?>" style="height: 250px;">
                                    <div class="card-body d-flex flex-column p-3">

                                        <h5 class="card-title fw-bold text-uppercase text-truncate small mb-1"
                                            title="<?php echo ($comic['titulo']); ?>">
                                            <?php echo ($comic['titulo']); ?>
                                        </h5>
<!-- desplegable para mostrar la descripción del comic -->
                                        <div class="mb-3">
                                            <a class="text-success small text-decoration-none fw-semibold d-inline-block mb-1"
                                                data-bs-toggle="collapse" href="#desc-<?php echo $comic['id']; ?>"
                                                aria-controls="desc-<?php echo $comic['id']; ?>">
                                                📄 Leer descripción...
                                            </a>

                                            <div class="collapse" id="desc-<?php echo $comic['id']; ?>">
                                                <div class="card card-body bg-success text-white p-2 border-0 mt-1 small"
                                                    style="font-size: 0.8rem; line-height: 1.4;">
                                                    <?php echo ($comic['descripcion']); ?>
                                                </div>
                                            </div>
                                        </div>
<!-- botón para ver el comic -->
                                        <a href="comic.php?id=<?php echo $comic['id']; ?>"
                                            class="btn btn-sm btn-outline-success fw-bold mt-auto w-100">
                                            Ver Comic
                                        </a>
                                    </div>

                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo "<div class='col-12'><p class='text-danger text-center'>Error al cargar las novedades: " . mysqli_error($conexion) . "</p></div>";
                    }
                    ?>
                </div>
            </div>
        </section>
        <!-- Fin de la sección de Últimas Novedades -->
    </main>
</body>

</html>