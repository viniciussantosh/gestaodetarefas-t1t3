<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Tarefas - <?php echo date('d/m/Y'); ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { text-align: center; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .status-concluida { background-color: #d4edda; }
        .status-pendente { background-color: #f8d7da; }
        .status-progresso { background-color: #fff3cd; }
    </style>
</head>
<body>

    <h1>Relatório Detalhado de Tarefas</h1>
    <p><strong>Usuário:</strong> <?php echo $_SESSION['usuario_nome'] ?? 'Desconhecido'; ?></p>
    <p><strong>Data de Geração:</strong> <?php echo date('d/m/Y H:i:s'); ?></p>

    <table>
        <thead>
            <tr>
                <th>Título</th>
                <th>Descrição</th>
                <th>Vencimento</th>
                <th>Prioridade</th>
                <th>Status</th>
                <th>Criação</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($tarefas)): ?>
                <tr>
                    <td colspan="6" style="text-align: center;">Nenhuma tarefa encontrada.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($tarefas as $tarefa): ?>
                    <?php 
                        $class = '';
                        if ($tarefa['status'] === 'Concluída') $class = 'status-concluida';
                        if ($tarefa['status'] === 'Pendente') $class = 'status-pendente';
                        if ($tarefa['status'] === 'Em Progresso') $class = 'status-progresso';
                    ?>
                    <tr class="<?php echo $class; ?>">
                        <td><?php echo htmlspecialchars($tarefa['titulo']); ?></td>
                        <td><?php echo htmlspecialchars($tarefa['descricao']); ?></td>
                        <td><?php echo $tarefa['data_vencimento'] ? date('d/m/Y', strtotime($tarefa['data_vencimento'])) : 'N/A'; ?></td>
                        <td><?php echo $tarefa['prioridade']; ?></td>
                        <td><?php echo $tarefa['status']; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($tarefa['data_criacao'])); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>
