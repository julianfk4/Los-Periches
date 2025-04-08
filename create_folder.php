<?php
session_start();

// Verificar sesión y rol de admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('HTTP/1.1 403 Forbidden');
    exit('Acceso denegado');
}

// Configuración de directorio
$target_directory = 'uploads/'; // Asegúrate que esta ruta es correcta

// Validar y sanitizar entrada
if (isset($_POST['folder_name'])) {
    $folder_name = trim($_POST['folder_name']);
    
    // Validar nombre de carpeta
    if (empty($folder_name)) {
        header('Location: admin.php?error=Nombre de carpeta vacío');
        exit();
    }
    
    // Expresión regular para validar nombre
    if (!preg_match('/^[a-zA-Z0-9_-]+$/', $folder_name)) {
        header('Location: admin.php?error=Nombre inválido. Use solo letras, números, guiones y guiones bajos');
        exit();
    }
    
    // Ruta completa del nuevo directorio
    $new_folder_path = $target_directory . $folder_name;
    
    // Verificar si ya existe
    if (file_exists($new_folder_path)) {
        header('Location: admin.php?error=La carpeta ya existe');
        exit();
    }
    
    // Intentar crear directorio
    if (mkdir($new_folder_path, 0755, true)) {
        // Registro de actividad (opcional)
        error_log("Carpeta creada: " . $folder_name . " por " . $_SESSION['username']);
        header('Location: admin.php?success=Carpeta creada exitosamente');
        exit();
    } else {
        header('Location: admin.php?error=Error al crear la carpeta. Verifique permisos');
        exit();
    }
} else {
    header('Location: admin.php?error=Datos incompletos');
    exit();
}