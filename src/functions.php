<?php
function pdo_connect_pgsql()
{
    $DATABASE_HOST = 'localhost';
    $DATABASE_PORT = '5432';
    $DATABASE_USER = 'postgres';
    $DATABASE_PASS = 'postgres';
    $DATABASE_NAME = 'gerenciamentotarefas';
    try {
        $pdo = new PDO('pgsql:host=' . $DATABASE_HOST . ';port=' . $DATABASE_PORT . ';dbname=' . $DATABASE_NAME . ';user=' . $DATABASE_USER . ';password=' . $DATABASE_PASS);
        // Define o modo de erro para Exception para que os erros sejam lançados e possam ser capturados.
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $exception) {
        // Log do erro ou exibição de mensagem mais detalhada.
        $errorDetails = 'Error details: ' . $exception->getMessage() . ' Code: ' . $exception->getCode();
        error_log('Failed to connect to database: ' . $errorDetails);
        exit('Failed to connect to database. Check error log for details. Debug: ' . $errorDetails);
    }
}

function template_head($title)
{
    echo <<<EOT
		<meta charset="utf-8">
		<title>$title</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="style.css" rel="stylesheet" type="text/css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,200..800&display=swap" rel="stylesheet">
EOT;
}

function template_header()
{
    echo <<<EOT
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="#">MovelCar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Início</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="listaCarros.php">Cadastro de usuários</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="listaCarros.php">Cadastro de tarefas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="indexAdmin.php">Gerenciar tarefas</a>
                </li>
            </ul>
        </div>
    </nav>
EOT;
}