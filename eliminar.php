<?php
$host = 'localhost';
$dbname = 'login_system';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = $_GET['id'];

        $stmt = $pdo->prepare("DELETE FROM clientes WHERE id = :id");
        $stmt->execute(['id' => $id]);

        header('Location: clientes.php');
        exit;
    } else {
        throw new Exception("ID del cliente no válido.");
    }
} catch (PDOException $e) {
    die("Error en la conexión o consulta: " . $e->getMessage());
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>
