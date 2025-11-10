<?php 
// Inicia a sessão para usar o $_SESSION
session_start();
require_once VIEW_PATH . 'layout/header.php'; 

$is_edit = isset($tarefa) && $tarefa;
$action_url = BASE_URL . '/tarefas/save';
$titulo_form = $is_edit ? 'Editar Tarefa' : 'Nova Tarefa';

// Valores padrão
$id = $is_edit ? $tarefa['id'] : '';
$titulo_val = $is_edit ? htmlspecialchars($tarefa['titulo']) : '';
$descricao_val = $is_edit ? htmlspecialchars($tarefa['descricao']) : '';
$data_vencimento_val = $is_edit ? $tarefa['data_vencimento'] : '';
$prioridade_val = $is_edit ? $tarefa['prioridade'] : 'Média';
$status_val = $is_edit ? $tarefa['status'] : 'Pendente';

?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="text-center"><?php echo $titulo_form; ?></h3>
            </div>
            <div class="card-body">
                <form action="<?php echo $action_url; ?>" method="POST">
                    <?php if ($is_edit): ?>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <?php endif; ?>

                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo $titulo_val; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="3"><?php echo $descricao_val; ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="data_vencimento" class="form-label">Data de Vencimento</label>
                            <input type="date" class="form-control" id="data_vencimento" name="data_vencimento" value="<?php echo $data_vencimento_val; ?>">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="prioridade" class="form-label">Prioridade</label>
                            <select class="form-select" id="prioridade" name="prioridade" required>
                                <option value="Baixa" <?php echo $prioridade_val == 'Baixa' ? 'selected' : ''; ?>>Baixa</option>
                                <option value="Média" <?php echo $prioridade_val == 'Média' ? 'selected' : ''; ?>>Média</option>
                                <option value="Alta" <?php echo $prioridade_val == 'Alta' ? 'selected' : ''; ?>>Alta</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="Pendente" <?php echo $status_val == 'Pendente' ? 'selected' : ''; ?>>Pendente</option>
                                <option value="Em Progresso" <?php echo $status_val == 'Em Progresso' ? 'selected' : ''; ?>>Em Progresso</option>
                                <option value="Concluída" <?php echo $status_val == 'Concluída' ? 'selected' : ''; ?>>Concluída</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="<?php echo BASE_URL; ?>/tarefas/index" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-success"><?php echo $is_edit ? 'Salvar Alterações' : 'Criar Tarefa'; ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once VIEW_PATH . 'layout/footer.php'; ?>
