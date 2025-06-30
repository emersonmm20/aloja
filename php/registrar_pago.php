<?php
function registrarPago($conn,$monto,$date,$id_huesped,$id_estadia){

    $sql="INSERT INTO `pagos` (`idPAGOS`,`MONTO`, `FECHA_PAGO`, `HUESPED_idHUESPED`, `ESTADIA_idESTADIA`) VALUES (NULL,$monto, '$date', '$id_huesped', '$id_estadia');";
    mysqli_query($conn,$sql);
}

?>