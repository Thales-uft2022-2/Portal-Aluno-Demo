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

$id = $_GET['id'] ?? 0;

/* Buscar aluno */

$stmt = $pdo->prepare("
SELECT *
FROM usuarios
WHERE id = ?
AND tipo = 'aluno'
LIMIT 1
");

$stmt->execute([$id]);

$aluno = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$aluno) {
    die("Aluno não encontrado.");
}

/* Salvar alterações */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = trim($_POST['nome']);
    $cpf = trim($_POST['cpf']);
    $matricula = trim($_POST['matricula']);
    $curso = trim($_POST['curso']);
    $email = trim($_POST['email']);
    $telefone = trim($_POST['telefone']);
    $status = $_POST['status'];

    $update = $pdo->prepare("
    UPDATE usuarios
    SET
        nome = ?,
        cpf = ?,
        matricula = ?,
        curso = ?,
        email = ?,
        telefone = ?,
        status = ?
    WHERE id = ?
    ");

    $update->execute([
        $nome,
        $cpf,
        $matricula,
        $curso,
        $email,
        $telefone,
        $status,
        $id
    ]);

    header("Location: alunos.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Editar Aluno</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

    <div class="card p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2>✏️ Editar Aluno</h2>

            <a href="alunos.php" class="btn btn-secondary">
                ⬅ Voltar
            </a>

        </div>

        <form method="POST">

            <div class="mb-3">

                <label class="form-label">Nome Completo</label>

                <input
                    type="text"
                    name="nome"
                    class="form-control"
                    value="<?= htmlspecialchars($aluno['nome']); ?>"
                    required>

            </div>

            <div class="mb-3">

                <label class="form-label">CPF</label>

                <input
                    type="text"
                    name="cpf"
                    class="form-control"
                    value="<?= htmlspecialchars($aluno['cpf']); ?>"
                    required>

            </div>

            <div class="mb-3">

                <label class="form-label">Matrícula</label>

                <input
                    type="text"
                    name="matricula"
                    class="form-control"
                    value="<?= htmlspecialchars($aluno['matricula']); ?>"
                    required>

            </div>

            <div class="mb-3">

                <label class="form-label">Curso</label>

                <input
                    type="text"
                    name="curso"
                    class="form-control"
                    value="<?= htmlspecialchars($aluno['curso'] ?? ''); ?>"
                    placeholder="Ex: Técnico em Informática"
                    required>

            </div>

            <div class="mb-3">

                <label class="form-label">E-mail</label>

                <input
                    type="email"
                    name="email"
                    class="form-control"
                    value="<?= htmlspecialchars($aluno['email']); ?>">

            </div>

            <div class="mb-3">

                <label class="form-label">Telefone</label>

                <input
                    type="text"
                    name="telefone"
                    class="form-control"
                    value="<?= htmlspecialchars($aluno['telefone']); ?>">

            </div>

            <div class="mb-3">

                <label class="form-label">Status</label>

                <select
                    name="status"
                    class="form-select">

                    <option value="ativo"
                        <?= $aluno['status'] == 'ativo' ? 'selected' : ''; ?>>
                        Ativo
                    </option>

                    <option value="inativo"
                        <?= $aluno['status'] == 'inativo' ? 'selected' : ''; ?>>
                        Inativo
                    </option>

                </select>

            </div>

            <button
                type="submit"
                class="btn btn-primary">

                💾 Salvar Alterações

            </button>

            <a
                href="alunos.php"
                class="btn btn-secondary">

                Cancelar

            </a>

        </form>

    </div>

</div>

</body>

</html>