<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST['password'];

    if ($password === "contraseña1") {
        $_SESSION['role'] = "admin";
        header("Location: admin.php");
        exit();
    } elseif ($password === "contraseña2") {
        $_SESSION['role'] = "user";
        header("Location: user.php");
        exit();
    } else {
        $error = "Contraseña incorrecta";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Directorio de Partituras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        margin: 0;
        padding: 0;
        background-image: url("./images/adios.png");
    }

    .circle {
        width: 150px;
        height: 150px;
        background-color: #f7f1ce;
        border-radius: 50%;
    }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="card text-center p-4" style="width: 28rem; background-color: #180A0A; border-radius: 15px;">
        <div class="card-body">
            <div class="circle mx-auto mb-3"></div>
            <h3 class="text-light">DIRECTORIO DE<br>PARTITURAS</h3>
            <form action="" method="POST" class="d-flex justify-content-center align-items-center ">
                <div class="card text-center p-4" style="width: 17rem; background-color: #371D1D; border-radius: 15px;">
                    <div class="mb-3 text-start">
                        <label for="usuario" class="form-label text-light">Usuario</label>
                        <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario" required>
                    </div>
                    <div class="mb-3 text-start">
                        <label for="password" class="form-label text-light">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
                    </div>
                    <button type="submit" class="btn btn-light w-100" style="background-color: #f7f1ce;">Iniciar sesión</button>
                </div>
            </form>
        </div>
    </div>
    
</body>
</html>
