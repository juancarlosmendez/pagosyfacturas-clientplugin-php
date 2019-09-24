<?php
header('Content-Type: text/html; charset=utf-8');
include('Crypt/RSA.php');


if($_REQUEST['xmlreq']!=null){
    
    /*
        OBTENGO EL PARAMETRO A DECODIFICAR
    */
    $xmlreq = $_REQUEST['xmlreq'];


    /*
        DESENCRIPTACION DE LA TRAMA DE INVOCACION.
    */
    $rsa = new Crypt_RSA();
    $rsa->loadKey(file_get_contents('keys/local/private.pem'));
    $rsa->loadKey($rsa->getPrivateKey());
    $rsa->setEncryptionMode(CRYPT_RSA_ENCRYPTION_OAEP);//  CRYPT_RSA_ENCRYPTION_PKCS1
    $decrypted = $rsa->decrypt($xmlreq);
  


    /*
        DESENCRIPTADO
        status=1&opn=1234&orderid=1200
        Guardar en la base de datos el estado de la orden 1200 y poner como referencia el número de operación 1234 en pyf
    */
    $status= explode( "=" , explode("&", $decrypted)[0])[1];    //1 [transaccion exitosa]   0 [transaccion no exitosa]
    $opn= explode( "=" , explode("&", $decrypted)[1])[1];       //Número de transacción en PAGOSYFACTURAS
    $orderid= explode( "=" , explode("&", $decrypted)[2])[1];   //ID de la orden que acaba de ser pagada
     /*
            AQUI GUARDAS EN TU BASE DE DATOS QUE YA SE HA PAGADO
     */


    //echo $decrypted;  //HACER ALGO CON ESTAS VARIABLES DESENCRIPTADAS status=1&opn=1234&orderid=1200  ***NO IMPRIMIR
    echo "OK";  //SOLAMENTE IMPRIMIR OK
}
else{
    echo "ERROR";
}

?>