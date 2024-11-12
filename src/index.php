<?php
include 'functions.php';
$pdo = pdo_connect_pgsql();
$msg = '';
// Verifica se os dados POST não estão vazios
if (!empty($_POST)) {
    // Se os dados POST não estiverem vazios, insere um novo registro
    $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    
    // Insere um novo registro na tabela usuarios
    try {
        $stmt = $pdo->prepare('INSERT INTO usuarios (nome, email) VALUES (?, ?)');
        $stmt->execute([$nome, $email]);
        $msg = 'Usuário cadastrado com Sucesso!';
    } catch (Exception $e) {
        $msg = 'Erro ao cadastrar usuário: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?= template_head("Cadastro de usuário") ?>
</head>

<body>
    <?= template_header()?>
    <div class="container" id="register">
        <h2 class="text-center my-4">Cadastro de usuário</h2>
        <?php if ($msg): ?>
            <div class="alert alert-info" role="alert">
                <?= $msg ?>
            </div>
        <?php endif; ?>
        <form class="form-group justify-content-center" action="index.php" method="POST">
            <div class="form-group">
                <label for="nome">Nome completo:</label>
                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome completo" required>
            </div>
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="E-mail" required>
            <div class="rowButtons">
                <input type="submit" class="btn btn-primary" value="Cadastrar">
            </div>
        </form>
    </div>
</body>

</html>