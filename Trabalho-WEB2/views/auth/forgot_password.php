<?php 
// Inicia a sessão para usar o $_SESSION
session_start();
require_once VIEW_PATH . 'layout/header.php'; 
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="text-center">Recuperar Senha</h3>
            </div>
            <div class="card-body">
                <p class="text-center">Em um sistema real, você receberia um e-mail com um link para redefinir sua senha.</p>
                <form action="#" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail de Cadastro</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <button type="submit" class="btn btn-warning w-100" disabled>Enviar Link de Recuperação (Funcionalidade Desativada)</button>
                </form>
            </div>
            <div class="card-footer text-center">
                <a href="<?php echo BASE_URL; ?>/auth/login">Voltar para o Login</a>
            </div>
        </div>
    </div>
</div>

<?php require_once VIEW_PATH . 'layout/footer.php'; ?>
