<?php
require './config.php';
if(!empty($_SESSION['cLogin'])){
require './classes/usuarios.class.php';
$u = new Usuarios();
$usuario = $u->getUsuario($_SESSION['cLogin']);

}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Classificados do Douglas</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/bootstrap.min.css" rel="stylesheet" />
        <link href="css/estilos.css" rel="stylesheet" />
    </head>
    <body>
        <nav class="navbar  navbar-dark bg-dark">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a href="./" class="navbar-brand">Classificados</a>
                </div>
                <ul class="nav navbar navbar-right">
                    <?php if (empty($_SESSION['cLogin'])) { ?>
                        <li class="nav-item nav-link"><a href="cadastrese.php">Cadastre-se</a></li>
                        <li class="nav-item nav-link"><a href="login.php">Login</a></li>
                    <?php } else { ?>
                        <li class="navbar-text"><?php echo $usuario['nome'];?></li>
                        <li class="nav-item nav-link"><a href="meusAnuncios.php">Meus Anúncios</a></li>
                        <li class="nav-item nav-link"><a href="sair.php">Sair</a></li>
                        <?php } ?>
                </ul>
            </div>
        </nav>
