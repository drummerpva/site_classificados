<?php
require 'config.php';
if (empty($_SESSION['cLogin'])) {
    header("Location: login.php");
}
require './classes/anuncios.class.php';
if(!empty($_GET['id'])){
    $id = addslashes($_GET['id']);
    $anuncio = new Anuncios();
    $anuncio->excluirAnuncio($id);
    header("Location: meusAnuncios.php");
}