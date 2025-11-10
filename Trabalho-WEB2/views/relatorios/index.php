<?php 
// Inicia a sessão para usar o $_SESSION
session_start();
require_once VIEW_PATH . 'layout/header.php'; 
?>

<h1><?php echo $titulo; ?></h1>

<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                Resumo de Tarefas por Status
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Pendente
                        <span class="badge bg-danger rounded-pill"><?php echo $resumo['Pendente'] ?? 0; ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Em Progresso
                        <span class="badge bg-warning rounded-pill"><?php echo $resumo['Em Progresso'] ?? 0; ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Concluída
                        <span class="badge bg-success rounded-pill"><?php echo $resumo['Concluída'] ?? 0; ?></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                Geração de Relatórios
            </div>
            <div class="card-body">
                <p>Gere um relatório detalhado de todas as suas tarefas.</p>
                <a href="<?php echo BASE_URL; ?>/relatorios/gerarPdf" class="btn btn-success">
                    <i class="bi bi-file-earmark-pdf"></i> Gerar Relatório em PDF (Simulado)
                </a>
            </div>
        </div>
    </div>
</div>

<?php require_once VIEW_PATH . 'layout/footer.php'; ?>
