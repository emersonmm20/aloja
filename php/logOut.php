<?php
// Destruir todas las variables de sesión
$_SESSION = array();

// Borrar la cookie de sesión
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(), 
        '', 
        time() - 42000,
        $params["path"], 
        $params["domain"], 
        $params["secure"], 
        $params["httponly"]
    );
}

// Destruir la sesión
session_destroy();

// Redireccionar y asegurar que no se ejecute código después
header("Location: ../principal.php");
exit();
?>