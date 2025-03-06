<?php
session_start();
include('../src/php/db.php');

if (!isset($_SESSION['usuario_id'])) {
    echo '<p>Debe iniciar sesión para continuar.</p>';
    exit();
}

$id_usuario = $_SESSION['usuario_id'];

if (!isset($_POST['id_coche']) || empty($_POST['id_coche'])) {
    echo '<p>Error: No se ha proporcionado el ID del coche.</p>';
    exit();
}

$id_coche = $_POST['id_coche'];

$query_saldo = "SELECT saldo FROM usuarios WHERE id_usuario = $id_usuario";
$result_saldo = mysqli_query($conn, $query_saldo);
$row_saldo = mysqli_fetch_assoc($result_saldo);
$saldo = $row_saldo['saldo'];

$query_precio = "SELECT precio FROM coches WHERE id_coche = $id_coche";
$result_precio = mysqli_query($conn, $query_precio);
$row_precio = mysqli_fetch_assoc($result_precio);
$precio = $row_precio['precio'];

if ($saldo < $precio) {
    echo '<p class="error-msg">No tiene suficiente saldo para realizar esta compra.</p>';
    echo '<a href="index.php" class="btn btn-danger btn-custom">Volver al concesionario</a>';
    exit();
}

$new_balance = $saldo - $precio;

if (isset($_POST['confirmar_pago'])) {
    $query_update_saldo = "UPDATE usuarios SET saldo = $new_balance WHERE id_usuario = $id_usuario";
    mysqli_query($conn, $query_update_saldo);

    $query_insert_alquiler = "INSERT INTO alquileres (id_usuario, id_coche, prestado) VALUES ($id_usuario, $id_coche, NOW())";
    mysqli_query($conn, $query_insert_alquiler);

    $query_update_coche = "UPDATE coches SET alquilado = 1 WHERE id_coche = $id_coche";
    mysqli_query($conn, $query_update_coche);

    $payment_confirmed = true;
} else {
    $payment_confirmed = false;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pasarela de Pago</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        .payment-box {
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
        .payment-icon {
            font-size: 50px;
            color: #E6AF2E;
            margin-bottom: 10px;
        }
        .payment-confirmation-text {
            font-size: 1.5rem;
            font-weight: bold;
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
            <a class="navbar-brand" href="index.php">Concesionario Deluxe</a>
        </div>
    </nav>

    <div class="container container-center">
        <?php if ($payment_confirmed): ?>
            <div class="payment-box">
                <div class="payment-icon">✔️</div>
                <div class="payment-confirmation-text">Pago realizado con éxito. ¡Gracias!</div>
                <a href="index.php" class="btn btn-custom">Volver al concesionario</a>
                <p>Si no haces clic en "Volver al concesionario", serás redirigido automáticamente en 5 segundos.</p>
            </div>
        <?php else: ?>
            <div class="payment-box">
                <h3>Pasarela de Pago</h3>
                <p><strong>Saldo actual:</strong> <?php echo number_format($saldo, 2); ?> €</p>
                <p><strong>Precio del coche:</strong> <?php echo number_format($precio, 2); ?> €</p>
                <p><strong>Saldo restante:</strong> <?php echo number_format($new_balance, 2); ?> €</p>
                <form action="pago.php" method="POST">
                    <input type="hidden" name="id_coche" value="<?php echo $id_coche; ?>">
                    <button type="submit" name="confirmar_pago" class="btn btn-custom">Confirmar compra</button>
                </form>
                <a href="index.php" class="btn btn-danger btn-custom mt-2">Cancelar pago</a>
            </div>
        <?php endif; ?>
    </div>

    <script>
        setTimeout(function() {
            window.location.href = "index.php";
        }, 5000);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
