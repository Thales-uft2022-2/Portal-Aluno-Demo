<?php

session_start();

if (
    !isset($_SESSION['usuario_id']) ||
    (
        $_SESSION['tipo'] !== 'admin' &&
        $_SESSION['tipo'] !== 'professor'
    )
){
    header("Location: ../auth/login.php");
    exit;
}

require_once "../config/database.php";

$id = $_GET['id'] ?? 0;

$stmt = $pdo->prepare("
SELECT *
FROM notas
WHERE id = ?
");

$stmt->execute([$id]);

$nota = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$nota) {
    die("Nota não encontrada.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nota1 = $_POST['nota1'];
    $nota2 = $_POST['nota2'];
    $nota3 = $_POST['nota3'];

    $media = (
        $nota1 +
        $nota2 +
        $nota3
    ) / 3;

    if ($media >= 7) {

        $situacao = 'Aprovado';

    } elseif ($media >= 5) {

        $situacao = 'Recuperacao';

    } else {

        $situacao = 'Reprovado';

    }

    $update = $pdo->prepare("
    UPDATE notas
    SET
        nota1 = ?,
        nota2 = ?,
        nota3 = ?,
        media = ?,
        situacao = ?
    WHERE id = ?
    ");

    $update->execute([
        $nota1,
        $nota2,
        $nota3,
        $media,
        $situacao,
        $id
    ]);

    header("Location: notas.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

<meta charset="UTF-8">

<title>Editar Nota</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<div class="card p-4">

<h2>✏️ Editar Nota</h2>

<a href="notas.php" class="btn btn-secondary mb-3">
    ⬅ Voltar
</a>

<form method="POST">

<input
type="number"
step="0.01"
name="nota1"
class="form-control mb-3"
value="<?= $nota['nota1']; ?>"
required>

<input
type="number"
step="0.01"
name="nota2"
class="form-control mb-3"
value="<?= $nota['nota2']; ?>"
required>

<input
type="number"
step="0.01"
name="nota3"
class="form-control mb-3"
value="<?= $nota['nota3']; ?>"
required>

<button class="btn btn-primary">
    Salvar Alterações
</button>

</form>

</div>

</div>

</body>

</html>