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

$sql = "SELECT * FROM usuarios";
$result = mysqli_query($conn, $sql);
$usuarios = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $usuarios[] = $row;
    }
}

$selectedUser = null;
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $sql = "SELECT * FROM usuarios WHERE id_usuario = '$id'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 1) {
        $selectedUser = mysqli_fetch_assoc($result);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar usuario</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../src/css/general.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: url('../src/img/fondo.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
        }

        .navbar {
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(8px);
            padding: 10px 0;
        }

        .nav-link {
            color: #ddd !important;
            font-size: 1rem;
            transition: 0.3s;
        }

        .nav-link:hover {
            color: #E6AF2E !important;
        }

        .container-center {
            margin-top: 150px;
            text-align: center;
        }

        .profile-box {
            background: rgba(0, 0, 0, 0.8);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 500px;
            margin: auto;
        }

        .btn-custom {
            width: 100%;
            background: #E6AF2E;
            border: none;
            padding: 12px;
            font-size: 1.2rem;
            color: black;
            border-radius: 30px;
            transition: 0.3s;
            margin-top: 10px;
        }

        .btn-custom:hover {
            background: #c98f1f;
            color: white;
        }

        .card {
            background: rgba(0, 0, 0, 0.8);
            color: white;
            border: 1px solid #E6AF2E;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);
        }

        .card img {
            border-radius: 10px;
            height: 200px;
            object-fit: cover;
            width: 100%;
        }

        .error-msg {
            color: #E74C3C;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Inicio</a>
                    </li>
                    <?php if (!isset($_SESSION['usuario_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../registro.php">Registro</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../login.php">Iniciar Sesión</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../src/php/cerrar_sesion.php">Cerrar Sesión</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5" id="center">
        <h3>Seleccione un usuario:</h3>
        <form action="" method="POST">
            <select name="id" class="form-select mb-3">
                <option value="">Seleccione un usuario</option>
                <?php foreach ($usuarios as $usuario): ?>
                    <option value="<?php echo $usuario['id_usuario']; ?>" <?php echo isset($selectedUser) && $selectedUser['id_usuario'] == $usuario['id_usuario'] ? 'selected' : ''; ?>>
                        <?php echo $usuario['id_usuario'] . ' | ' . $usuario['nombre'] . ', ' . $usuario['apellidos']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-primary">Seleccionar</button>
        </form>

        <?php if ($selectedUser): ?>
            <h3>Modificar usuario:</h3>
            <form action="modificado.php" method="POST" enctype="multipart/form-data">
                <label>ID del usuario:</label>
                <input type="text" name="id" readonly value="<?php echo $selectedUser['id_usuario']; ?>" class="form-control mb-2">
                <label>DNI:</label>
                <input type="text" name="dni" value="<?php echo $selectedUser['dni']; ?>" class="form-control mb-2">
                <label>Nombre:</label>
                <input type="text" name="nombre" value="<?php echo $selectedUser['nombre']; ?>" class="form-control mb-2">
                <label>Apellidos:</label>
                <input type="text" name="apellidos" value="<?php echo $selectedUser['apellidos']; ?>" class="form-control mb-2">
                <label>Contraseña:</label>
                <input type="text" name="contrasenia" placeholder="Si desea modificar la contraseña, introduzca un nuevo valor" class="form-control mb-2">
                <label>Saldo:</label>
                <input type="text" name="saldo" value="<?php echo $selectedUser['saldo']; ?>" class="form-control mb-2">
                <button type="submit" class="btn btn-success">Confirmar cambios</button>
            </form>
        <?php endif; ?>

        <?php if (isset($_POST['id']) && !$selectedUser): ?>
            <p class="text-danger">No se encontró el usuario con el ID proporcionado.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php mysqli_close($conn); ?>
