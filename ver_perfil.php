<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: loguearse.php");
    exit();
}
//realizamos conexion a la base de datos y recogemos informacion del usuario
$conexion = new mysqli("localhost", "root", "", "sharedcomics");
$user_session = $_SESSION['user'];
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
    <link rel="stylesheet" href="custom.css">
</head>

<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-5">
                <div class="card shadow border-0 text-center">
                    <div class="card-header bg-success text-white p-4">
                        <h4 class="mb-0 fw-bold">Perfil de Usuario</h4>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block text-uppercase fw-semibold" style="font-size: 0.75rem;">Nombre
                            de Usuario</small>
                        <span class="fs-4 fw-normal text-dark"><?php echo ($usuario['username']); ?></span>
                    </div>
                    <div class="mb-4">
                        <small class="text-muted d-block text-uppercase fw-semibold" style="font-size: 0.75rem;">Correo
                            Electrónico</small>
                        <span class="fs-5 text-secondary"><?php echo ($usuario['email']); ?></span>
                    </div>
                    <hr class="my-4">
                    <div class="d-grid gap-2">
                        <a href="editar_perfil.php" class="btn btn-success fw-bold p-2 m-2">
                            Editar mi Perfil
                        </a>
                        <a href="index.php" class="btn btn-outline-success fw-bold p-2 m-2">
                            Volver al Inicio
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>

</html>