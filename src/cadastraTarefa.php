<?php
include 'functions.php';
$pdo = pdo_connect_pgsql();
$msg = '';

$usuarios = $pdo->query('SELECT id_usuario, nome FROM usuarios')->fetchAll(PDO::FETCH_ASSOC);

if (!empty($_POST)) {
    $titulo = isset($_POST['titulo']) ? $_POST['titulo'] : '';
    $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : '';
    $grau_importancia = isset($_POST['grau_importancia']) ? $_POST['grau_importancia'] : '';
    $status = isset($_POST['status']) ? $_POST['status'] : '';
    $id_usuario = isset($_POST['id_usuario']) ? $_POST['id_usuario'] : '';


    try {
        $stmt = $pdo->prepare('INSERT INTO tarefas (titulo, descricao, grau_importancia, status, id_usuario) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$titulo, $descricao, $grau_importancia, $status, $id_usuario]);
        $msg = 'Tarefa cadastrada com sucesso!';
    } catch (Exception $e) {
        $msg = $e;
    }
}
?>

<head>
    <?= template_head("Cadastro de tarefas") ?>
</head>

<body>
    <?= template_header()?>
    <div class="content update">
        <h1 style="margin: 0px auto; width: 100%; text-align: center; margin-top: 80px;">Cadastrar tarefa</h1>
        <?php if ($msg): ?>
            <div class="alert alert-info" role="alert">
                <?= $msg ?>
            </div>
        <?php endif; ?>
        <form action="cadastraTarefa.php" method="POST">
            <div class="form-group col-3">
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" placeholder="Título" class="form-control" required>
            </div>
            <div class="form-group col-3">
            <label for="descricao">Descrição:</label>
                <input type="text" id="descricao" name="descricao" placeholder="Descrição" class="form-control" required>
            </div>
            <div class="form-group col-3">
                <label for="grau_importancia">Grau de importância:</label>
                <select class="form-select" name="grau_importancia" id="grau_importancia" required>
                    <option value="Baixa">Baixa</option>
                    <option value="Média">Média</option>
                    <option value="Alta">Alta</option>
                </select>
            </div>
            <div class="form-group col-3">
            <label for="status">Status:</label>
                <select class="form-select" name="status" id="status" required>
                    <option value="A fazer">A fazer</option>
                    <option value="Fazendo">Fazendo</option>
                    <option value="Pronto">Pronto</option>
                </select>
            </div>
            <div class="form-group col-3">
                <label for="id_usuario">ID do Usuário:</label>
                <select class="form-select" name="id_usuario" id="id_usuario" required>
                    <option value="">Selecione um usuario</option>
                    <?php foreach ($usuarios as $usuario) : ?>
                        <option value="<?= $usuario['id_usuario'] ?>"><?= $usuario['nome'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group col-3 rowButtons">
                <input type="submit" value="Cadastrar" class="btn btn-primary">
            </div>
        </form>
    </div>
</body>

</html>