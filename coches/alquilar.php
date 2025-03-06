<?php
session_start();
require '../src/php/db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit();
}

$id_coche = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id_coche <= 0) {
    die("Coche no válido.");
}

$sql = "SELECT * FROM coches WHERE id_coche = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_coche);
$stmt->execute();
$resultado = $stmt->get_result()->fetch_assoc();

if (!$resultado) {
    die("Coche no encontrado.");
}

$id_usuario = $_SESSION['usuario_id'];
$sql_usuario = "SELECT saldo FROM usuarios WHERE id_usuario = ?";
$stmt_usuario = $conn->prepare($sql_usuario);
$stmt_usuario->bind_param("i", $id_usuario);
$stmt_usuario->execute();
$resultado_usuario = $stmt_usuario->get_result()->fetch_assoc();

$saldo = $resultado_usuario['saldo'];
$precio = $resultado['precio'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alquilar <?php echo htmlspecialchars($resultado['marca']) . " " . htmlspecialchars($resultado['modelo']); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        .navbar-brand {
            color: #E6AF2E !important;
            font-size: 1.7rem;
            font-weight: bold;
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
        .card {
            background: rgba(0, 0, 0, 0.8);
            color: white;
            border: 1px solid #E6AF2E;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);
            max-width: 600px;
            margin: auto;
        }
        .card img {
            border-radius: 10px;
            height: 250px;
            object-fit: cover;
            width: 100%;
        }
        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
        }
        .btn-custom {
            width: 100%;
            border-radius: 30px;
            padding: 12px;
            font-size: 1.2rem;
            color: black;
            background: #E6AF2E;
            border: none;
            transition: 0.3s;
            margin-top: 10px;
        }
        .btn-custom:hover {
            background: #c98f1f;
            color: white;
        }
        .error-msg {
            color: #E74C3C;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="../index.php">Concesionario Deluxe</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Coches</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../alquileres/index.php">Alquilar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../perfil.php">Mi perfil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="../src/php/cerrar_sesion.php">Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container container-center">
        <div class="card">
            <h3 class="card-title">Alquilar: <?php echo htmlspecialchars($resultado['marca']) . " " . htmlspecialchars($resultado['modelo']); ?></h3>
            <img src="../<?php echo htmlspecialchars($resultado['foto']); ?>" alt="Imagen del coche">
            <h4 class="mt-3">Precio: <span style="color:#E6AF2E;"><?php echo number_format($precio, 2); ?> €</span></h4>
            <p><strong>Color:</strong> <?php echo htmlspecialchars($resultado['color']); ?></p>
            
            <?php if ($saldo >= $precio): ?>
                <form action="pago.php" method="POST">
                    <input type="hidden" name="id_coche" value="<?php echo $id_coche; ?>">
                    <button type="submit" class="btn btn-custom">Realizar el pago</button>
                </form>
            <?php else: ?>
                <p class="error-msg">No tienes saldo suficiente.</p>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$stmt->close();
$stmt_usuario->close();
mysqli_close($conn);
?>
