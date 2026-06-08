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

    $titulo = $_POST['titulo'];
    $mensagem = $_POST['mensagem'];

    $stmt = $pdo->prepare("
    INSERT INTO avisos (
        titulo,
        mensagem
    )
    VALUES (
        ?, ?
    )
    ");

    $stmt->execute([
        $titulo,
        $mensagem
    ]);

    header("Location: avisos.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

<meta charset="UTF-8">

<title>Publicar Aviso</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<div class="card p-4">

<h2>📢 Publicar Aviso</h2>

<form method="POST">

<input
type="text"
name="titulo"
class="form-control mb-3"
placeholder="Título do aviso"
required>

<textarea
name="mensagem"
class="form-control mb-3"
rows="6"
placeholder="Mensagem do aviso"
required></textarea>

<button
class="btn btn-success">

Publicar Aviso

</button>

<a href="avisos.php"
class="btn btn-secondary">

Cancelar

</a>

</form>

</div>

</div>

</body>

</html>