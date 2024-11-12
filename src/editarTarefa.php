<?php
include 'functions.php';
$pdo = pdo_connect_pgsql();
$msg = '';

// Verifica se o ID da tarefa existe na URL
if (isset($_GET['id_tarefa']) && !empty($_GET['id_tarefa'])) {
    // O ID da tarefa foi passado corretamente
    $id_tarefa = $_GET['id_tarefa'];
    $titulo = isset($_POST['titulo']) ? $_POST['titulo'] : '';
    $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : '';
    $grau_importancia = isset($_POST['grau_importancia']) ? $_POST['grau_importancia'] : '';
    $status = isset($_POST['status']) ? $_POST['status'] : '';

    try {
        // Tenta obter a tarefa com o ID fornecido
        $stmt = $pdo->prepare('SELECT * FROM tarefas WHERE id_tarefa = ?');
        $stmt->execute([$id_tarefa]);
        $tarefa = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$tarefa) {
            exit('Tarefa não localizada!');
        }

        // Se o formulário for enviado, realiza a atualização
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Atualiza a tarefa com os dados enviados no formulário
            $stmt = $pdo->prepare('UPDATE tarefas SET titulo = ?, descricao = ?, grau_importancia = ?, status = ? WHERE id_tarefa = ?');
            $stmt->execute([$titulo, $descricao, $grau_importancia, $status, $id_tarefa]);
            $msg = 'Tarefa atualizada com sucesso!';
            // Redireciona para a página de gerenciamento de tarefas após a atualização
            header('Location: gerenciaTarefas.php');
            exit();
        }
    } catch (Exception $e) {
        $msg = 'Erro ao atualizar tarefa: ' . $e->getMessage();
    }
} else {
    exit('Nenhuma tarefa especificada!');
}
?>

<head>
    <?= template_head("Edição de tarefa") ?>
</head>

<body>
    <?= template_header() ?>
    <div class="content update">
        <h1 style="margin: 0px auto; width: 100%; text-align: center; margin-top: 80px;">Editar Tarefa</h1>
        <?php if ($msg): ?>
            <div class="alert alert-info" role="alert">
                <?= $msg ?>
            </div>
        <?php endif; ?>
        <form action="editarTarefa.php?id_tarefa=<?= $tarefa['id_tarefa'] ?>" method="POST">
            <div class="form-group col-3">
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" placeholder="Título" class="form-control" value="<?= $tarefa['titulo'] ?>" required>
            </div>
            <div class="form-group col-3">
                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" placeholder="Descrição" class="form-control" required><?= $tarefa['descricao'] ?></textarea>
            </div>
            <div class="form-group col-3">
                <label for="grau_importancia">Grau de Importância:</label>
                <select class="form-select" name="grau_importancia" id="grau_importancia" required>
                    <option value="Baixa" <?= ($tarefa['grau_importancia'] == 'Baixa') ? 'selected' : '' ?>>Baixa</option>
                    <option value="Média" <?= ($tarefa['grau_importancia'] == 'Média') ? 'selected' : '' ?>>Média</option>
                    <option value="Alta" <?= ($tarefa['grau_importancia'] == 'Alta') ? 'selected' : '' ?>>Alta</option>
                </select>
            </div>
            <div class="form-group col-3">
                <label for="status">Status:</label>
                <select class="form-select" name="status" id="status" required>
                    <option value="A fazer" <?= ($tarefa['status'] == 'A fazer') ? 'selected' : '' ?>>A fazer</option>
                    <option value="Fazendo" <?= ($tarefa['status'] == 'Fazendo') ? 'selected' : '' ?>>Fazendo</option>
                    <option value="Pronto" <?= ($tarefa['status'] == 'Pronto') ? 'selected' : '' ?>>Pronto</option>
                </select>
            </div>
            <div class="form-group col-3 rowButtons">
                <input type="submit" value="Editar" class="btn btn-primary">
            </div>
        </form>
    </div>
</body>

</html>
