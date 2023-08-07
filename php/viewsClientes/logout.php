<?php
// Iniciar o reanudar la sesión
session_start();

// Destruir todas las variables de sesión
session_unset();



// Redirigir al usuario a la página de inicio (index.html)
header("Location: /index.html");
exit();
?>
