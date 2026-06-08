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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = $_POST['nome'];
    $carga_horaria = $_POST['carga_horaria'];
    $descricao = $_POST['descricao'];

    $stmt = $pdo->prepare("
    INSERT INTO disciplinas
    (
        nome,
        carga_horaria,
        descricao
    )
    VALUES
    (
        ?, ?, ?
    )
    ");

    $stmt->execute([
        $nome,
        $carga_horaria,
        $descricao
    ]);

    header("Location: disciplinas.php");
    exit;
}

?>

<!DOCTYPE html>
<html>

<head>

<title>Nova Disciplina</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<div class="card p-4">

<h2>➕ Nova Disciplina</h2>

<form method="POST">

<input
type="text"
name="nome"
class="form-control mb-3"
placeholder="Nome da disciplina"
required>

<input
type="number"
name="carga_horaria"
class="form-control mb-3"
placeholder="Carga horária"
required>

<textarea
name="descricao"
class="form-control mb-3"
placeholder="Descrição"></textarea>

<button class="btn btn-success">

Salvar

</button>

</form>

</div>

</div>

</body>

</html>