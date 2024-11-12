<?php
include 'functions.php';

// Conectar ao banco de dados PostgreSQL
$pdo = pdo_connect_pgsql();
$offset = 0; // Defina o valor apropriado para o offset
$limit = 10; // Defina o valor apropriado para o limit

$sql = 'SELECT tarefas.id_tarefa, usuarios.nome AS usuario_nome, tarefas.titulo, tarefas.descricao, tarefas.status, tarefas.grau_importancia 
        FROM tarefas
        INNER JOIN usuarios ON tarefas.id_usuario = usuarios.id_usuario 
        ORDER BY tarefas.grau_importancia DESC OFFSET :offset LIMIT :limit';

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->execute();
$tarefas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Função para comparar a importância das tarefas
function compararImportancia($a, $b) {
    $importancia = ['Alta' => 3, 'Média' => 2, 'Baixa' => 1];
    return $importancia[$b['grau_importancia']] - $importancia[$a['grau_importancia']];
}

// Agrupar tarefas por status e ordenar pelo grau de importância
$tarefas_por_status = ['A fazer' => [], 'Fazendo' => [], 'Pronto' => []];
foreach ($tarefas as $tarefa) {
    $tarefas_por_status[$tarefa['status']][] = $tarefa;
}
foreach ($tarefas_por_status as &$tarefas) {
    usort($tarefas, 'compararImportancia');
}

// Obter o número total de registros
$num_tarefas = $pdo->query('SELECT COUNT(*) FROM tarefas')->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?= template_head("Listar tarefas") ?>
    <style>
        .status-container-wrapper {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 30px;
        }

        .status-header {
            font-size: 1.5em;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .card-header {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .card-actions {
            margin-top: 15px;
        }

        .card-container {
            display: block; /* Exibição vertical de cada card */
        }
    </style>
</head>

<body>
    <?= template_header() ?>
    <div class="content col-12 listar justify-content-center">
        <div class="status-container-wrapper">
            <?php foreach (['A fazer', 'Fazendo', 'Pronto'] as $status) : ?>
                <?php if (isset($tarefas_por_status[$status])) : ?>
                    <div class="status-container">
                        <div class="status-header"><?= htmlspecialchars($status) ?></div>
                        <div class="card-container">
                            <?php foreach ($tarefas_por_status[$status] as $tarefa) : ?>
                                <div class="card">
                                    <div class="card-header"><?= htmlspecialchars($tarefa['titulo']) ?></div>
                                    <div><strong>Descrição:</strong> <?= htmlspecialchars($tarefa['descricao']) ?></div>
                                    <div><strong>Grau de Importância:</strong> <?= htmlspecialchars($tarefa['grau_importancia']) ?></div>
                                    <div><strong>Status:</strong>
                                        <!-- Select para editar o status -->
                                        <form action="editarStatusTarefa.php" method="post">
                                            <select name="status" class="form-control">
                                                <option value="A fazer" <?= ($tarefa['status'] == 'A fazer') ? 'selected' : '' ?>>A fazer</option>
                                                <option value="Fazendo" <?= ($tarefa['status'] == 'Fazendo') ? 'selected' : '' ?>>Fazendo</option>
                                                <option value="Pronto" <?= ($tarefa['status'] == 'Pronto') ? 'selected' : '' ?>>Pronto</option>
                                            </select>
                                    </div>
                                    <div><strong>Vinculado a:</strong> <?= htmlspecialchars($tarefa['usuario_nome']) ?></div>
                                    <div class="card-actions">
                                        <!-- Botão para salvar a edição do status -->
                                        <input type="hidden" name="id_tarefa" value="<?= $tarefa['id_tarefa'] ?>">
                                        <button type="submit" class="btn btn-primary">Salvar</button>
                                        </form>
                                        <a href="editarTarefa.php?id_tarefa=<?= $tarefa['id_tarefa'] ?>" class="btn btn-secondary">Editar</a>
                                        <a href="excluirTarefa.php?id_tarefa=<?= $tarefa['id_tarefa'] ?>" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta tarefa?');">Excluir</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>
