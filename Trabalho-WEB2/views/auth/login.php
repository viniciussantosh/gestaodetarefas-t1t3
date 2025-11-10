<?php 
// Inicia a sessão para usar o $_SESSION
session_start();
require_once VIEW_PATH . 'layout/header.php'; 
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="text-center">Login</h3>
            </div>
            <div class="card-body">
                <form action="<?php echo BASE_URL; ?>/auth/processLogin" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="senha" name="senha" required>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <button type="submit" class="btn btn-primary">Entrar</button>
                        <a href="<?php echo BASE_URL; ?>/auth/forgotPassword" class="text-muted">Esqueceu a senha?</a>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center">
                Não tem uma conta? <a href="<?php echo BASE_URL; ?>/auth/register">Registre-se</a>
            </div>
        </div>
    </div>
</div>

<?php require_once VIEW_PATH . 'layout/footer.php'; ?>
