<?php

    $dbHost = 'localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbPort = '3306';
    $dbName = 'ipets';

    $connection = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName, $dbPort);

    // if($connection->connect_errno) {
    //     echo "Erro";
    // } else {
    //     echo "Conectado";
    // }

?>