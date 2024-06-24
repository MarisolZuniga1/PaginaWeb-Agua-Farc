<?php
$servername = "localhost";
$username = "root";
$password = "Sasuke11"; // Coloca aquí tu contraseña de MySQL si tienes una
$dbname = "usuarios";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$email = $_POST['email'];
$password = $_POST['password'];

// Preparar y ejecutar la consulta SQL para borrar el usuario
$sql = "DELETE FROM datos WHERE username = ? AND password = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error al preparar la consulta SQL: " . $conn->error);
}

$stmt->bind_param("ss", $email, $password);
$stmt->execute();

// Verificar si se borró alguna fila
if ($stmt->affected_rows > 0) {
    echo "Cuenta borrada exitosamente.";
} else {
    echo "No se encontró ninguna cuenta con ese correo y contraseña.";
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
