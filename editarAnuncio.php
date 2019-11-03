<?php
require 'pages/header.php';
if (empty($_SESSION['cLogin'])) {
    header("Location: login.php");
}
require 'classes/anuncios.class.php';
$a = new Anuncios();
if (!empty($_POST['idAlt'])) {
    $id = $_POST['idAlt'];
    $categoria = $_POST['categoria'];
    $titulo = addslashes($_POST['titulo']);
    $valor = number_format(str_replace(",", ".", str_replace(".", "", $_POST['valor'])), 2, ".", "");
    $descricao = addslashes($_POST['descricao']);
    $estado = $_POST['estado'];
    if (!empty($_FILES['fotos'])) {
        $fotos = $_FILES['fotos'];
    } else {
        $fotos = array();
    }
    $a->alterarAnuncio($id, $categoria, $titulo, $valor, $descricao, $estado, $fotos);
    ?>

    <div class="alert alert-success">
        Produto Editado com sucesso!
    </div>   

    <?php
}

if (!empty($_GET['id'])) {
    $idAnunc = addslashes($_GET['id']);
    $info = $a->getAnuncio($idAnunc);
} else {
    header("Location: meusAnuncios.php");
}
?>
<div class="container">
    <h2>Editar Anúncio</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="idAlt" value="<?php echo $info['id']; ?>">
        <div class="col-6">
            <div class="form-group" required>
                <select name="categoria" id="categoria" class="custom-select" required>
                    <?php
                    require './classes/categorias.class.php';
                    $c = new Categorias();
                    $categorias = $c->getCategorias();
                    foreach ($categorias as $categoria) {
                        ?>
                        <option value="<?php echo $categoria['id']; ?>"  <?php echo ($info['id_categoria'] == $categoria['id']) ? "selected" : ""; ?>><?php echo $categoria['nome']; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <input type="text" name="titulo" id="titulo" required class="form-control" placeholder="Título" value="<?php echo $info['titulo']; ?>"/>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <input type="text" name="valor" id="valor" required class="form-control" placeholder="Valor"  value="<?php echo number_format($info['valor'], 2, ",", "."); ?>"/>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <textarea name="descricao" id="descricao" class="form-control" placeholder="Descrição" rows="5"> <?php echo $info['descricao']; ?></textarea>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <select name="estado" id="estado" class="custom-select" required>
                    <option value="0" <?php echo ($info['estado'] == '0') ? "selected" : ""; ?>>Ruim</option>
                    <option value="1" <?php echo ($info['estado'] == '1') ? "selected" : ""; ?>>Bom</option>
                    <option value="2" <?php echo ($info['estado'] == '2') ? "selected" : ""; ?>>Ótimo</option>
                </select>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group rounded">
                <input type="file" name="fotos[]" placeholder="Envie as fotos do anúncio" multiple class="form-control"/><br/>
                <div class="card">
                    <div class="card-header">Fotos do Anúncio</div>
                    <div class="card-body">
                        <?php foreach ($info['fotos'] as $foto) {
                            ?>
                        <div class="fotoItem">
                            <img src="images/anuncios/<?php echo $foto['url'];?>" class="img-thumbnail" />
                            <a href="excluirFoto.php?id=<?php echo $foto['id'];?>" class="btn btn-danger">X</a>
                        </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <input type="submit" class="btn btn-default" value="Salvar"/>
                <a href="meusAnuncios.php" class="btn btn-secondary">Cancelar/Voltar</a>

            </div>
        </div>
    </form>
</div>




<?php require 'pages/footer.php'; ?>