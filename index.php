<?php
    session_start();
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
    <!-- Cambiado: Añadida la clase 'custom-header' -->
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

        </div> 
    </div> 
</header>
</body>
</html>