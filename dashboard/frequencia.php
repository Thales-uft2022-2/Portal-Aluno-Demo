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

f.aulas_total,
f.presencas,
f.faltas

FROM frequencias f

INNER JOIN disciplinas d
ON d.id = f.disciplina_id

WHERE f.usuario_id = ?
";

$stmt = $pdo->prepare($sql);
$stmt->execute([$usuario_id]);

$frequencias = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang='pt-BR'>

<head>

<meta charset='UTF-8'>
<meta name='viewport' content='width=device-width, initial-scale=1.0'>

<title>Frequência</title>

<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet'>

</head>

<body>

<div class="container mt-5">

    <div class="d-flex justify-content-between mb-4">

        <h2>📅 Minha Frequência</h2>

        <a href="dashboard.php" class="btn btn-primary">

            Voltar

        </a>

    </div>

    <div class="card p-4">

        <table class="table table-striped">

            <thead>

                <tr>

                    <th>Disciplina</th>
                    <th>Aulas</th>
                    <th>Presenças</th>
                    <th>Faltas</th>
                    <th>Frequência</th>

                </tr>

            </thead>

            <tbody>

            <?php foreach($frequencias as $freq): ?>

                <?php

                $percentual = 0;

                if($freq['aulas_total'] > 0){

                    $percentual =
                    ($freq['presencas'] /
                    $freq['aulas_total']) * 100;

                }

                ?>

                <tr>

                    <td><?= $freq['disciplina']; ?></td>

                    <td><?= $freq['aulas_total']; ?></td>

                    <td><?= $freq['presencas']; ?></td>

                    <td><?= $freq['faltas']; ?></td>

                    <td>

                        <?= number_format($percentual,1); ?>%

                    </td>

                </tr>

            <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>

</body>

</html>