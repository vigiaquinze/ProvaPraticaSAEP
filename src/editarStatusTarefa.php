<?php
include 'functions.php';

// Conectar ao banco de dados PostgreSQL
$pdo = pdo_connect_pgsql();

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obter os dados do formulário
    $status = $_POST['status'];
    $id_tarefa = $_POST['id_tarefa'];

    // Atualizar o status da tarefa no banco de dados
    $sql = 'UPDATE tarefas SET status = :status WHERE id_tarefa = :id_tarefa';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':id_tarefa', $id_tarefa);
    $stmt->execute();

    // Redirecionar de volta para a página de listagem de tarefas
    header('Location: gerenciaTarefas.php');
    exit();
}
?>
