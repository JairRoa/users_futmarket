<?php
    
    require 'assets/config/database.php';
    require 'assets/config/config.php';
    
  

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



        $sql = $conn ->prepare ('SELECT id, nombre, precio, id_categoria FROM productos WHERE Activo > 0');
        $sql ->execute();
        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

        $prod = null;

        if (count($resultado) > 0){
            $prod = $resultado;
        }
    
    
   
        $cat = $conn ->prepare ('SELECT * FROM categorias WHERE id > 0 ');
        $cat ->execute();
        $resultados = $cat->fetchAll(PDO::FETCH_ASSOC);

        $categ = null;

        if (count($resultados) > 0){
            $categ = $resultados;
        }


//session_destroy();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FutMarket</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" 
    crossorigin="anonymous">
    
    <link href="assets/css/style.css" rel="stylesheet">

</head>

<body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" 
        crossorigin="anonymous">
    </script>

    <header>
        <div class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
            <div class="container">
            <a href="#" class="navbar-brand">
                
                <strong>FUTMARKET</strong>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
            data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" 
            aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarHeader">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a href="#" class="nav-link active">MERCADO CAMPESINO</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link ">EMPRESAS</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">PROVEEDORES</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">CONTACTO</a>
                    </li>
                </ul>

                <a href="paypal.php" class="btn btn-primary">CARRITO 
                        <span id="num_cart" class="badge bg-secondary">
                                <?php echo $num_cart; ?> 
                        </span> </a> 
            </div>

            
        </div>
    </header>

    

    <p>Envíos a todo Bogotá</p> <!--poner icono de carro de envios-->
        <h1>La Revolución Agro</h1>
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
         <br>estas en tu perfil 
         <a href="log_out.php">Cerrar sesión</a>

     <?php endif; ?>

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
   
    <main>
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                <?php foreach( $resultado as $row) { ?>
                        <div class="col">
                        
                            <section>
                                <div class="card shadow-sm">
                                    <?php

                                        $id_prod = $row ['id_categoria'];
                                        $imagen = "assets/images/productos/" . $id_prod . "/main.jpg";

                                        if(!file_exists($imagen)){
                                            $imagen = "assets/images/no-foto.webp";
                                        }

                                    ?>
                                        <img src="<?php echo $imagen; ?>" class = 'd-block w-100'>   
                                        <h4 class="card-product">   <?php echo $row ['nombre'] ?> </h4>
                                        <P class="card-text">   $ <?php echo number_format( $row ['precio'], 3, '.' , '.'); ?></P>
                                    
                                        <div class="card-body"> 
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="btn-group">
                                                    <a href="detalles.php?id=<?php echo $row['id']; ?>&token=<?php echo 
                                                    hash_hmac('sha512', $row ['id'] , KEY_TOKEN); ?>" class="btn btn-primary">DETALLES</a>
                                                </div>
                                                <button class= "btn btn-outline-success" type="button"> 
                                                     AGREGAR AL CARRITO 
                                                </button>
                                            </div>
                                        </div>
                                </div>
                            </section>
                        </div>
                <?php } ?>
            </div>
        </div>
                
    </main>



    <script>

        function addProducto (id, token){
            let url = 'carrito.php'
            let formData = new FormData()
            formData.append('id', id)
            formData.append('token', token)

            fetch(url, {
                method: 'POST',
                body: formData,
                mode: 'cors'

            }).then(response => response.json())
            .then(data =>{
                if(data.ok){
                    let elemento = document.getElementById("num_cart")
                    elemento.innerHTML = data.numero
                }
            })
        }
    </script>

    





</body>
</html>