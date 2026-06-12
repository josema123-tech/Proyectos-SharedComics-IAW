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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <header class="p-3 text-bg-dark"> 
        <div class="container"> 
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start"> 
                
                <a href="index.php" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none"> 
                    <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap">
                        <use xlink:href="#bootstrap"></use>
                    </svg> 
                </a> 

                <?php
                if (!isset($_SESSION['user'])) {
                    // MENÚ PARA USUARIOS NO LOGUEADOS
                    echo "<ul class='nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0'> 
                        <li><a href='index.php' class='nav-link px-2 text-white'>Home</a></li> 
                        <li><a href='categorias.php' class='nav-link px-2 text-white'>Categorías</a></li> 
                        <li><a href='buscador.php' class='nav-link px-2 text-white'>BUSCADOR</a></li> 
                    </ul>
                    <div class='text-end'> 
                        <a class='btn btn-outline-light me-2' href='/dashboard/loguearse.php' role='button'>Login</a> 
                        <a class='btn btn-warning' href='/dashboard/suscribirse.php' role='button'>Sign-up</a>
                    </div>";
                } else {
                    // MENÚ PARA USUARIOS AUTENTICADOS
                    echo "<ul class='nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0'> 
                        <li><a href='index.php' class='nav-link px-2 text-white'>Home</a></li> 
                        <li><a href='categorias.php' class='nav-link px-2 text-white'>Categorías</a></li> 
                        <li><a href='buscador.php' class='nav-link px-2 text-white'>BUSCADOR</a></li> 
                        <li><a href='favoritos.php' class='nav-link px-2 text-white'>mis comics</a></li> 
                        <li><a href='subir_comics.php' class='nav-link px-2 text-white'>subir comics</a></li> 
                    </ul>
                    
                    <div class='dropdown text-center'> 
                        <a href='#' class='d-inline-block text-white text-decoration-none' 
                           id='Menu' 
                           data-bs-toggle='dropdown' 
                           aria-expanded='false' 
                           style='cursor: pointer;'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-person-square' viewBox='0 0 16 16'>
                                <path d='M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0'/>
                                <path d='M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z'/>
                            </svg>
                            <p class='dropdown-item-text mb-0 fw-bold text-secondary'>" . ($_SESSION['user']) . "</p>
                        </a> 

                        <ul class='dropdown-menu dropdown-menu-end text-medium' aria-labelledby='Menu'> 
                            <li><hr class='dropdown-divider'></li>
                            <li><a class='dropdown-item' href='ver_perfil.php'>Ver Perfil</a></li> 
                            <li><a class='dropdown-item' href='editar_perfil.php'>Editar Perfil</a></li> 
                            <li><hr class='dropdown-divider'></li> 
                            <li><a class='dropdown-item text-danger' href='logout.php'>Salir</a></li> 
                        </ul> 
                    </div>";
                }
                ?>

            </div> 
        </div> 
    </header>
</body>
</html>