<?php
    $hostname = "localhost";
    $username = "extravagantm";
    $password = "";
    $dbname = "cab230";
    $pdo = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>