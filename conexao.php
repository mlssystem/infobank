<?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "infobank" ;
    try {
        $conn = new PDO("mysql:host=$host;dbname=" . $dbname, $user, $pass);
        //echo "Conexão com o banco de dados realizada com sucesso";    
    } catch (PDOException $err) {
        echo "Erro: Conexão com banco de dados não foi realizada. Erro gerado " . $err->getMessage();
    }    
?>