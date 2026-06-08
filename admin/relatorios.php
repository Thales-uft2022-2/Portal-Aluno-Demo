<?php

session_start();

if (
    !isset($_SESSION['usuario_id']) ||
    $_SESSION['tipo'] !== 'admin' &&
    $_SESSION['tipo'] !== 'professor'
){
    header("Location: ../auth/login.php");
    exit;
}

require_once "../config/database.php";

$totalAlunos = $pdo->query("
SELECT COUNT(*)
FROM usuarios
WHERE tipo='aluno'
")->fetchColumn();

$totalDisciplinas = $pdo->query("
SELECT COUNT(*)
FROM disciplinas
")->fetchColumn();

$aprovados = $pdo->query("
SELECT COUNT(*)
FROM notas
WHERE situacao='Aprovado'
")->fetchColumn();

$recuperacao = $pdo->query("
SELECT COUNT(*)
FROM notas
WHERE situacao='Recuperacao'
")->fetchColumn();

$reprovados = $pdo->query("
SELECT COUNT(*)
FROM notas
WHERE situacao='Reprovado'
")->fetchColumn();

$mediaGeral = $pdo->query("
SELECT AVG(media)
FROM notas
")->fetchColumn();

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

<meta charset="UTF-8">

<title>Relatórios</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<h2 class="mb-4">
📊 Relatórios do Sistema
</h2>

<div class="row g-4">

<div class="col-md-4">

<div class="card p-4 text-center">

<h3><?= $totalAlunos ?></h3>

<p>Total de Alunos</p>

</div>

</div>

<div class="col-md-4">

<div class="card p-4 text-center">

<h3><?= $totalDisciplinas ?></h3>

<p>Total de Disciplinas</p>

</div>

</div>

<div class="col-md-4">

<div class="card p-4 text-center">

<h3><?= number_format($mediaGeral,2) ?></h3>

<p>Média Geral</p>

</div>

</div>

<div class="col-md-4">

<div class="card p-4 text-center">

<h3><?= $aprovados ?></h3>

<p>Aprovados</p>

</div>

</div>

<div class="col-md-4">

<div class="card p-4 text-center">

<h3><?= $recuperacao ?></h3>

<p>Recuperação</p>

</div>

</div>

<div class="col-md-4">

<div class="card p-4 text-center">

<h3><?= $reprovados ?></h3>

<p>Reprovados</p>

</div>

</div>

</div>

</div>

</body>

</html>