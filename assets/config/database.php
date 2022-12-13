<?php

    $server = 'localhost';
    $username = 'jair';
    $pass = 'sbIh_80W-vSJJaNf';
    $database = 'futmarket_database';

    try {
        $conn = new PDO ("mysql:host=$server;dbname=$database;",$username, $pass);
    } catch (PDOexeption $e) {
       die ('Conected failed: '.$e ->getMessage());
    }

    function conectar(){
        try{
            $conexion = "mysql:host=" . $this->hostname . "; dbname=" . $this->database . "charset=" . $this->charset;
            $options = [
                PDO::ATTR_ERRMODE=> PDO::ERRMODE_ESCEPTION,
                PDO::ATTR_EMULATE_PREPARES=> false
            ];

            $pdo= new PDO($conexion, $this->$username, $this->$password, $options);

            return $pdo;
        } catch (PDOexeption $e) {
            echo 'Conected failed '.$e ->getMessage();
         }
    }
    
?>