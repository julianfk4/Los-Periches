<?php
session_start();
if ($_SESSION['role'] !== "admin") {
    header("Location: index.php");
    exit();
}

$current_directory = 'uploads/';
$folders = array_diff(scandir($current_directory), array('.', '..'));
?>
<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
<?php endif; ?>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
<?php endif; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 280px;
            --primary-color: #2c3e50;
            --accent-color: #3498db;
        }

        body {
            background-color: #f8f9fa;
            min-height: 100vh;
        }

        .sidebar {
            width: var(--sidebar-width);
            background: var(--primary-color);
            min-height: 100vh;
            transition: all 0.3s;
            box-shadow: 4px 0 10px rgba(0,0,0,0.1);
        }

        .main-content {
            margin-left: var(--sidebar-width);
            padding: 20px;
            width: calc(100% - var(--sidebar-width));
        }

        .folder-card {
            transition: all 0.2s;
            cursor: pointer;
            border: 2px solid transparent;
        }

        .folder-card:hover {
            transform: translateY(-5px);
            border-color: var(--accent-color);
        }

        .upload-dropzone {
            border: 2px dashed #ced4da;
            border-radius: 10px;
            background: rgba(255,255,255,0.8);
            transition: all 0.3s;
        }

        .upload-dropzone.dragover {
            border-color: var(--accent-color);
            background: rgba(52, 152, 219, 0.1);
        }

        .file-item {
            background: white;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .file-item:hover {
            background: #f8f9fa;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        .context-menu {
            position: absolute;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-radius: 6px;
            display: none;
            z-index: 1000;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar position-fixed">
        <div class="p-4">
            <h3 class="text-white mb-4">Admin Dashboard</h3>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a class="nav-link text-white" href="#">
                        <i class="fas fa-home me-2"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#uploadModal">
                        <i class="fas fa-upload me-2"></i>Subir archivo
                    </button>
                </li>
                <li class="nav-item mb-2">
                    <button class="btn btn-outline-light w-100" data-bs-toggle="modal" data-bs-target="#createFolderModal">
                        <i class="fas fa-folder-plus me-2"></i>Nueva carpeta
                    </button>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white" href="#">
                        <i class="fas fa-cog me-2"></i>Ajustes
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white p-3 rounded shadow-sm">
                <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">Directorio actual</li>
            </ol>
        </nav>

        <!-- Content Grid -->
        <div class="row g-4">
            <?php foreach ($folders as $folder): ?>
                <?php if(is_dir($current_directory.$folder)): ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="folder-card p-3 bg-white rounded shadow-sm position-relative">
                            <div class="d-flex flex-column align-items-center">
                                <i class="fas fa-folder text-warning mb-2" style="font-size: 3rem"></i>
                                <span class="text-dark fw-bold text-center"><?= htmlspecialchars($folder) ?></span>
                                <div class="dropdown mt-2">
                                    <button class="btn btn-sm btn-light" type="button" 
                                            data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i>Renombrar</a></li>
                                        <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i>Eliminar</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </main>

    <!-- Modals -->
    <!-- Upload Modal -->
    <div class="modal fade" id="uploadModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Subir archivos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="upload-dropzone p-5 text-center" id="dropzone">
                        <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Arrastra archivos aquí o haz clic para seleccionar</p>
                        <form id="uploadForm" action="upload.php" method="POST" enctype="multipart/form-data">
                            <input type="file" name="files[]" multiple class="d-none" id="fileInput">
                            <button type="button" class="btn btn-primary" onclick="document.getElementById('fileInput').click()">
                                Seleccionar archivos
                            </button>
                        </form>
                    </div>
                    <div class="progress mt-3" style="height: 8px; display: none;">
                        <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Folder Modal -->
    <div class="modal fade" id="createFolderModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crear nueva carpeta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="create_folder.php" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nombre de la carpeta</label>
                            <input type="text" name="folder_name" class="form-control" required 
                                   pattern="[a-zA-Z0-9_\-]+" title="Solo letras, números, guiones y guiones bajos">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Crear</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Drag and drop functionality
        const dropzone = document.getElementById('dropzone');
        const fileInput = document.getElementById('fileInput');

        dropzone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropzone.classList.add('dragover');
        });

        dropzone.addEventListener('dragleave', () => {
            dropzone.classList.remove('dragover');
        });

        dropzone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropzone.classList.remove('dragover');
            fileInput.files = e.dataTransfer.files;
        });
        
        // En este tramo subiremos archivos para que se sumen as
        document.getElementById('uploadForm').addEventListener('submit', (e) => {
            e.preventDefault();
            const progressBar = document.querySelector('.progress-bar');
            const progressContainer = document.querySelector('.progress');
            
            progressContainer.style.display = 'block';
            let width = 0;
            const interval = setInterval(() => {
                if(width >= 100) {
                    clearInterval(interval);
                    // Submit form
                    e.target.submit();
                } else {
                    width++;
                    progressBar.style.width = width + '%';
                }
            }, 50);
        });
    </script>
</body>
</html>