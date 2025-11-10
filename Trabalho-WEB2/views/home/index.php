<?php 
// Inicia a sessão para usar o $_SESSION
session_start();
require_once VIEW_PATH . 'layout/header.php'; 
?>

<div class="p-5 mb-4 bg-light rounded-3">
    <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold">Bem-vindo ao <?php echo APP_NAME; ?></h1>
        <p class="col-md-8 fs-4">Seu sistema completo para gerenciar tarefas, desenvolvido com PHP e MySQL, seguindo o padrão MVC e com foco em segurança e usabilidade.</p>
        <hr class="my-4">
        <p>Faça login para começar a gerenciar suas tarefas ou registre-se para criar uma nova conta.</p>
        <a class="btn btn-primary btn-lg" href="<?php echo BASE_URL; ?>/auth/login" role="button">Fazer Login</a>
        <a class="btn btn-outline-secondary btn-lg" href="<?php echo BASE_URL; ?>/auth/register" role="button">Registrar</a>
    </div>
</div>

<?php require_once VIEW_PATH . 'layout/footer.php'; ?>
