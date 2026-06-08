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

/* Salvar Nota */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $usuario_id = $_POST['usuario_id'];
    $disciplina_id = $_POST['disciplina_id'];

    $nota1 = floatval($_POST['nota1']);
    $nota2 = floatval($_POST['nota2']);
    $nota3 = floatval($_POST['nota3']);

    $media = ($nota1 + $nota2 + $nota3) / 3;

    if ($media >= 7) {

        $situacao = 'Aprovado';

    } elseif ($media >= 5) {

        $situacao = 'Recuperacao';

    } else {

        $situacao = 'Reprovado';

    }

    $stmt = $pdo->prepare("
        INSERT INTO notas (
            usuario_id,
            disciplina_id,
            nota1,
            nota2,
            nota3,
            media,
            situacao
        )
        VALUES (
            ?, ?, ?, ?, ?, ?, ?
        )
    ");

    $stmt->execute([
        $usuario_id,
        $disciplina_id,
        $nota1,
        $nota2,
        $nota3,
        $media,
        $situacao
    ]);
}

/* Alunos */

$alunos = $pdo->query("
    SELECT id,nome
    FROM usuarios
    WHERE tipo='aluno'
    ORDER BY nome
")->fetchAll(PDO::FETCH_ASSOC);

/* Disciplinas */

$disciplinas = $pdo->query("
    SELECT id,nome
    FROM disciplinas
    ORDER BY nome
")->fetchAll(PDO::FETCH_ASSOC);

/* Notas */

$listaNotas = $pdo->query("
    SELECT
        n.*,
        u.nome AS aluno,
        d.nome AS disciplina
    FROM notas n
    INNER JOIN usuarios u
        ON u.id = n.usuario_id
    INNER JOIN disciplinas d
        ON d.id = n.disciplina_id
    ORDER BY n.id DESC
")->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

<meta charset="UTF-8">

<title>Lançamento de Notas</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<div class="card p-4">

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2>📝 Lançamento de Notas</h2>

    <a href="dashboard.php" class="btn btn-secondary">
        ⬅ Voltar ao Painel
    </a>

</div>

<form method="POST">

<select
name="usuario_id"
class="form-select mb-3"
required>

<option value="">
Selecione o aluno
</option>

<?php foreach($alunos as $aluno): ?>

<option value="<?= $aluno['id']; ?>">
    <?= htmlspecialchars($aluno['nome']); ?>
</option>

<?php endforeach; ?>

</select>

<select
name="disciplina_id"
class="form-select mb-3"
required>

<option value="">
Selecione a disciplina
</option>

<?php foreach($disciplinas as $disciplina): ?>

<option value="<?= $disciplina['id']; ?>">
    <?= htmlspecialchars($disciplina['nome']); ?>
</option>

<?php endforeach; ?>

</select>

<input
type="number"
step="0.01"
name="nota1"
class="form-control mb-3"
placeholder="Nota 1"
required>

<input
type="number"
step="0.01"
name="nota2"
class="form-control mb-3"
placeholder="Nota 2"
required>

<input
type="number"
step="0.01"
name="nota3"
class="form-control mb-3"
placeholder="Nota 3"
required>

<button
class="btn btn-success">

Salvar Notas

</button>

</form>

<hr class="my-4">

<h3>📋 Notas Lançadas</h3>

<table class="table table-bordered table-hover">

<thead class="table-dark">

<tr>

    <th>Aluno</th>
    <th>Disciplina</th>
    <th>Nota 1</th>
    <th>Nota 2</th>
    <th>Nota 3</th>
    <th>Média</th>
    <th>Situação</th>
    <th>Ações</th>

</tr>

</thead>

<tbody>

<?php foreach($listaNotas as $nota): ?>

<tr>

    <td><?= htmlspecialchars($nota['aluno']); ?></td>

    <td><?= htmlspecialchars($nota['disciplina']); ?></td>

    <td><?= $nota['nota1']; ?></td>

    <td><?= $nota['nota2']; ?></td>

    <td><?= $nota['nota3']; ?></td>

    <td><?= number_format($nota['media'], 2, ',', '.'); ?></td>

    <td>

        <?php if($nota['situacao'] == 'Aprovado'): ?>

            <span class="badge bg-success">
                Aprovado
            </span>

        <?php elseif($nota['situacao'] == 'Recuperacao'): ?>

            <span class="badge bg-warning text-dark">
                Recuperação
            </span>

        <?php else: ?>

            <span class="badge bg-danger">
                Reprovado
            </span>

        <?php endif; ?>

    </td>

    <td>

        <a
            href="editar-nota.php?id=<?= $nota['id']; ?>"
            class="btn btn-warning btn-sm">

            ✏️ Editar

        </a>

        <!--a
            href="excluir-nota.php?id=<?= $nota['id']; ?>"
            class="btn btn-danger btn-sm"
            onclick="return confirm('Deseja excluir esta nota?')">

            🗑 Excluir

        </a-->

    </td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>

</div>

</body>

</html>