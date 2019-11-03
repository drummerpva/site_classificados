<?php
require 'pages/header.php';
if (empty($_SESSION['cLogin'])) {
    header("Location: login.php");
}
require 'classes/anuncios.class.php';

if (!empty($_POST['titulo'])) {
    $idUsuario = $_SESSION['cLogin'];
    $categoria = $_POST['categoria'];
    $titulo = addslashes($_POST['titulo']);
    $valor = number_format(str_replace(",", ".", str_replace(".", "", $_POST['valor'])), 2, ".", "");
    $descricao = addslashes($_POST['descricao']);
    $estado = $_POST['estado'];
    $a = new Anuncios();
    $a->inserirAnuncio($idUsuario, $categoria, $titulo, $valor, $descricao, $estado);
    header("Location: meusAnuncios.php");
    ?>

    <div class="alert alert-success">
        Produto adicionado com sucesso!
    </div>   

    <?php
}
?>
<div class="container">
    <h2>Adicionar Anúncio</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="col-6">
            <div class="form-group" required>
                <select name="categoria" id="categoria" class="custom-select" required>
                    <option disabled selected style="color: #999;">Categorias</option>
                    <?php
                    require './classes/categorias.class.php';
                    $c = new Categorias();
                    $categorias = $c->getCategorias();
                    foreach ($categorias as $categoria) {
                        ?>
                        <option value="<?php echo $categoria['id']; ?>"><?php echo $categoria['nome']; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <input type="text" name="titulo" id="titulo" required class="form-control" placeholder="Título"/>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <input type="text" name="valor" id="valor" required class="form-control" placeholder="Valor"/>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <textarea name="descricao" id="descricao" class="form-control" placeholder="Descrição" rows="5"></textarea>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <select name="estado" id="estado" class="custom-select" required>
                    <option disabled selected>Estado de Conservação</option>
                    <option value="0">Ruim</option>
                    <option value="1">Bom</option>
                    <option value="2">Ótimo</option>
                </select>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <input type="submit" class="btn btn-default" value="Gravar"/>
            </div>
        </div>
    </form>
</div>




<?php require 'pages/footer.php'; ?>