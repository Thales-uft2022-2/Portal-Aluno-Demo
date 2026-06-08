<?php

session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../auth/login.php");
    exit;
}

require_once "../config/database.php";

$stmt = $pdo->prepare("
    SELECT
        nome,
        matricula,
        curso
    FROM usuarios
    WHERE id = ?
");

$stmt->execute([$_SESSION["usuario_id"]]);

$aluno = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Meu Curso</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

    <div class="d-flex justify-content-between mb-4">

        <h2>📚 Meu Curso</h2>

        <a href="dashboard.php" class="btn btn-secondary">
            ⬅ Voltar
        </a>

    </div>

    <div class="card p-4">

        <h4>Aluno</h4>
        <p><?= htmlspecialchars($aluno['nome']) ?></p>

        <hr>

        <h4>Matrícula</h4>
        <p><?= htmlspecialchars($aluno['matricula']) ?></p>

        <hr>

        <h4>Curso</h4>
        <p>
            <?= htmlspecialchars($aluno['curso']) ?>
        </p>

    </div>

</div>

</body>

</html>