<?php
session_start();
if ($_SESSION['role'] !== "admin") {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['file'])) {
    $uploadDir = "uploads/";
    $filePath = $uploadDir . basename($_FILES["file"]["name"]);

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $filePath)) {
        $success = "Archivo subido correctamente.";
    } else {
        $error = "Error al subir el archivo.";
    }
}
$files = array_diff(scandir("uploads"), array('.', '..'));
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
</head>
<body>
    <h1>Bienvenido, Administrador</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="file">Subir partitura:</label>
        <input type="file" name="file" id="file" required>
        <button type="submit">Subir</button>
    </form>
    <?php if (isset($success)) echo "<p style='color:green;'>$success</p>"; ?>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

    <h2>Partituras disponibles:</h2>
    <ul>
        <?php foreach ($files as $file): ?>
            <li><a href="uploads/<?php echo $file; ?>" download><?php echo $file; ?></a></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
