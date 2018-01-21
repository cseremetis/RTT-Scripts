<?php
    /*Template name: Config*/
    //connect to database
    $servername = "localhost";
    $username = "*";
    $pass = "*";
    $charset = "utf8mb4";
    $db = "*";
    
    $dsn="mysql:host=$host;dbname=$db;charset=$charset";
    $pdo = new PDO($dsn, $username, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if(!isset($pdo)){
        die("Failure to establish secure connection");
    }
?>
