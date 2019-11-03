<?php
require 'pages/header.php';
if (empty($_SESSION['cLogin'])) {
    header("Location: login.php");
}
?>
<div class="container">
    <h1 >Meus Anúncios</h1>
    <a href="addAnuncio.php" class="btn btn-info">Adicionar Anúncio</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Foto</th>
                <th>Título</th>
                <th>Valor</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require './classes/anuncios.class.php';
            $a = new Anuncios();
            $anuncios = $a->getMeusAnuncios($_SESSION['cLogin']);
            foreach ($anuncios as $anuncio) {
                ?>
                <tr>
                    <td>
                        <?php
                        if (!empty($anuncio['url'])) {
                            $urlImg = $anuncio['url'];
                        } else {
                            $urlImg = "default.jpg";
                        }
                        ?>
                        <img src="<?php echo "images/anuncios/" . $urlImg; ?>" height="50"/></td>
                    <td><?php echo $anuncio['titulo']; ?></td>
                    <td><?php echo "R$ " . number_format($anuncio['valor'], 2, ",", "."); ?></td>
                    <td>
                        <a href="editarAnuncio.php?id=<?php echo $anuncio['id'];?>" class="btn btn-default">Editar</a>
                        <a href="excluirAnuncio.php?id=<?php echo $anuncio['id']?>" class="btn btn-danger">Excluir</a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
</div>

<?php require 'pages/footer.php'; ?>