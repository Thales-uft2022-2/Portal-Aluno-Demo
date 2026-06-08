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

$id = $_GET['id'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $carga_horaria = $_POST['carga_horaria'];
    $descricao = $_POST['descricao'];

    $stmt = $pdo->prepare("
    UPDATE disciplinas
    SET
        nome = ?,
        carga_horaria = ?,
        descricao = ?
    WHERE id = ?
    ");

    $stmt->execute([
        $nome,
        $carga_horaria,
        $descricao,
        $id
    ]);

    header("Location: disciplinas.php");
    exit;
}

$stmt = $pdo->prepare("
SELECT *
FROM disciplinas
WHERE id = ?
");

$stmt->execute([$id]);

$disciplina = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

<meta charset="UTF-8">

<title>Editar Disciplina</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<div class="card p-4">

<h2>✏️ Editar Disciplina</h2>

<form method="POST">

<input
type="hidden"
name="id"
value="<?= $disciplina['id']; ?>">

<input
type="text"
name="nome"
class="form-control mb-3"
value="<?= htmlspecialchars($disciplina['nome']); ?>"
required>

<input
type="number"
name="carga_horaria"
class="form-control mb-3"
value="<?= $disciplina['carga_horaria']; ?>"
required>

<textarea
name="descricao"
class="form-control mb-3"
rows="5"><?= htmlspecialchars($disciplina['descricao']); ?></textarea>

<button class="btn btn-primary">

Salvar Alterações

</button>

<a href="disciplinas.php"
class="btn btn-secondary">

Cancelar

</a>

</form>

</div>

</div>

</body>

</html>