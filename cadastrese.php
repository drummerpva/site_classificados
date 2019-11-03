<?php
require './pages/header.php';
require './classes/usuarios.class.php';
?>
<div class="container">
    <h1>Cadastre-se</h1>
    <?php
    $u = new Usuarios();
    if (!empty($_POST['nome'])) {
        $nome = addslashes($_POST['nome']);
        $email = addslashes($_POST['email']);
        $senha = md5($_POST['senha']);
        $telefone = addslashes($_POST['telefone']);
        if (!empty($nome) && !empty($email) && !empty($senha)) {
            if ($u->cadastrar($nome, $email, $senha, $telefone)) {
                ?>
                <div class="alert alert-success">
                    <p><b>Parabéns</b> cadastrado com sucesso. <a href="./login.php" class="alert-link">Faça o login agora</a></p>
                </div>
                <?php
            } else {
                ?>
                <div class="alert alert-warning">
                    <p><b>Erro!</b> E-mail ja cadastrado. <a href="./login.php" class="alert-link">Faça o login agora</a></p>
                </div>
                <?php
            }
        } else {
            ?>
            <div class="alert alert-warning">
                <p>Preencha todos os campos!</p>
            </div>
            <?php
        }
    }
    ?>
    <form method="POST">
        <div class="col-6">
            <div class="form-group">
                <input type="text" name="nome" id="nome" required class="form-control" placeholder="Nome"/>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group input-group">
                <input type="email" name="email" id="email" required class="form-control" placeholder="Email"/>
                <div class="input-group-apend">
                    <span class="input-group-text">@</span>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <input type="password" name="senha" id="senha" required class="form-control" placeholder="Senha"/>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <input type="tel" name="telefone" id="telefone" class="form-control" placeholder="Telefone"/>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <input type="submit" class="btn btn-default" value="Gravar"/>
            </div>
        </div>
    </form>
</div>
<?php require './pages/footer.php'; ?>