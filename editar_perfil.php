<?php
session_start();

$conexion = new mysqli("localhost", "root", "", "sharedcomics");
$usuario_actual = $_SESSION['user'];
$acierto = "esperando";

// OBTENER LOS DATOS ACTUALES DEL USUARIO
$consulta = $conexion->query("SELECT username, email FROM usuarios WHERE username = '$usuario_actual'");
$datos_usuario = $consulta->fetch_assoc();

// ACTUALIZACIÓN ENVIADA POR EL FORMULARIO
if (isset($_POST['user'])) {
    // Si el campo viene vacío, conservamos el valor actual de la base de datos
    $user = !empty(trim($_POST['user'])) ? trim($_POST['user']) : $datos_usuario['username'];
    $gmail = !empty(trim($_POST['gmail'])) ? trim($_POST['gmail']) : $datos_usuario['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validar duplicados
    $buscar_duplicado = $conexion->query("SELECT * FROM usuarios WHERE (username = '$user' OR email = '$gmail') AND username != '$usuario_actual'");

    if ($buscar_duplicado->num_rows > 0) {
        $acierto = "duplicado";
    } else {
        // Comprobar si se desea actualizar la contraseña
        if (!empty($password)) {
            if ($password === $confirm_password) {
                $actualizar = $conexion->query("UPDATE usuarios SET username = '$user', email = '$gmail', password = '$password' WHERE username = '$usuario_actual'");
            } else {
                $acierto = "password_mismatch";
                $actualizar = false;
            }
        } else {
            // Actualizar datos sin tocar la contraseña
            $actualizar = $conexion->query("UPDATE usuarios SET username = '$user', email = '$gmail' WHERE username = '$usuario_actual'");
        }


        if ($acierto !== "password_mismatch") {
            if ($actualizar !== false) {
                $acierto = "exito";
                
                // Actualizar la variable de sesión si el usuario cambió su propio nombre
                $_SESSION['user'] = $user;
                $usuario_actual = $user; 
                
                // Refrescar los datos en pantalla con los nuevos valores
                $datos_usuario['username'] = $user;
                $datos_usuario['email'] = $gmail;
            } else {
                $acierto = "error";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-12 col-sm-8 col-md-6 col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h2 class="text-center mb-4 fw-bold text-primary">Editar Perfil</h2>
                        
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label for="user" class="form-label">Usuario</label>
                                <input type="text" class="form-control" id="user" name="user" value="<?php echo htmlspecialchars($datos_usuario['username'] ?? ''); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="gmail" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="gmail" name="gmail" value="<?php echo htmlspecialchars($datos_usuario['email'] ?? ''); ?>">
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Nueva Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>

                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirmar Nueva Contraseña</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                            </div>
                            
                            <div class="d-grid gap-2 mb-3">
                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                            </div>
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                                <a href="index.php" class="btn btn-sm btn-dark text-end text-small">Volver al Inicio</a>
                            </div>

                            <?php if ($acierto === "error"): ?>
                                <div class="alert alert-danger mt-3">
                                    Error al actualizar los datos, por favor intenta de nuevo.
                                </div>
                            <?php elseif ($acierto === "exito"): ?>
                                <div class="alert alert-success mt-3">
                                    ¡Perfil actualizado exitosamente!
                                </div>
                            <?php elseif ($acierto === "duplicado"): ?>
                                <div class="alert alert-warning mt-3">
                                    El nombre de usuario o correo electrónico ya están siendo utilizados por otra cuenta.
                                </div>
                            <?php elseif ($acierto === "password_mismatch"): ?>
                                <div class="alert alert-danger mt-3">
                                    Las contraseñas ingresadas no coinciden.
                                </div>
                            <?php endif; ?>
                             
                        </form>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</body>
</html>