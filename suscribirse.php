<?php   
// Conectar a la base de datos
$conexion = new mysqli("localhost", "root", "", "sharedcomics");

// Inicializamos la variable en "esperando" para que no pinte nada al cargar
$acierto = "esperando"; 

if (isset($_POST['user'])) {
    $user = $_POST['user'];
    $password = $_POST['password'];
    $gmail = $_POST['gmail'];

    // ¿Ya existe este usuario o correo?
    $buscar_duplicado = $conexion->query("SELECT * FROM usuarios WHERE username = '$user' OR email = '$gmail'");

    if ($buscar_duplicado->num_rows > 0) {
        // Si encuentra filas, es que ya existe
        $acierto = "duplicado";
    } else {
        // Insertar el nuevo usuario en la tabla
        $insertar = $conexion->query("INSERT INTO usuarios (username, email, password) VALUES ('$user', '$gmail', '$password')");
        
        // CORRECCIÓN: Comprobamos el resultado del INSERT aquí dentro
        if ($insertar !== false) {
            $acierto = "exito";
        } else {
            $acierto = "error";
        }
    }
}
// Eliminamos el bloque que estaba aquí suelto para que no sobreescriba el estado
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-12 col-sm-8 col-md-6 col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h2 class="text-center mb-4 fw-bold text-primary">Registrarse</h2>
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label for="user" class="form-label">Usuario</label>
                                <input type="text" class="form-control" id="user" name="user" placeholder="Tu nombre de usuario" required>
                            </div>
                            <div class="mb-3">
                                <label for="gmail" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="gmail" name="gmail" placeholder="Tu correo electrónico" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Tu contraseña" required>
                            </div>

                             <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirmar Contraseña</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirma tu contraseña" required>
                            </div>
                            
                            <div class="d-grid gap-2 mb-3">
                                <button type="submit" class="btn btn-primary">Registrarse</button>
                            </div>
                            <div class="d-grid gap-2 mb-3">
                                <a href="loguearse.php" class="text-decoration-none">¿Ya tienes cuenta? Inicia sesión</a>
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                                <a href="index.php" class="btn btn-sm btn-dark text-end text-small">Volver al Inicio</a>
                                </div>
                            <?php if ($acierto === "error"): ?>
                                <div class="alert alert-danger mt-3">
                                    Error al registrar el usuario, por favor intenta de nuevo.
                                </div>
                            <?php elseif ($acierto === "exito"): ?>
                                <div class="alert alert-success mt-3">
                                    ¡Usuario registrado exitosamente!
                                </div>
                            <?php elseif ($acierto === "duplicado"): ?>
                                <div class="alert alert-warning mt-3">
                                    El nombre de usuario o correo electrónico ya está en uso.
                                </div>
                            <?php endif; ?>
                             
                        </form>
                    </div>
                </div> </div>
        </div>
    </div>
</body>
</html>