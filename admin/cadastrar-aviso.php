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

    $titulo = trim($_POST['titulo']);
    $conteudo = trim($_POST['conteudo']);

    $sql = "
    INSERT INTO avisos (
        titulo,
        conteudo,
        data_publicacao
    )
    VALUES (
        ?, ?, NOW()
    )
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $titulo,
        $conteudo
    ]);

    header("Location: avisos.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Cadastrar Aviso</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>📢 Novo Aviso</h2>

        <a href="dashboard.php" class="btn btn-secondary">
            ⬅ Voltar ao Painel
        </a>

    </div>

    <div class="card">

        <div class="card-body">

            <form method="POST">

                <div class="mb-3">

                    <label class="form-label">
                        Título
                    </label>

                    <input
                        type="text"
                        name="titulo"
                        class="form-control"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Conteúdo do Aviso
                    </label>

                    <textarea
                        name="conteudo"
                        class="form-control"
                        rows="6"
                        required></textarea>

                </div>

                <button
                    type="submit"
                    class="btn btn-success">

                    💾 Salvar Aviso

                </button>

                <a href="avisos.php"
                   class="btn btn-secondary">

                   Cancelar

                </a>

            </form>

        </div>

    </div>

</div>

</body>
</html>