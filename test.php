<?php
header('Content-Type: text/html; charset=utf-8');
include('Crypt/RSA.php');

$request_raw="status=1&opn=99199&orderid=9";
/*
    ENCRIPTACION DE LA TRAMA DE INVOCACION.
*/
$rsa = new Crypt_RSA();
$rsa->loadKey(file_get_contents('keys/local/public.pem'));
$rsa->loadKey($rsa->getPublicKey());
$rsa->setEncryptionMode(CRYPT_RSA_ENCRYPTION_OAEP);//  CRYPT_RSA_ENCRYPTION_PKCS1
//$encrypted_trama= base64_encode($rsa->encrypt($request_raw));
$encrypted_trama= urlencode($rsa->encrypt($request_raw));


$prueba = 'https://tomahawk.ec/web_carrito/public/factura/postproceso.php?xmlreq='.base64_encode($encrypted_trama);
?>

<iframe src="<?php echo $prueba; ?>" style="width:600px;height:300px"></iframe>