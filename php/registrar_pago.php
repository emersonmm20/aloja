<?php
function registrarPago($conn,$monto,$date,$id_huesped,$id_estadia){

    $sql="INSERT INTO `pagos` (`idPAGOS`,`MONTO`, `FECHA_PAGO`, `HUESPED_idHUESPED`, `ESTADIA_idESTADIA`, `EMPLEADO_idEMPLEADO`) VALUES (NULL,$monto, '$date', '$id_huesped', '$id_estadia', '1');";
    mysqli_query($conn,$sql);
    echo"<script>alert('Pago registrado')</script>";

}

?>