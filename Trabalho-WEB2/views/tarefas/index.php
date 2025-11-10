<?php 
// Inicia a sessão para usar o $_SESSION
session_start();
require_once VIEW_PATH . 'layout/header.php'; 
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><?php echo $titulo; ?></h1>
    <a href="<?php echo BASE_URL; ?>/tarefas/create" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Nova Tarefa</a>
</div>

<?php if (empty($tarefas)): ?>
    <div class="alert alert-info text-center" role="alert">
        Você ainda não tem tarefas cadastradas.
    </div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Título</th>
                    <th>Descrição</th>
                    <th>Vencimento</th>
                    <th>Prioridade</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tarefas as $tarefa): ?>
                    <tr class="<?php echo $tarefa['status'] === 'Concluída' ? 'table-success' : ''; ?>">
                        <td><?php echo htmlspecialchars($tarefa['titulo']); ?></td>
                        <td><?php echo htmlspecialchars(substr($tarefa['descricao'], 0, 50)) . (strlen($tarefa['descricao']) > 50 ? '...' : ''); ?></td>
                        <td><?php echo $tarefa['data_vencimento'] ? date('d/m/Y', strtotime($tarefa['data_vencimento'])) : 'N/A'; ?></td>
                        <td>
                            <?php 
                                $badge_class = '';
                                switch ($tarefa['prioridade']) {
                                    case 'Alta': $badge_class = 'danger'; break;
                                    case 'Média': $badge_class = 'warning'; break;
                                    case 'Baixa': $badge_class = 'info'; break;
                                }
                            ?>
                            <span class="badge bg-<?php echo $badge_class; ?>"><?php echo $tarefa['prioridade']; ?></span>
                        </td>
                        <td><?php echo $tarefa['status']; ?></td>
                        <td>
                            <a href="<?php echo BASE_URL; ?>/tarefas/edit/<?php echo $tarefa['id']; ?>" class="btn btn-sm btn-warning" title="Editar"><i class="bi bi-pencil"></i></a>
                            <a href="<?php echo BASE_URL; ?>/tarefas/delete/<?php echo $tarefa['id']; ?>" class="btn btn-sm btn-danger" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir esta tarefa?');"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php require_once VIEW_PATH . 'layout/footer.php'; ?>
