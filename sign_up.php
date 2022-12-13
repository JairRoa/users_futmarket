<?php 
    require 'assets/config/database.php';

    $message = '';

    if (!empty($_POST['user']) && !empty($_POST['pass']) && !empty($_POST['confirm_pass'])  && !empty($_POST['tel'])) {
        $sql = "INSERT INTO users (user, pass, confirm_pass, tel) VALUES (:user, :pass, :confirm_pass, :tel)";
        $stmt = $conn ->prepare($sql);
        $stmt ->bindParam (':user',$_POST['user']);
        $password = password_hash($_POST ['pass'], PASSWORD_BCRYPT);
        $stmt ->bindParam (':pass',$password);
        $stmt ->bindParam (':confirm_pass',$password);
        $stmt ->bindParam (':tel',$_POST['tel']);

        if ($stmt ->execute()){
            $message = 'Succesfully created new user';          
        } else {
            $message = 'sorry, an error occurred';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <title>Cree una cuenta</title><br><br>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <header>
        <?php require 'partials/inicio.php' ?><br><br>
    </header>
    
    <?php if (!empty ($message)): ?>
        <p><?= $message ?></p>
    <?php endif; ?>


    <h1>Crear cuenta</h1><br><br>
    <span>o <a href="login.php">Iniciar sesión</a></span><br><br>

    <form action="sign_up.php" method="post">

        <p>Nombre</p><input type="text" name="nom" placeholder="Ingrese su nombre"><br>
        <p>Apellido</p><input type="text" name="lastname" placeholder="Ingrese su apellido"><br>
        <p>Correo</p><input type="text" name="user" placeholder="Ingrese su email"><br>
        <p>Introduzca una contraseña</p><input type="text" name="pass" placeholder="Ingrese su contraseña"><br>
        <p>Repita su contraseña</p><input type="text" name="confirm_pass" placeholder="Confirme su contraseña"><br>
        <p>Teléfono</p><input type="int" name="tel" placeholder="Ingrese numero de teléfono"><br>

        <p>Enviar</p><input type="submit" value="Registrar">

    </form>


</body>
</html>