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
    <title>Panel de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .main-content {
            flex: 1;
        }
        .file-card:hover {
            transform: translateY(-5px);
            transition: all 0.3s ease;
        }
        .file-icon {
            font-size: 3rem;
            color: #0d6efd;
        }
        .preview-container {
            height: 70vh;
            width: 100%;
        }
        .pdf-preview {
            height: 100%;
            width: 100%;
            border: none;
        }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Panel de Usuario</a>
            <div class="d-flex align-items-center">
                <span class="text-white me-3"><?php echo htmlspecialchars($_SESSION['username'] ?? 'Usuario'); ?></span>
                <a href="logout.php" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-sign-out-alt"></i> Cerrar sesión
                </a>
            </div>
        </div>
    </nav>

    <div class="main-content">
        <div class="container mt-5">
            <div class="row mb-4">
                <div class="col">
                    <h2 class="fw-bold text-primary">
                        <i class="fas fa-music me-2"></i>Partituras Disponibles
                    </h2>
                    <p class="text-muted">Selecciona una partitura para descargar o previsualizar</p>
                </div>
            </div>

            <?php if(count($files) > 0): ?>
            <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
                <?php foreach ($files as $file): ?>
                <div class="col">
                    <div class="card h-100 file-card shadow-sm">
                        <div class="card-body text-center">
                            <i class="far fa-file-pdf file-icon mb-3"></i>
                            <h5 class="card-title text-truncate"><?php echo htmlspecialchars($file); ?></h5>
                            <div class="d-grid gap-2">
                                <button class="btn btn-outline-primary btn-sm preview-btn" 
                                        data-file="<?php echo htmlspecialchars($file); ?>">
                                    <i class="fas fa-eye me-2"></i>Vista Previa
                                </button>
                                <a href="uploads/<?php echo htmlspecialchars($file); ?>" class="btn btn-primary btn-sm" download>
                                    <i class="fas fa-download me-2"></i>Descargar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="alert alert-info" role="alert">
                <i class="fas fa-info-circle me-2"></i>No hay partituras disponibles actualmente.
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal para previsualización -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewModalLabel">Vista Previa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="preview-container">
                        <embed class="pdf-preview" id="pdfPreview" type="application/pdf">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white py-4 mt-auto">
        <div class="container text-center">
            <p class="mb-0">&copy; <?php echo date('Y'); ?> Sistema de Partituras. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Manejar la previsualización de PDF
        document.querySelectorAll('.preview-btn').forEach(button => {
            button.addEventListener('click', function() {
                const fileName = this.getAttribute('data-file');
                const pdfPreview = document.getElementById('pdfPreview');
                pdfPreview.src = `uploads/${encodeURIComponent(fileName)}`;
                
                const modal = new bootstrap.Modal(document.getElementById('previewModal'));
                modal.show();
            });
        });
    </script>
</body>
</html>