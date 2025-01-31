<?php
session_start();
if ($_SESSION['role'] !== "user") {
    header("Location: index.php");
    exit();
}

$files = array_diff(scandir("uploads"), array('.', '..'));
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuario</title>
</head>
<body>
    <h1>Bienvenido, Usuario</h1>
    <h2>Partituras disponibles:</h2>
    <ul>
        <?php foreach ($files as $file): ?>
            <li><a href="uploads/<?php echo $file; ?>" download><?php echo $file; ?></a></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
