<?php

session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../auth/login.php");
    exit;
}

require_once "../config/database.php";

$sql = "SELECT * FROM avisos ORDER BY data_publicacao DESC";
$stmt = $pdo->query($sql);
$avisos = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<h2>📢 Avisos</h2>

<?php foreach($avisos as $aviso): ?>

<div class="card p-3 mb-3">

    <h4><?= htmlspecialchars($aviso['titulo']) ?></h4>

    <p><?= nl2br(htmlspecialchars($aviso['mensagem'])) ?></p>

    <small>
        <?= date('d/m/Y H:i', strtotime($aviso['data_publicacao'])) ?>
    </small>

</div>

<?php endforeach; ?>