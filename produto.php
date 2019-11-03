<?php require './pages/header.php'; ?>
<?php
require './classes/anuncios.class.php';
$a = new Anuncios();
$us = new Usuarios();
if (!empty($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header("Location: ./");
}
$info = $a->getAnuncio($id)
?>
<div class="container">
    <div class="row">
        <div class="col-sm-4">
            <div class="carousel slide" data-ride="carousel" id="meuCarrosel">
                <ol class="carousel-indicators">
                    <?php foreach ($info['fotos'] as $chave => $foto) {
                        ?>
                        <li data-target="#meuCarrosel" data-slide-to="<?php echo $chave;?>" class="<?php echo ($chave == '0') ? "active" : ""; ?>"></li>
                        <?php
                    }
                    ?>
                </ol>
                <div class="carousel-inner">
                    <?php foreach ($info['fotos'] as $chave => $foto) {
                        ?>
                        <div class="carousel-item <?php echo ($chave == '0') ? "active" : ""; ?>">
                            <img src="images/anuncios/<?php echo $foto['url']; ?>"/>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <a class="carousel-control-prev" href="#meuCarrosel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Anterior</span>
                </a>
                <a class="carousel-control-next" href="#meuCarrosel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Próximo</span>
                </a>
            </div>
        </div>
        <div class="col-sm-8">
            <h1><?php echo $info['titulo'];?></h1>
            <h4><?php echo $info['categoria'];?></h4>
            <p><?php echo $info['descricao'];?></p>
            <br/>
            <h3>R$ <?php echo number_format($info['valor'],2,",",".");?></h3>
            <h4>Fone: <?php echo $info['telefone'];?></h4>
        </div>
    </div>
</div>
<?php require './pages/footer.php'; ?>