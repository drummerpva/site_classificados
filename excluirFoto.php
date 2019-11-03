<?php
require 'config.php';
if (empty($_SESSION['cLogin'])) {
    header("Location: login.php");
}
require './classes/anuncios.class.php';
$anuncio = new Anuncios();
if(!empty($_GET['id'])){
    $id = addslashes($_GET['id']);
    $idAnuncio = $anuncio->excluirFoto($id);
}
if(!empty($idAnuncio)){
    header("Location: editarAnuncio.php?id=".$idAnuncio);
}else{
    header("Location: meusAnuncios.php");
}