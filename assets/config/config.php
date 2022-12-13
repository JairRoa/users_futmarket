<?php 

session_start();


define("KEY_TOKEN" , "3tcRjY99E&bx");
define("MONEDA" , "$");






$num_cart = "";
if(isset($_SESSION ['carrito']['productos'])){
    $num_cart = count($_SESSION ['carrito']['productos']);
}
?>