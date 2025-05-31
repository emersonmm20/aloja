<?php

function registrarEstadia($conn,$fecha_inicio,$fecha_fin,$monto,$habitacion){

    $date= date('Y-m-d h:m');


    
    $sql = "INSERT INTO `estadia` (`idESTADIA`, `FECHA_INICIO`, `FECHA_FIN`, `FECHA_REGISTRO`, `COSTO`, `HABITACIONES_idHABITACIONES`) VALUES (NULL, '$fecha_inicio', '$fecha_fin', '$date', '$monto', '$habitacion');";
    mysqli_query($conn,$sql);

    $sql = "SELECT * FROM estadia ORDER BY idESTADIA DESC LIMIT 1;";
    $resultado= mysqli_query($conn,$sql);
    
    while ($fila=mysqli_fetch_assoc($resultado)){
        

        return $fila["idESTADIA"];
        $conn->close(); 
    };

}


?>