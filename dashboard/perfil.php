<?php

session_start();

if (!isset($_SESSION["usuario_id"])) {

    header("Location: ../auth/login.php");
    exit;

}

require_once "../config/database.php";

$id = $_SESSION["usuario_id"];

$sql = "
SELECT *
FROM usuarios
WHERE id = ?
LIMIT 1
";

$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Meu Perfil</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>Meu Perfil</h2>

        <a href="dashboard.php" class="btn btn-primary">
            Voltar
        </a>

    </div>

    <div class="card p-4">

        <div class="row">

            <div class="col-md-3 text-center">

                <img
                    src="../assets/img/user-default.png"
                    class="img-fluid rounded-circle"
                    width="180">

            </div>

            <div class="col-md-9">

                <h3>
                    <?php echo htmlspecialchars($usuario['nome']); ?>
                </h3>

                <hr>

                <p>
                    <strong>CPF:</strong>
                    <?php echo htmlspecialchars($usuario['cpf']); ?>
                </p>

                <p>
                    <strong>Matrícula:</strong>
                    <?php echo htmlspecialchars($usuario['matricula']); ?>
                </p>

                <p>
                    <strong>E-mail:</strong>
                    <?php echo htmlspecialchars($usuario['email']); ?>
                </p>

                <p>
                    <strong>Tipo:</strong>
                    <?php echo htmlspecialchars($usuario['tipo']); ?>
                </p>

                <p>
                    <strong>Status:</strong>
                    <?php echo htmlspecialchars($usuario['status']); ?>
                </p>

                <p>
                    <strong>Último acesso:</strong>
                    <?php echo $usuario['ultimo_acesso'] ?? 'Primeiro acesso'; ?>
                </p>

            </div>

        </div>

    </div>

</div>

</body>
</html>