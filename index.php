<?php
// inicio de sesion y conexion a la base de datos
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
    <!-- header de la pagina -->
    <header class="p-0 text-bg-dark custom-header">
        <div class="container-fluid ">
            <div class="d-flex align-items-center justify-content-center justify-content-lg-start">
                <a href="index.php" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none me-3">
                    <img src="imagenes/images.png" alt="Logo" height="70" class="d-inline-block align-text-top ">
                </a>

                <?php
                if (!isset($_SESSION['user'])) {
                    // en caso de no estar logueado, mostrar los siguientes datos
                    echo "<ul class='nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0'> 
                    <li><a href='index.php' class='nav-link px-2 text-white fw-bolder'>HOME</a></li>  
                    <li><a href='buscador.php' class='nav-link px-2 text-white fw-bolder'>BUSCADOR</a></li> 
                </ul>
                <div class='text-end'> 
                    <a class='btn btn-outline-light me-2' href='/dashboard/loguearse.php' role='button'>Login</a> 
                    <a class='btn btn-success' href='/dashboard/suscribirse.php' role='button'>Sign-up</a>
                </div>";
                } else {
                // en caso de SI estar logueado mostar los siguientes datos
                    echo "<ul class='nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0'> 
                    <li><a href='index.php' class='nav-link px-2 text-white fw-bolder'>HOME</a></li>  
                    <li><a href='buscador.php' class='nav-link px-2 text-white fw-bolder'>BUSCADOR</a></li> 
                    <li><a href='mis_comics.php' class='nav-link px-2 text-white fw-bolder'>MIS COMICS</a></li> 
                    <li><a href='subir_comics.php' class='nav-link px-2 text-white fw-bolder'>SUBIR COMICS</a></li> 
                </ul>
                <!-- menu estilo desplegable del apartado del usuario -->
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
            </div>
        </div>
    </header>
    <!-- contenido principal de la pagina -->
    <main class="container-fluid p-2">
    <!-- carrusel promocional -->
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
        <!-- titulo seccion de novedades -->
        <section class=" custom-font bg-light text-white py-5 border-top border-warning border-3">
            <div class="container">
                <div class="border border-success border-3 m-2 p-2" style="background: rgb(255, 255, 255)">
                <h2 class="text-start text-uppercase mb-1 fw-bold display-5 text-success text-center" style="letter-spacing: 1px;">
                    Últimas Novedades
                </h2>
                <p class="text-start text-success text-center mb-4 small">
                    Descubre los últimos comics subidos por nuestros usuarios. ¡Explora y disfruta de nuevas historias!
                </p>
            </div>

        <!-- seccion donde se muestran los 30 comics mas actuales, por fecha de subida -->
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4 justify-content-center">
                    <?php
                    $query = "SELECT id, titulo, descripcion, portada, usuario_id
                  FROM comics 
                  ORDER BY fecha_subida DESC 
                  LIMIT 30";

                    $resultado = mysqli_query($conexion, $query);
                    if ($resultado) {
                        while ($comic = mysqli_fetch_assoc($resultado)) {
                            ?>
                            <div class="col">
                                <div class="card h-100 text-bg-light border-success shadow-sm">

                                    <img src="<?php echo ($comic['portada']); ?>" class="card-img-top w-100 object-fit-cover"
                                        alt="<?php echo ($comic['titulo']); ?>" style="height: 250px;">
                                    <div class="card-body d-flex flex-column p-3">

                                        <h5 class="card-title fw-bold text-uppercase text-truncate small mb-1"
                                            title="<?php echo ($comic['titulo']); ?>">
                                            <?php echo ($comic['titulo']); ?>
                                        </h5>
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
        </section>
        </div>
    </main>
    <div class="container"> 
        <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top"> 
            <div class="col-md-4 d-flex align-items-center"> 
                <a href="/" class="mb-3 me-2 mb-md-0 text-body-secondary text-decoration-none lh-1" aria-label="Bootstrap"> 
                   <img src="imagenes/images.png" alt="Logo" height="70" class="d-inline-block align-text-top "> 
                </a> 
                <span class="mb-3 mb-md-0 text-body-secondary">© 2026 José Manuel Párraga Galván</span> 
            </div> 
            <ul class="nav col-md-4 justify-content-end list-unstyled d-flex"> 
                <li class="ms-3"><a class="text-body-secondary" href="#" aria-label="Instagram"><svg class="bi" width="24" height="24" aria-hidden="true"><use xlink:href="#instagram"></use></svg></a></li> 
            <li class="ms-3"><a class="text-body-secondary" href="#" aria-label="Facebook"><svg class="bi" width="24" height="24"><use xlink:href="#facebook"></use></svg></a></li> 
        </ul> 
    </footer> 
</div>
</body>
</html>