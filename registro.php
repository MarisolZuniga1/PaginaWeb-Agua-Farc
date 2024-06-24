<?php
$servername = "localhost";
$username = "root";
$password = "Sasuke11";
$dbname = "usuarios";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$email = $_POST['email'] ;
$pass = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encriptar contraseña

if(empty($email) || empty($pass)){
    die("Email or password is empty");
    } 

// Preparar y enlazar
$stmt = $conn->prepare("INSERT INTO datos (username, password) VALUES (?, ?)");
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("ss", $email, $pass);

if ($stmt->execute()) {
    echo "Registro exitoso";
    header("Location: inicioSesion.html");
    exit; // Asegurar que el script se detenga después de la redirección
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
