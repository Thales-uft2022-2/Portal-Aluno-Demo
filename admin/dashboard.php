<?php

session_start();

if (
    !isset($_SESSION['usuario_id']) ||
    (
        $_SESSION['tipo'] !== 'admin' &&
        $_SESSION['tipo'] !== 'professor'
    )
) {
    header("Location: ../auth/login.php");
    exit;
}

require_once "../config/database.php";

/* Total de alunos */
$totalAlunos = $pdo->query("
    SELECT COUNT(*)
    FROM usuarios
    WHERE tipo = 'aluno'
")->fetchColumn();

/* Total de disciplinas */
$totalDisciplinas = $pdo->query("
    SELECT COUNT(*)
    FROM disciplinas
")->fetchColumn();

/* Total de avisos */
$totalAvisos = $pdo->query("
    SELECT COUNT(*)
    FROM avisos
")->fetchColumn();

/* Total de documentos */
$totalDocumentos = $pdo->query("
    SELECT COUNT(*)
    FROM documentos
")->fetchColumn();

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-5">

        <div>
            <h2>Painel Administrativo</h2>

            <p>
                Bem-vindo,
                <?php echo htmlspecialchars($_SESSION['nome']); ?>
            </p>
        </div>

        <a href="../auth/logout.php" class="btn btn-danger">
            Sair
        </a>

    </div>

    <div class="row g-4">

        <div class="col-md-3">
            <div class="card p-4 text-center">
                <h1>👥</h1>
                <h3><?php echo $totalAlunos; ?></h3>
                <p>Alunos</p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-4 text-center">
                <h1>📚</h1>
                <h3><?php echo $totalDisciplinas; ?></h3>
                <p>Disciplinas</p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-4 text-center">
                <h1>📢</h1>
                <h3><?php echo $totalAvisos; ?></h3>
                <p>Avisos</p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-4 text-center">
                <h1>📄</h1>
                <h3><?php echo $totalDocumentos; ?></h3>
                <p>Documentos</p>
            </div>
        </div>

    </div>

    <hr class="my-5">

    <div class="row g-3">

        <div class="col-md-4">
            <a href="alunos.php" class="btn btn-primary w-100">
                👥 Gerenciar Alunos
            </a>
        </div>

        <div class="col-md-4">
            <a href="disciplinas.php" class="btn btn-success w-100">
                📚 Disciplinas
            </a>
        </div>

        <div class="col-md-4">
            <a href="notas.php" class="btn btn-warning w-100">
                📝 Notas
            </a>
        </div>

        <div class="col-md-4">
            <a href="frequencias.php" class="btn btn-info w-100">
                📅 Frequência
            </a>
        </div>

        <div class="col-md-4">
            <a href="avisos.php" class="btn btn-secondary w-100">
                📢 Avisos
            </a>
        </div>

        <div class="col-md-4">
            <a href="documentos.php" class="btn btn-dark w-100">
                📄 Documentos
            </a>
        </div>

    </div>

</div>

</body>
</html>