<?php
$host = 'localhost';
$dbname = 'login_system';
$username = 'root';
$password = '';

try {
    // Conectar a la base de datos
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Comprobar si se recibió el formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $url = $_POST['url'];

        if (empty($nombre) || empty($apellido) || empty($url)) {
            throw new Exception("Todos los campos son requeridos.");
        }

        // Insertar los datos del nuevo cliente
        $stmt = $pdo->prepare("INSERT INTO clientes (nombre, apellido, url) VALUES (:nombre, :apellido, :url)");
        $stmt->execute([
            'nombre' => $nombre,
            'apellido' => $apellido,
            'url' => $url
        ]);

        // Redirigir después de la inserción
        header('Location: clientes.php');
        exit;
    }
} catch (PDOException $e) {
    die("Error en la conexión o consulta: " . $e->getMessage());
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Cliente</title>
    <style>
        body {
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            margin: 5% auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #4CAF50;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 16px;
            color: #333;
            margin-bottom: 8px;
        }

        .form-group input[type="text"] {
            width: 97.5%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-group button {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-group button:hover {
            background-color: #45a049;
        }

        .form-group button:active {
            background-color: #397d3b;
        }

        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <h1>Agregar Cliente</h1>
        </div>

        <form action="agregar.php" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>

            <div class="form-group">
                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="apellido" required>
            </div>

            <div class="form-group">
                <label for="url">URL de la Imagen:</label>
                <input type="text" id="url" name="url" required>
            </div>

            <div class="form-group">
                <button type="submit" class="btn">Agregar Cliente</button>
            </div>
        </form>
    </div>

</body>
</html>
