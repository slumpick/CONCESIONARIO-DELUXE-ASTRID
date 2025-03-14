<?php
session_start();
require '../src/php/db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SESSION['tipo_usuario'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

if (isset($_POST['id_coche']) && !empty($_POST['id_coche'])) {
    $id_usuario = intval($_POST['id_coche']);

    $query = "SELECT * FROM usuarios WHERE id_usuario = '$id_usuario'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $sql = "DELETE FROM usuarios WHERE id_usuario = '$id_usuario'";
        if (mysqli_query($conn, $sql)) {
            ?>
            <!DOCTYPE html>
            <html lang="es">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Concesionario Deluxe | Eliminación de usuario</title>
                <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
                <link rel="stylesheet" href="../src/css/general.css">
            </head>
            <body>
                <div class="banner">
                    <img src="../src/img/banner.jpg">
                </div>

                <nav class="navbar navbar-expand-lg navbar-light">
                    <div class="container">
                        <a class="navbar-brand fw-bold" href="../index.php">Concesionario Deluxe</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav ms-auto">
                                <li class="nav-item">
                                    <a class="nav-link" href="../coches/index.php">Coches</a>
                                </li>
                                <?php if (!isset($_SESSION['usuario_id'])): ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="../registro.php">Registro</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="../login.php">Iniciar Sesión</a>
                                    </li>
                                <?php else: ?>
                                    <?php if ($_SESSION['tipo_usuario'] == 'comprador'): ?>
                                        <li class="nav-item">
                                            <a class="nav-link" href="../perfil.php">Mi perfil</a>
                                        </li>
                                    <?php elseif ($_SESSION['tipo_usuario'] == 'vendedor'): ?>
                                        <li class="nav-item">
                                            <a class="nav-link" href="../alquileres/index.php">Alquileres</a>
                                        </li>
                                    <?php elseif ($_SESSION['tipo_usuario'] == 'admin'): ?>
                                        <li class="nav-item">
                                            <a class="nav-link" href="index.php">Usuarios</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="../alquileres/index.php">Alquileres</a>
                                        </li>
                                    <?php endif; ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="../src/php/cerrar_sesion.php">Cerrar Sesión</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </nav>

                <div class="container my-5" id="center">
                    <h3>¡El usuario ha sido eliminado!</h3>
                    <a href="index.php">Volver al menú de la categoría</a>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
            </body>
            </html>
            <?php
        } else {
            echo "Error al eliminar el usuario: " . mysqli_error($conn);
        }
    } else {
        echo "<h3>No se encontró el usuario con el ID proporcionado.</h3>";
    }
} else {
    echo "<h3>No se seleccionó ningún usuario para eliminar.</h3>";
}

mysqli_close($conn);
?>
