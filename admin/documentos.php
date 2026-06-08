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

/* Upload */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $usuario_id = $_POST['usuario_id'];

    if(isset($_FILES['arquivo'])){

        $arquivo = $_FILES['arquivo'];

        $nomeOriginal = $arquivo['name'];

        $novoNome = time() . "_" . $nomeOriginal;

        $destino = "../uploads/documentos/" . $novoNome;

        move_uploaded_file(
            $arquivo['tmp_name'],
            $destino
        );

        $stmt = $pdo->prepare("
        INSERT INTO documentos (
            usuario_id,
            nome_arquivo,
            caminho
        )
        VALUES (
            ?, ?, ?
        )
        ");

        $stmt->execute([
            $usuario_id,
            $nomeOriginal,
            $novoNome
        ]);
    }
}

$alunos = $pdo->query("
SELECT id,nome
FROM usuarios
WHERE tipo='aluno'
ORDER BY nome
")->fetchAll();

$documentos = $pdo->query("
SELECT
d.*,
u.nome

FROM documentos d

INNER JOIN usuarios u
ON u.id = d.usuario_id

ORDER BY d.criado_em DESC
")->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>

<head>

<title>Documentos</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<div class="card p-4 mb-4">

<h2>📄 Enviar Documento</h2>

<a href="dashboard.php" class="btn btn-secondary">
        ⬅ Voltar ao Painel
    </a>

<form
method="POST"
enctype="multipart/form-data">

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

<input
type="file"
name="arquivo"
class="form-control mb-3"
required>

<button
class="btn btn-success">

Enviar Documento

</button>

</form>

</div>

<div class="card p-4">

<h3>Documentos Enviados</h3>

<table class="table">

<tr>

<th>Aluno</th>
<th>Documento</th>
<th>Data</th>

</tr>

<?php foreach($documentos as $doc): ?>

<tr>

<td>
<?= htmlspecialchars($doc['nome']); ?>
</td>

<td>
<?= htmlspecialchars($doc['nome_arquivo']); ?>
</td>

<td>
<?= date(
'd/m/Y H:i',
strtotime($doc['criado_em'])
); ?>
</td>

</tr>

<?php endforeach; ?>

</table>

</div>

</div>

</body>

</html>