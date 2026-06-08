<?php

session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

if (
    $_SESSION['tipo'] !== 'admin' &&
    $_SESSION['tipo'] !== 'professor'
) {
    header("Location: ../auth/login.php");
    exit;
}

require_once "../config/database.php";

$stmt = $pdo->query("
    SELECT *
    FROM avisos
    ORDER BY id DESC
");

$avisos = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Gerenciar Avisos</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>📢 Avisos</h2>

        <div>

            <a href="dashboard.php" class="btn btn-secondary">
                ⬅ Voltar ao Painel
            </a>

            <a href="cadastrar-aviso.php" class="btn btn-success">
                ➕ Novo Aviso
            </a>

        </div>

    </div>

    <table class="table table-bordered table-hover">

        <thead class="table-dark">

            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Data</th>
                <th>Ações</th>
            </tr>

        </thead>

        <tbody>

        <?php foreach ($avisos as $aviso): ?>

            <tr>

                <td><?= $aviso['id']; ?></td>

                <td><?= htmlspecialchars($aviso['titulo']); ?></td>

                <td>
                    <?= isset($aviso['data_publicacao']) ? $aviso['data_publicacao'] : '-'; ?>
                </td>

                <td>

                    <a href="editar-aviso.php?id=<?= $aviso['id']; ?>"
                       class="btn btn-warning btn-sm">
                        Editar
                    </a>

                    <a href="excluir-aviso.php?id=<?= $aviso['id']; ?>"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Deseja excluir este aviso?')">
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