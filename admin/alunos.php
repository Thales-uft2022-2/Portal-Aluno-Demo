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

$sql = "
SELECT
    id,
    nome,
    cpf,
    matricula,
    curso,
    email,
    status
FROM usuarios
WHERE tipo = 'aluno'
ORDER BY nome
";

$stmt = $pdo->query($sql);
$alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Gerenciar Alunos</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>👥 Alunos Cadastrados</h2>

        <div>

            <a href="dashboard.php" class="btn btn-secondary">
                ⬅ Voltar
            </a>

            <a href="cadastrar-aluno.php" class="btn btn-success">
                ➕ Novo Aluno
            </a>

        </div>

    </div>

    <table class="table table-bordered table-hover">

        <thead class="table-dark">

            <tr>

                <th>ID</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>Matrícula</th>
                <th>Curso</th>
                <th>Email</th>
                <th>Status</th>
                <th>Ações</th>

            </tr>

        </thead>

        <tbody>

        <?php foreach ($alunos as $aluno): ?>

            <tr>

                <td><?= $aluno['id']; ?></td>

                <td><?= htmlspecialchars($aluno['nome']); ?></td>

                <td><?= htmlspecialchars($aluno['cpf']); ?></td>

                <td><?= htmlspecialchars($aluno['matricula']); ?></td>

                <td><?= htmlspecialchars($aluno['curso']); ?></td>

                <td><?= htmlspecialchars($aluno['email']); ?></td>

                <td><?= htmlspecialchars($aluno['status']); ?></td>

                <td>

                    <a
                        href="editar-aluno.php?id=<?= $aluno['id']; ?>"
                        class="btn btn-warning btn-sm">
                        Editar
                    </a>

                    <a
                        href="excluir-aluno.php?id=<?= $aluno['id']; ?>"
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('Deseja excluir este aluno?')">
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