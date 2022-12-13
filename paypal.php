<?php


    require '../users_futmarket/assets/config/database.php';
    require '../users_futmarket/assets/config/config.php';
    
  

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

        $productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

        $lista_carrito = array();

        if ($productos != null) {

            $sql = $conn ->prepare ("SELECT id, nombre, precio, id_categoria, descuento, $cantidad AS cantidad FROM productos WHERE id=? AND Activo=1");
            $sql ->execute($clave);
            $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);
            

            if (count($resultado) > 0){
                $prod = $resultado;
            }

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

                <a href="#" class="btn btn-primary">CARRITO</a>
            </div>

            
        </div>
    </header>

    

    
    <section>
     
     <?php if(!empty($user)): ?>

         <br><?= $user ['user']  ?> REVISA MUY BIEN TU PEDIDO
         <br> 
         <a href="log_out.php">Cerrar sesión</a>

     <?php endif; ?>

     <header>
        <h3><a href="user_profile.php">Regresar</a></h3>
    </header>

    </section>

    <br>
    <br>
    <br>
    <br>
   
    <main>
        <div class="container">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                           <th>Producto</th> 
                           <th>Precio</th> 
                           <th>Cantidad</th> 
                           <th>Subtotal</th> 
                           <th></th> 

                        </tr>
                    </thead>
                    <tbody>
                        <?php if($lista_carrito==null){
                            echo '<tr><td colspan="5" class="text-center"><b> lista vacía </td></tr>';
                        }else {

                            $gran_total = 0;
                            foreach($lista_carrito as $prod){
                                $_id = $prod['id'];
                                $nombre = $prod['nombre'];
                                $precio = $prod['precio'];
                                $descuento = $prod['descuento'];
                                $precio_desc = $precio - (($precio * $descuento) / 100);
                                $subtotal = $cantidad * $precio;
                                $total = $cantidad * $precio_desc;
                                $gran_total += $total;
                        ?>
                                
                        <tr>
                            <td><?php echo $nombre; ?></td>
                            <td>
                                <?php echo MONEDA . number_format($precio_desc, 3,'.',','); ?> 
                            </td>
                            <td>
                                <input type="number" min="=1" max="10" step="1" value="<?php echo $cantidad ?>" size="5" id="cantidad_<?php echo $_id; ?>" onchange="" > 
                            </td>
                            <td>
                                <div id="total_<?php echo $_id; ?>" name="total[]">
                                    <?php MONEDA . number_format($total,3,'.',','); ?>
                                </div>
                            </td>
                            <td>
                                <a href="#" id="eliminar" class="btn btn-warning btn-sm" data-bs-id="<?php echo $_id; ?>" data-bs-toggle="modal" data-bs-target="eliminaModal">Eliminar</a>
                            </td>
                        </tr>
                        
                    </tbody>
                    <?php } ?>
                </table>
                <?php } ?>
            </div>
            
        </div>
                
    </main>



    <script>
        function AddProducto (id, token){
            let url = 'users_futmarket/carrito.php'
            let formData = new FormData()
            formaData.append('id', id)
            formData.append('token', token)

            fetch(url, {
                method: 'POST',
                body: 'formData',
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