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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = trim($_POST['nome']);
    $cpf = trim($_POST['cpf']);
    $matricula = trim($_POST['matricula']);
    $curso = trim($_POST['curso']);
    $email = trim($_POST['email']);
    $telefone = trim($_POST['telefone']);

    $senha = password_hash(
        $_POST['senha'],
        PASSWORD_DEFAULT
    );

    $status = $_POST['status'];

    $sql = "
    INSERT INTO usuarios (
        nome,
        cpf,
        matricula,
        curso,
        email,
        telefone,
        senha,
        tipo,
        status
    )
    VALUES (
        ?, ?, ?, ?, ?, ?, ?,
        'aluno',
        ?
    )
    ";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $nome,
        $cpf,
        $matricula,
        $curso,
        $email,
        $telefone,
        $senha,
        $status
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

<title>Cadastrar Aluno</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

    <div class="card p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2>🎓 Cadastrar Aluno</h2>

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
                    required>

            </div>

            <div class="mb-3">

                <label class="form-label">CPF</label>

                <input
                    type="text"
                    name="cpf"
                    class="form-control"
                    placeholder="000.000.000-00"
                    required>

            </div>

            <div class="mb-3">

                <label class="form-label">Matrícula</label>

                <input
                    type="text"
                    name="matricula"
                    class="form-control"
                    required>

            </div>

            <div class="mb-3">

                <label class="form-label">Curso</label>

                <input
                    type="text"
                    name="curso"
                    class="form-control"
                    placeholder="Ex: Técnico em Informática"
                    required>

            </div>

            <div class="mb-3">

                <label class="form-label">E-mail</label>

                <input
                    type="email"
                    name="email"
                    class="form-control">

            </div>

            <div class="mb-3">

                <label class="form-label">Telefone</label>

                <input
                    type="text"
                    name="telefone"
                    class="form-control">

            </div>

            <div class="mb-3">

                <label class="form-label">Senha Inicial</label>

                <input
                    type="password"
                    name="senha"
                    class="form-control"
                    required>

            </div>

            <div class="mb-3">

                <label class="form-label">Status</label>

                <select
                    name="status"
                    class="form-select">

                    <option value="ativo">
                        Ativo
                    </option>

                    <option value="inativo">
                        Inativo
                    </option>

                </select>

            </div>

            <button
                type="submit"
                class="btn btn-success">

                💾 Salvar Aluno

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