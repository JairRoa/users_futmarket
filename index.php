<?php

    session_start();

    require 'assets/config/database.php';

    if (isset($_SESSION['user_id'])){
        $records = $conn ->prepare ('SELECT id, user, nom, pass FROM users WHERE id = :id');
        $records ->bindParam(':id', $_SESSION['user_id']);
        $records ->execute();
        $results = $records->fetch(PDO::FETCH_ASSOC);

        $user = null;

        if (count($results) > 0){
            $user = $results;
        }
    }



?>

<!DOCTYPE html>
<html>
<head>
    <title>FutMarket</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/estilo.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

    

    <p>Envíos a todo Bogotá</p> <!--poner icono de carro de envios-->
    <h1>
        <header>
        <a href="index.php">Bienvenido a FutMarket</a>
        </header>
    </h1>
        <h2>"Del campo a tu puerta"</h2>
    <section class="buscar">
        <input type="text" class="buscar_text">
        <a href="" class="boton">
            <i class="icon-buscar">BUSCAR</i>
            <!--PONER ICONO DE BUSCAR-->
        </a>
    </section>
    
    <section>
     
     <?php if(!empty($user)): ?>

         <br> BIENVENIDO  <?= $user ['user']  ?> 
         <br>TE HAS LOGUEADO AHORA 
         <a href="log_out.php">Cerrar sesión</a>
     <?php else: ?>
         
         <h1>Por favor introduzca su usuario o regístrese</h1>

         <a href="/users_futmarket/login.php">Ingresar</a>
         <a href="/users_futmarket/sign_up.php">Registrarse</a>

     <?php endif; ?>

    </section>

    <section class="menu_principal">
        <ul class="menu">
            <li>
                <a href="index.php">Inicio</a>
            </li>
            <li>
                <a href="#">Proveedores</a>
            </li>
            <li>
                <a href="#">Empresas</a>
            </li>
            <li>
                <a href="#">Contacto</a>
            </li>
            <li>
                <a href="#">Quienes somos</a>
            </li>
        </ul>
    </section>

 
    
    <section id="primeras_imagenes">
        <img src="assets/images/productos/2/onions-1397037_1280.jpg" alt="verdura de temporada" style="width: 600px;">
        <img src="assets/images/productos/3/fruit-3489313_1280.jpg" alt="verdura de temporada" style="width: 300px;">
        <img src="assets/images/productos/3/nest-1050964_1280.jpg" alt="verdura de temporada" style="width: 300px;">
    </section>
    <br>
    <br>
    <br>
    <br>
    <section class="contenido">
        <div class="mostrador" id="mostrador">
            <div class="fila">
                <div class="item" onclick="cargar(this)">
                    <div class="contenedor-foto">
                        <img src="assets/images/productos/1/banano.jpg" alt="">
                    </div>
                    <p class="descripcion">banano</p>
                    <span class="precio">$ 1.300</span>
                </div>
                <div class="item" onclick="cargar(this)">
                    <div class="contenedor-foto">
                        <img src="assets/images/productos/1/fresa.jpg" alt="">
                    </div>
                    <p class="descripcion" id>Fresa</p>
                    <span class="precio">$ 1.800</span>
                </div>
                <div class="item" onclick="cargar(this)">
                    <div class="contenedor-foto">
                        <img src="assets/images/productos/2/lechuga.jpg" alt="">
                    </div>
                    <p class="descripcion">lechuga
                    </p>
                    <span class="precio">$ 3.600</span>
                </div>
                <div class="item" onclick="cargar(this)">
                    <div class="contenedor-foto">
                        <img src="assets/images/productos/2/papa.jpg" alt="">
                    </div>
                    <p class="descripcion">papa</p>
                    <span class="precio">$ 1.800</span>
                </div>
            </div>
            <div class="fila">
                <div class="item" onclick="cargar(this)">
                    <div class="contenedor-foto">
                        <img src="assets/images/productos/2/tomate.jpg" alt="">
                    </div>
                    <p class="descripcion">tomate criollo</p>
                    <span class="precio">$ 130</span>
                </div>
                <div class="item" onclick="cargar(this)">
                    <div class="contenedor-foto">
                        <img src="assets/images/productos/2/zanahoria.jpg" alt="">
                    </div>
                    <p class="descripcion">zanahoria</p>
                    <span class="precio">$ 2.000</span>
                </div>
                <div class="item" onclick="cargar(this)">
                    <div class="contenedor-foto">
                        <img src="assets/images/productos/2/berenjena.jpg" alt="">
                    </div>
                    <p class="descripcion">berengena</p>
                    <span class="precio">$ 2.500</span>
                </div>
                <div class="item" onclick="cargar(this)">
                    <div class="contenedor-foto">
                        <img src="assets/images/productos/2/cilantro.jpg" alt="">
                    </div>
                    <p class="descripcion">cilantro</p>
                    <span class="precio">$ 1.800</span>
                </div>
            </div> 
        </div>


        
        <!-- CONTENEDOR DEL ITEM SELECCIONADO -->
        
        <div class="seleccion" id="seleccion">
            <div class="cerrar" onclick="cerrar()">
                &#x2715
            </div>
            <div class="info">
                <img src="img/1.png" alt="" id="img">
                <h2 id="modelo">PRODUCTO</h2>
                <span class="precio" id="precio">$ 130</span>

                <div class="fila">
                    <a href="login.php">
                        <input type="button" value=" QUIERO COMPRAR ">
                    </a>
                </div>
            </div>
        </div>
    </section>


    <!--JAVASCRIPT 


    <script>
        alert ('Bienvenido a FutMarket');
    </script>
    
    -->

    <script src="assets/javascript/script.js"></script>
    
   


</body>
</html>