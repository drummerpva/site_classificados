<?php
session_start();
global $pdo;
try{
    $pdo = new PDO("mysql:dbname=projeto_classificados;host=localhost;charset=utf8","root","");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $ex) {
    die("Erro BD: ".$ex->getMessage());
}
