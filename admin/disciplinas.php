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

$stmt = $pdo->query("
SELECT *
FROM disciplinas
ORDER BY nome
");

$disciplinas = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

<meta charset="UTF-8">

<title>Disciplinas</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<div class="d-flex justify-content-between mb-4">

<h2>📚 Disciplinas</h2>

<a href="cadastrar-disciplina.php"
class="btn btn-success">

➕ Nova Disciplina

</a>

 <a href="dashboard.php" class="btn btn-secondary">
            ⬅ Voltar ao Painel
        </a>

</div>

<table class="table table-bordered">

<thead class="table-dark">

<tr>

<th>ID</th>
<th>Disciplina</th>
<th>Carga Horária</th>
<th>Ações</th>

</tr>

</thead>

<tbody>

<?php foreach($disciplinas as $disciplina): ?>

<tr>

<td><?= $disciplina['id']; ?></td>

<td><?= htmlspecialchars($disciplina['nome']); ?></td>

<td><?= $disciplina['carga_horaria']; ?>h</td>

<td>

<a href="editar-disciplina.php?id=<?= $disciplina['id']; ?>"
class="btn btn-warning btn-sm">

Editar

</a>

<a href="excluir-disciplina.php?id=<?= $disciplina['id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Excluir disciplina?')">

Excluir

</a>

</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>

</body>

</html>