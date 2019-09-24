<?php
$success=$_REQUEST['success']; //1 [transaccion exitosa]   0 [transaccion no exitosa]
$orderid=$_REQUEST['orderid']; //ID de la orden que acaba de ser pagada

if($success=="1"){
    ?>
    <h2>Compra realizada con éxito!</h2>
    <br/>
    <strong>Orden #</strong><?php echo $orderid; ?>
    <br/>
    <br/>
    <a href="#">Inicio</a>
    <?php
}
else{
    ?>
    <h2>La compra no se realizó, por favor inténtelo de nuevo. Gracias.</h2>
    <br/>
    <a href="#">Inicio</a>
    <?php
}
?>