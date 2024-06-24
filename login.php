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
$user = $_POST['email'];
$pass = $_POST['password'];

// Consultar la base de datos utilizando consulta preparada
$stmt = $conn->prepare("SELECT * FROM datos WHERE username = ?");
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Verificar la contraseña
    if (password_verify($pass, $row['password'])) {
        echo "Login exitoso. Bienvenido " . $user;
        // Redirigir al usuario a otra página después del inicio de sesión exitoso
        header("Location: index.html");
        exit; // Asegurar que el script se detenga después de la redirección
    } else {
        echo "Contraseña incorrecta.";
    }
} else {
    echo "Usuario no encontrado.";
}

// Cerrar declaración, conexión y resultado
$stmt->close();
$conn->close();

?>
