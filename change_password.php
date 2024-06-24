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
$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];

// Verificar que las columnas existen en la base de datos
$result = $conn->query("SHOW COLUMNS FROM datos LIKE 'username'");
if ($result->num_rows == 0) {
    die("La columna 'email' no existe en la tabla 'datos'.");
}

$result = $conn->query("SHOW COLUMNS FROM datos LIKE 'password'");
if ($result->num_rows == 0) {
    die("La columna 'password' no existe en la tabla 'datos'.");
}

// Preparar y ejecutar la consulta SQL para actualizar la contraseña
$sql = "UPDATE datos SET password = ? WHERE username = ? AND password = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error al preparar la consulta SQL: " . $conn->error);
}

$stmt->bind_param("sss", $new_password, $email, $current_password);
$stmt->execute();

// Verificar si se actualizó alguna fila
if ($stmt->affected_rows > 0) {
    echo "Contraseña cambiada exitosamente.";
} else {
    echo "No se encontró ninguna cuenta con ese correo y contraseña actual.";
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
