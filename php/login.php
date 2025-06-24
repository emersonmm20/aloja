<?php

include '../config/conexion.php';

session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    $conn = conectarDB(); 
  
    $query = "SELECT * FROM EMPLEADO WHERE USUARIO = ? AND PASSWORD = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $usuario, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['usuario'] = $row['USUARIO'];
        $_SESSION['rol'] = $row['ROL'];
        $_SESSION['nombre_completo'] = $row['NOMBRE_COMPLETO'];
        if ($row['ROL'] == 'ADMIN') {
            header("Location: ../index.php");
            exit();
        } elseif ($row['ROL'] == 'EMPLEADO') {
            header("Location: ../php/panelEmpleado.php");
            exit();
        }
    } else {
        echo '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <title>Document</title>
        </head>
        <body>
            <script >
              Swal.fire({
                icon: "error",
                title: "Acceso denegado",
                text: "Usuario o contraseña incorrectos",
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                window.location.href = "../principal.php";
            });
            </script>
        </body>
        </html>';;
    }
        
    

    $stmt->close();
    $conn->close();
}
?>
