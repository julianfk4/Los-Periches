<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Directorio de Partituras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar {
            background-color: #3a3a3a;
            height: 100vh;
        }
        .circle {
            width: 50px;
            height: 50px;
            background-color: #f7f1ce;
            border-radius: 50%;
            margin: 20px auto;
        }
        .folder {
            width: 100px;
            height: 100px;
            background-color: #e0e0e0;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 10px auto;
            cursor: pointer;
        }
        .folder:hover {
            background-color: #d6d6d6;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-1 sidebar d-flex flex-column align-items-center">
                
            </div>
            
            <!-- Main content -->
            <div class="col-10 content bg-secondary">
                <h1 class="text-center py-4">Contenido Principal</h1>
                <!-- Crear carpeta -->
                <div class="col-4 col-md-3 col-lg-2 text-center">
                            <div class="folder">
                                <span class="text-dark fw-bold">+</span>
                            </div>
                            <p class="text-light">Crear carpeta</p>
                </div>
                <!-- Carpetas -->
                <div class="col-4 col-md-3 col-lg-2 text-center">
                    <div class="folder">
                        <img src="./images/foldericon.png" alt="Carpeta" style="width: 50px;">
                    </div>
                    <p class="text-light">Carpeta</p>
                </div>
                <div class="col-4 col-md-3 col-lg-2 text-center">
                    <div class="folder">
                        <img src="./images/foldericon.png" alt="Carpeta" style="width: 50px;">
                    </div>
                    <p class="text-light">Carpeta</p>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-1 sidebar d-flex flex-column align-items-center">
                
            </div>


        </div>
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>