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

        $id = isset($_GET ['id']) ? $_GET ['id'] : '';
        $token = isset($_GET ['token']) ? $_GET ['token'] : '';

        if ($id == '' || $token == ''){
            echo 'error de procesamiento de datos';
            exit;
        } else {
            $token_tmp = hash_hmac ('sha512' , $id , KEY_TOKEN);

            if ($token == $token_tmp){

                $sql = $conn ->prepare ('SELECT count(id) FROM productos WHERE id=? AND activo=1');
                $sql ->execute([$id]);
                    if($sql->fetchColumn() > 0) {

                        $sql = $conn ->prepare ('SELECT nombre, descripcion, precio, descuento FROM productos WHERE id=? AND activo=1');
                        $sql ->execute([$id]);
                        $row = $sql->fetch(PDO::FETCH_ASSOC);
                        $nombre = $row ['nombre'];
                        $descrip = $row ['descripcion'];
                        $precio = $row ['precio'];
                        $descuento = $row ['descuento'];
                        $precio_desc = $precio - (($precio * $descuento)/100);
                        $dir_images = 'assets/images/productos/'.$id.'/';

                        $rutImg = $dir_images . 'main.jpg';

                    if(!file_exists($rutImg)){
                        $rutImg = 'assets/images/no-foto.webp';
                    }

                    $imagenes = array();
                        if (file_exists($dir_images)){
                            $dir = dir($dir_images);

                         while (($archivo = $dir->read()) != false){
                             if ($archivo != 'main.jpg' && (strpos($archivo , 'jpg') || strpos($archivo , 'jpeg'))){
                             $images  = $dir_images . $archivo;
                             }   
                          }
                          $dir->close();
                        } else {
                             echo 'error de procesamiento de datos';
                             }
                    }
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
                        <a href="user_profile.php" class="nav-link active">MERCADO CAMPESINO</a>
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

                <a href="paypal.php" class="btn btn-primary">
                    CARRITO <span id="num_cart" class="badge bg-secondary">
                                <?php echo $num_cart; ?> 
                            </span>
                </a>
            </div>

            
        </div>
    </header>
    <header>
        <h3><a href="user_profile.php">Regresar</a></h3>
    </header>

    <main>
        <div class= "row">
            <div class ="col-md-6 order-md-1">

            <div id="carouselProducto" class="carousel slide carousel-fade" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="<?php echo $rutImg; ?>" class="d-block w-100" alt="">
                    </div>

                    <?php foreach($imagenes as $img) {?>
                        <div class="carousel-item">
                            <img src="<?php echo $img; ?>" class="d-block w-100" alt="">

                        </div>
                    <?php } ?>
                    
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselProducto" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselProducto" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div> 
        </div>

            <div class ="col-md-6 order-md-2">
                <h2><?php echo $nombre; ?> </h2>
                <?php if($descuento > 0) { ?>

                    <p> <del><?php echo MONEDA . number_format($precio, 3, '.', ','); ?> </del></p>
                    <h2> 
                        <small class="text-success" ><?php echo $descuento; ?> % descuento </small><br>
                        <?php echo MONEDA . number_format($precio_desc, 3, '.', ','); ?>
                        
                    </h2>
                <?php } else { ?>

                    <h2> <?php echo MONEDA . number_format($precio, 3, '.', ','); ?></h2>

                <?php } ?>
                <h4 class='lead'>
                <?php echo $descrip; ?>
                </h4>

                <div class="d-grid gap-3 col-10 mx-auto">
                    <button class= "btn btn-primary" type= "button">COMPRAR AHORA</button>
                    <button class= "btn btn-outline-success" type="button" onclick="addProducto(<?php echo $id; ?> , '<?php echo $token_tmp; ?>')">AGREGAR AL CARRITO</button>

                </div>
            </div>


        </div>




    </main>

<script>
    
    

    function addProducto (id, token){
        
        
        

        let url = 'paypal.php'
        let formData = new formData()
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
                elemento.innerHTML = data.numeros
            }
        })

    }
    
    
</script>

</body>
</html>