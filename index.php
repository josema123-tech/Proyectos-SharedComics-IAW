<?php
    // Iniciar sesión
    session_start();
    
?>

<!-- HTML de la página de inicio de sesión -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Primer Sitio con Bootstrap</title>
    
    <!-- 1. CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <header class="p-3 text-bg-dark"> 
        <div class="container"> 
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start"> 
                <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none"> 
                    <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap">
                        <use xlink:href="#bootstrap">

                        </use>
                    </svg> 
                </a> 
                <?php
                if (!isset($_SESSION['user'])) {
                    echo "<ul class='nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0'> 
                        <li><a href='index.php' class='nav-link px-2 text-white'>Home</a></li> 
                        <li><a href='categorias.php' class='nav-link px-2 text-white'>Categorías</a></li> 
                        <li><a href='buscador.php' class='nav-link px-2 text-white'>BUSCADOR</a></li> 
                    </ul>";
                } else {
                    echo "<ul class='nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0'> 
                        <li><a href='index.php' class='nav-link px-2 text-white'>Home</a></li> 
                        <li><a href='categorias.php' class='nav-link px-2 text-white'>Categorías</a></li> 
                        <li><a href='buscador.php' class='nav-link px-2 text-white'>BUSCADOR</a></li> 
                        <li><a href='favoritos.php' class='nav-link px-2 text-white'> mis comics</a></li> 
                        <li><a href='subir_comics.php' class='nav-link px-2 text-white'>subir comics</a></li> 
                    </ul>";
                }
                ?>
                </ul> 
                <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search"> 
                    <input type="search" class="form-control form-control-dark text-bg-dark" placeholder="Search..." aria-label="Search"> 
                </form> 
                <div class="text-end"> 
                    <a class="btn btn-outline-light me-2" href="/dashboard/loguearse.php" role="button">Login</a> 
                    <a class="btn btn-warning" href="/dashboard/suscribirse.php" role="button">Sign-up</a>
                </div> 
            </div> 
        </div> 
    </header>
</body>
</html>