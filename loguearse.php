<?php
$conexion = new mysqli("localhost", "root", "", "sharedcomics");
if (isset($_POST['user'])) {
    $user = $_POST['user'];
    $password = $_POST['password'];
    $consulta = $conexion->query("SELECT * FROM usuarios WHERE username = '$user'");
    if ($consulta->num_rows > 0) {
        if ($fila = $consulta->fetch_assoc()) {
            if (password_verify($password, $fila['password'])) {
                session_start();
                $_SESSION['user'] = $user;
                header("Location: index.php");
            } else {
                echo "<div class='alert alert-danger mt-3' role='alert'>Usuario o contraseña incorrectos.</div>";
            }
        }
    } else {
        echo "<div class='alert alert-danger mt-3' role='alert'>Usuario o contraseña incorrectos.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-12 col-sm-8 col-md-6 col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h2 class="text-center mb-4 fw-bold text-success">Iniciar Sesión</h2>
                        <form action="loguearse.php" method="POST">
                            <div class="mb-3">
                                <label for="user" class="form-label">Usuario</label>
                                <input type="text" class="form-control" id="user" name="user"
                                    placeholder="Tu nombre de usuario" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Tu contraseña" required>
                            </div>
                            <div class="d-grid gap-2 mb-3">
                                <button type="submit" class="btn btn-success fw-bold p-2">Entrar</button>
                            </div>
                            <div class="text-center">
                                <span class="text-muted">¿No tienes cuenta?</span>
                                <a href="/dashboard/suscribirse.php"
                                    class="text-decoration-none text-success fw-bold">Regístrate</a>
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                                    <a href="index.php" class="btn btn-sm btn-outline-success fw-bold p-2">Volver al
                                        Inicio</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>