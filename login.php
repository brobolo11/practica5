<?php
$host = 'localhost';
$dbname = 'login_system';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    $pdo->exec("USE $dbname");

    $sqlUsers = "CREATE TABLE IF NOT EXISTS users (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL,
        password VARCHAR(255) NOT NULL
    )";
    $pdo->exec($sqlUsers);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => 'admin']);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $defaultPassword = password_hash('1234', PASSWORD_DEFAULT);
        $insertStmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $insertStmt->execute(['username' => 'admin', 'password' => $defaultPassword]);
    }

    $sqlClientes = "CREATE TABLE IF NOT EXISTS clientes (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(50) NOT NULL,
        apellido VARCHAR(50) NOT NULL,
        url VARCHAR(255) NOT NULL
    )";
    $pdo->exec($sqlClientes);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $inputUsername = $_POST['usuario'];
        $inputPassword = $_POST['contra'];

        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $inputUsername]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($inputPassword, $user['password'])) {
            header("Location: clientes.php");
            exit;
        } else {
            echo "Nombre de usuario o contraseña incorrectos.";
        }
    }
} catch (PDOException $e) {
    die("Error en la conexión o consulta: " . $e->getMessage());
}
?>