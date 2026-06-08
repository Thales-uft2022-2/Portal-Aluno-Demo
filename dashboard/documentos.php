<?php

session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../auth/login.php");
    exit;
}

require_once "../config/database.php";

$sql = "
SELECT *
FROM documentos
WHERE usuario_id = ?
ORDER BY criado_em DESC
";

$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION["usuario_id"]]);

$documentos = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<h2>📄 Meus Documentos</h2>

<table class="table">

<tr>
    <th>Documento</th>
    <th>Download</th>
</tr>

<?php foreach($documentos as $doc): ?>

<tr>

    <td>
        <?= htmlspecialchars($doc['nome_arquivo']) ?>
    </td>

    <td>

        <a
            href="../uploads/documentos/<?= htmlspecialchars($doc['caminho']) ?>"
            class="btn btn-primary">

            Baixar

        </a>

    </td>

</tr>

<?php endforeach; ?>

</table>