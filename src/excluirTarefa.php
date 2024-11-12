<?php
include 'functions.php';
$pdo = pdo_connect_pgsql();

// Verifica se o ID da tarefa existe
if (isset($_GET['id_tarefa'])) {
    try {
        // Exclui a tarefa do banco de dados
        $stmt = $pdo->prepare('DELETE FROM tarefas WHERE id_tarefa = ?');
        $stmt->execute([$_GET['id_tarefa']]);
        header('Location: gerenciaTarefas.php'); // Redireciona após a exclusão
        exit();
    } catch (Exception $e) {
        echo 'Erro ao excluir tarefa: ' . $e->getMessage();
    }
} else {
    exit('Nenhuma tarefa especificada!');
}
?>
