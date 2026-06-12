<?php
session_start();

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "sharedcomics");
$user_session = $_SESSION['user'];

// Obtener los datos actuales del usuario
$stmt = $conexion->prepare("SELECT username, email FROM usuarios WHERE username = ?");
$stmt->bind_param("s", $user_session);
$stmt->execute();
$resultado = $stmt->get_result();
$usuario = $resultado->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - SharedComics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark mb-5">
        <div class="container">
            <a class="navbar-brand" href="index.php">SharedComics</a>
            <a href="logout.php" class="btn btn-outline-danger btn-sm">Cerrar Sesión</a>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-5">
                
                <div class="card shadow border-0 text-center">
                    <div class="card-header bg-primary text-white p-4">
                        <h4 class="mb-0 fw-bold">Perfil de Usuario</h4>
                    </div>

                        <div class="mb-3">
                            <small class="text-muted d-block text-uppercase fw-semibold" style="font-size: 0.75rem;">Nombre de Usuario</small>
                            <span class="fs-4 fw-normal text-dark"><?php echo ($usuario['username']); ?></span>
                        </div>

                        <div class="mb-4">
                            <small class="text-muted d-block text-uppercase fw-semibold" style="font-size: 0.75rem;">Correo Electrónico</small>
                            <span class="fs-5 text-secondary"><?php echo ($usuario['email']); ?></span>
                        </div>

                        <hr class="my-4">

                        <div class="d-grid gap-2">
                            <a href="editar_perfil.php" class="btn btn-primary">
                                Editar mi Perfil
                            </a>
                            <a href="index.php" class="btn btn-outline-secondary">
                                Volver al Inicio
                            </a>
                        </div>
                    </div>
                </div> </div>
        </div>
    </div>
</body>
</html>