<?php

    session_start();

    require 'assets/config/database.php';

    if (!empty ($_POST['user']) && !empty ($_POST['pass'])){
        $records = $conn ->prepare('SELECT id, user, pass FROM users WHERE user=:user');
        $records->bindParam(':user', $_POST['user']);
        $records->execute ();
        $results = $records->fetch(PDO::FETCH_ASSOC);

        $message = '';

        if (count($results) > 0 && password_verify ($_POST['pass'], $results['pass'])){
            $_SESSION['user_id'] = $results ['id'];
            header ('location: /users_futmarket/user_profile.php');

        }else {
          $message ='verifique su contraseña';
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ingrese a su cuenta</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <header>
        <?php require 'partials/inicio.php' ?>
    </header>
    
    <?php if (!empty ($message)): ?>
        <p><?= $message ?></p>
    <?php endif; ?>


    <h1>Ingrese a su cuenta</h1>
    <span>o <a href="sign_up.php">regístrese</a></span>

    <form action="login.php" method="post">

        <input type="text" name="user" placeholder="Ingrese su email">
        <input type="text" name="pass" placeholder="Ingrese su contraseña">
        <input type="submit" value="Ingresar">

    </form>
</body>
</html>