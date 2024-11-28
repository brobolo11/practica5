<?php

$host = 'localhost';
$dbname = 'login_system';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT * FROM clientes");
    $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error en la conexión o consulta: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <div class="encabezado">
        <header>LISTA CLIENTES</header>
        <a href="agregar.php" class="botonAgregar">Agregar cliente</a>
    </div>

    <div class="contenido">
        <?php foreach ($clientes as $cliente): ?>
            <div class="carta">
                <img src="<?php echo htmlspecialchars($cliente['url']); ?>" alt="Imagen cliente">
                <p class="nombre"><?php echo htmlspecialchars($cliente['nombre']); ?></p>
                <p class="apellido"><?php echo htmlspecialchars($cliente['apellido']); ?></p>
                <div class="acciones">
                    <a href="modificar.php?id=<?php echo $cliente['id']; ?>" class="botonModificar">Modificar</a>
                    <a href="eliminar.php?id=<?php echo $cliente['id']; ?>" class="botonEliminar">Eliminar</a>
                </div>


            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
