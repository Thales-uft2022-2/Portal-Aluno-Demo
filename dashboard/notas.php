<?php

session_start();

if (!isset($_SESSION["usuario_id"])) {

    header("Location: ../auth/login.php");
    exit;

}

require_once "../config/database.php";

$usuario_id = $_SESSION["usuario_id"];

$sql = "
SELECT
    d.nome AS disciplina,

    n.nota1,
    n.nota2,
    n.nota3

FROM notas n

INNER JOIN disciplinas d
ON d.id = n.disciplina_id

WHERE n.usuario_id = ?
";

$stmt = $pdo->prepare($sql);
$stmt->execute([$usuario_id]);

$notas = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Minhas Notas</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>📚 Minhas Notas</h2>

        <a href="dashboard.php" class="btn btn-primary">
            Voltar
        </a>

    </div>

    <div class="card p-4">

        <table class="table table-striped table-hover">

            <thead>

                <tr>

                    <th>Disciplina</th>

                    <th>Nota 1</th>

                    <th>Nota 2</th>

                    <th>Nota 3</th>

                    <th>Média</th>

                    <th>Situação</th>

                </tr>

            </thead>

            <tbody>

            <?php foreach($notas as $nota): ?>

                <?php

                $media = (
                    $nota['nota1'] +
                    $nota['nota2'] +
                    $nota['nota3']
                ) / 3;

                if ($media >= 7) {

                    $situacao = "✅ Aprovado";

                } elseif ($media >= 5) {

                    $situacao = "🟡 Recuperação";

                } else {

                    $situacao = "🔴 Reprovado";

                }

                ?>

                <tr>

                    <td>
                        <?= htmlspecialchars($nota['disciplina']) ?>
                    </td>

                    <td>
                        <?= number_format($nota['nota1'],2,',','.') ?>
                    </td>

                    <td>
                        <?= number_format($nota['nota2'],2,',','.') ?>
                    </td>

                    <td>
                        <?= number_format($nota['nota3'],2,',','.') ?>
                    </td>

                    <td>
                        <?= number_format($media,2,',','.') ?>
                    </td>

                    <td>
                        <?= $situacao ?>
                    </td>

                </tr>

            <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>

</body>
</html>