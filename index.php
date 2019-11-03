<?php require './pages/header.php'; ?>
<?php
require './classes/anuncios.class.php';
require './classes/categorias.class.php';
$a = new Anuncios();
$us = new Usuarios();
$c = new Categorias();

$filtros = array(
    "categoria" => "",
    "preco" => "",
    "estado" => ""
);
if (!empty($_GET['filtros'])) {
    $filtros = $_GET['filtros'];
}

$totalAnuncios = $a->getTotalAnuncios($filtros);
$totalUsuarios = $us->getTotalUsuarios();
$p = 1;
if (!empty($_GET['p'])) {
    $p = addslashes($_GET['p']);
}



$anuncios = $a->getUltimosAnuncios($p, 2, $filtros);
$totalPag = ceil($totalAnuncios / 2);
$categorias = $c->getCategorias();
?>
<div class="container-fluid">
    <div class="jumbotron">
        <div class="container">
            <h1 class="display-4">Nós temos Hoje <?php echo $totalAnuncios; ?> anúncios</h1>
            <p class="lead">E mais de <?php echo $totalUsuarios; ?> usuários cadastrados</p>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <h4 class="text-center text-muted">Pesquisa avançada</h4>
            <form>
                <div class="col">
                    <div class="form-group">
                        <label for="categoria" class="label">Categoria:</label>
                        <select name="filtros[categoria]" class="custom-select">
                            <option selected></option>
                            <?php foreach ($categorias as $categoria) {
                                ?>
                                <option value="<?php echo $categoria['id']; ?>" <?php echo ($categoria['id'] == $filtros['categoria']) ? "selected" : ""; ?>><?php echo $categoria['nome']; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="preco" class="label">Valor:</label>
                        <select name="filtros[preco]" class="custom-select">
                            <option ></option>
                            <option value="0-50" <?php echo ($filtros['preco'] == '0-50') ? "selected" : ""; ?> >R$ 0,00 à 50,00</option>
                            <option value="51-100" <?php echo ($filtros['preco'] == '51-100') ? "selected" : ""; ?> >R$ 51,00 à 100,00</option>
                            <option value="101-200" <?php echo ($filtros['preco'] == '101-200') ? "selected" : ""; ?> >R$ 101,00 à 200,00</option>
                            <option value="201-500" <?php echo ($filtros['preco'] == '201-500') ? "selected" : ""; ?> >R$ 201,00 à 500,00</option>
                            <option value="500-1000000" <?php echo ($filtros['preco'] == '500-1000000') ? "selected" : ""; ?> >R$ 500,00 acima</option>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="estado" class="label">Estado de Conservação:</label>
                        <select name="filtros[estado]" id="estado" class="custom-select">
                            <option></option>
                            <option value="0" <?php echo ($filtros['estado'] == '0') ? "selected" : ""; ?> >Ruim</option>
                            <option value="1" <?php echo ($filtros['estado'] == '1') ? "selected" : ""; ?> >Bom</option>
                            <option value="2" <?php echo ($filtros['estado'] == '2') ? "selected" : ""; ?> >Ótimo</option>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <input type="submit" value="Filtrar" class="btn btn-info"/>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-sm-9">
            <h4>Últimos anúncios</h4>
            <table class="table table-striped">
                <tbody>
                    <?php foreach ($anuncios as $anuncio) {
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
                            <td><a href="produto.php?id=<?php echo $anuncio['id']; ?>" ><?php echo $anuncio['titulo']; ?></a><br/>
                                <?php echo $anuncio['categoria']; ?>
                            </td>
                            <td><?php echo "R$ " . number_format($anuncio['valor'], 2, ",", "."); ?></td>

                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
            <ul class="pagination">
                <?php for ($q = 1; $q <= $totalPag; $q++) {
                    ?>
                    <li class="page-item <?php echo ($p == $q) ? "active" : ""; ?>"><a class="page-link" href="index.php?<?php 
                    $w = array();
                    if(!empty($_GET['filtros'])){
                        $w = $_GET;
                    }
                    $w['p'] = $q;
                    echo http_build_query($w);
                    ?>"><?php echo $q; ?></a></li>
                        <?php
                    }
                    ?>
            </ul>
        </div>
    </div>
</div>
<?php require './pages/footer.php'; ?>


