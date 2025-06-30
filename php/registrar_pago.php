<?php
function registrarPago($conn,$monto,$date,$id_huesped,$id_estadia){

    // $sql="INSERT INTO `pagos` (`idPAGOS`,`MONTO`, `FECHA_PAGO`, `HUESPED_idHUESPED`, `ESTADIA_idESTADIA`) VALUES (NULL,'$date', '$monto',  '$id_huesped', '$id_estadia');";
    $sql="INSERT INTO `pagos` (`idPAGOS`, `FECHA_PAGO`, `MONTO`, `HUESPED_idHUESPED`, `ESTADIA_idESTADIA`) VALUES (NULL, '2025-06-30', '150000', '1', '1')";
    mysqli_query($conn,$sql);
}

?>



