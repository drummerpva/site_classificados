<?php
require './pages/header.php';
if (!empty($_SESSION['cLogin'])) {
    ?>
    <script type="text/javascript">window.location.href = "./";</script>
    <?php
}
require './classes/usuarios.class.php';
?>
<div class="container">
    <h1>Faça o Login</h1>
    <?php
    $u = new Usuarios();
    if (!empty($_POST['email'])) {
        $email = addslashes($_POST['email']);
        $senha = md5($_POST['senha']);
        if (!empty($email) && !empty($senha)) {
            if ($u->login($email, $senha)) {
                ?>
                <script type="text/javascript">window.location.href = "./";</script>
                <?php
            } else {
                ?>
                <div class="alert alert-danger">
                    <p><b>Erro!</b> Usuário e/ou senhas errados.</p>
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
        <fieldset>
            <div class="col-4">
                <div class="form-group input-group">
                    <input type="email" name="email" id="email" required class="form-control" placeholder="Email"/>
                    <div class="input-group-apend">
                        <span class="input-group-text">@</span>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <input type="password" name="senha" id="senha" required class="form-control" placeholder="Senha"/>
                </div>
            </div>
            <div class="col-4"
                 <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Login"/>
                </div>
            </div>
        </fieldset>
    </form>
</div>
<?php require './pages/footer.php'; ?>