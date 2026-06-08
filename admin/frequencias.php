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

/* Salvar frequência */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $usuario_id = $_POST['usuario_id'];
    $disciplina_id = $_POST['disciplina_id'];

    $aulas_total = $_POST['aulas_total'];
    $presencas = $_POST['presencas'];
    $faltas = $_POST['faltas'];

    $verifica = $pdo->prepare("
        SELECT id
        FROM frequencias
        WHERE usuario_id = ?
        AND disciplina_id = ?
    ");

    $verifica->execute([
        $usuario_id,
        $disciplina_id
    ]);

    $registro = $verifica->fetch(PDO::FETCH_ASSOC);

    if ($registro) {

        $update = $pdo->prepare("
            UPDATE frequencias
            SET
                aulas_total = ?,
                presencas = ?,
                faltas = ?
            WHERE id = ?
        ");

        $update->execute([
            $aulas_total,
            $presencas,
            $faltas,
            $registro['id']
        ]);

    } else {

        $insert = $pdo->prepare("
            INSERT INTO frequencias (
                usuario_id,
                disciplina_id,
                aulas_total,
                presencas,
                faltas
            )
            VALUES (
                ?, ?, ?, ?, ?
            )
        ");

        $insert->execute([
            $usuario_id,
            $disciplina_id,
            $aulas_total,
            $presencas,
            $faltas
        ]);
    }
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

/* Lista de frequências */

$listaFrequencias = $pdo->query("
    SELECT
        f.*,
        u.nome AS aluno,
        d.nome AS disciplina
    FROM frequencias f
    INNER JOIN usuarios u
        ON u.id = f.usuario_id
    INNER JOIN disciplinas d
        ON d.id = f.disciplina_id
    ORDER BY u.nome
")->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

<meta charset="UTF-8">

<title>Controle de Frequência</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<div class="card p-4">

<h2 class="mb-3">📅 Controle de Frequência</h2>

<a href="dashboard.php" class="btn btn-secondary mb-4">
    ⬅ Voltar ao Painel
</a>

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
name="aulas_total"
class="form-control mb-3"
placeholder="Total de aulas"
required>

<input
type="number"
name="presencas"
class="form-control mb-3"
placeholder="Presenças"
required>

<input
type="number"
name="faltas"
class="form-control mb-3"
placeholder="Faltas"
required>

<button class="btn btn-success">
Salvar Frequência
</button>

</form>

<hr class="my-4">

<h3>📋 Frequências Lançadas</h3>

<table class="table table-bordered table-hover">

<thead class="table-dark">

<tr>
    <th>Aluno</th>
    <th>Disciplina</th>
    <th>Total Aulas</th>
    <th>Presenças</th>
    <th>Faltas</th>
    <th>Frequência</th>
</tr>

</thead>

<tbody>

<?php foreach($listaFrequencias as $freq): ?>

<tr>

<td>
<?= htmlspecialchars($freq['aluno']); ?>
</td>

<td>
<?= htmlspecialchars($freq['disciplina']); ?>
</td>

<td>
<?= $freq['aulas_total']; ?>
</td>

<td>
<?= $freq['presencas']; ?>
</td>

<td>
<?= $freq['faltas']; ?>
</td>

<td>

<?php

if ($freq['aulas_total'] > 0) {

    echo round(
        ($freq['presencas'] / $freq['aulas_total']) * 100,
        1
    ) . "%";

} else {

    echo "0%";

}

?>

</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>

</div>

</body>

</html>