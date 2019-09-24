<?php
header('Content-Type: text/html; charset=utf-8');
include('Crypt/RSA.php');
function limpia_caracteres($tmp){
    $res = str_replace("'", " ", $tmp);
    $res = str_replace("&", " ", $res);
    $res = str_replace("|", " ", $res);
    $res = str_replace("^", " ", $res);
    return substr($res,0,77);
}


/*
    DEFINICION DE PARAMETROS.
*/
$_service_id=19;  //id de TOMAHAWK en PAGOSYFACTURAS
$endpoint_invocation = "https://www.accroachcode.com/pagosyfacturas/secureproxy.aspx?scid=".$_service_id."&xmlreqpf=";
$_orderID=1;
$_subtotal=100.00;
$_total=112.00;
$_details="520^".limpia_caracteres("ALITAS DE POLLO")."^100.00^1^100.00";
// [ID_PRODUCTO1]^[NOMBRE1]^[PRECIO1]^[CANTIDAD1]^[SUBTOTAL1]|[ID_PRODUCTO1]^[NOMBRE2]^[PRECIO2]^[CANTIDAD2]^[SUBTOTAL2]|...
$_has_iva=1;
$_iva=12;
$_iva_caption="IVA (12%)";
$_cliente="EDUARDO FAUSTOS"."^"."0998989887"."^"."05"."^"."edyfan@hotmail.com";
//[NOMBRES Y APELLIDOS]^[IDENTIFICACION]^[TIPO DE IDENFICACION***]^[CORREO CLIENTE]
//*** 04 RUC, 05 CEDULA, 06 PASAPORTE O IDENTIFICACIONEXTERIOR, 07 CONSUMIDOR FINAL
$_has_ice=0;
$_ice=0;
$_ice_caption=0;
$_has_discount=0;
$_discount=0;
$_discount_caption=0;
$_has_tax1=0;
$_tax1_caption=0;
$_tax1=0;
$_has_tax2=0;
$_tax2_caption=0;
$_tax2=0;
$_has_shipping=0;
$_shipping_caption=0;
$_shipping=0;
$_comision_pagos_y_facturas=5;
$trama="service_id=" . $_service_id . "&order_id=" . $_orderID . "&subtotal=" . $_subtotal . "&total=" . $_total . "&details=" . $_details . "&has_iva=".$_has_iva."&iva=".$_iva."&caption_iva=".$_iva_caption ."&cliente=".$_cliente. "&has_ice=" . $_has_ice . "&ice=" . $_ice . "&caption_ice=" . $_ice_caption . "&has_discount=" . $_has_discount . "&caption_discount=" . $_discount_caption . "&discount=" . $_discount . "&has_tax1=".$_has_tax1."&caption_tax1=".$_tax1_caption."&tax1=" . $_tax1 . "&has_tax2=".$_has_tax2."&caption_tax2=".$_tax2_caption."&tax2=". $_tax2 . "&has_shipping=" . $_has_shipping . "&caption_shipping=" . $_shipping_caption . "&shipping=" . $_shipping . "&comisionpyf=" . $_comision_pagos_y_facturas;


/*
    ENCRIPTACION DE LA TRAMA DE INVOCACION.
*/
$rsa = new Crypt_RSA();
$rsa->loadKey(file_get_contents('keys/pyf/public.pem'));
$rsa->loadKey($rsa->getPublicKey());
$rsa->setEncryptionMode(CRYPT_RSA_ENCRYPTION_OAEP);//  CRYPT_RSA_ENCRYPTION_PKCS1
$encrypted_trama= base64_encode($rsa->encrypt($trama));
$linkvpos = $endpoint_invocation.urlencode($encrypted_trama);  // Detalle:data hash wrong


/*
    MOSTRAMOS EL VPOS EN UN IFRAME O PODEMOS HACER UN REDIRECT.
*/
?>
<iframe src="<?php echo  $linkvpos;?>" style="width:100%;height:600px"></iframe>