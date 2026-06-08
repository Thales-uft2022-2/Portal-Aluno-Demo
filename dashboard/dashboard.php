<?php

session_start();

if (!isset($_SESSION["usuario_id"])) {

    header("Location: ../auth/login.php");
    exit;

}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard - Portal do Aluno</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/style.css">

    <style>

        .card-link{
            text-decoration:none;
            color:inherit;
        }

        .card{
            transition:0.3s;
            cursor:pointer;
            border:none;
        }

        .card:hover{
            transform:translateY(-5px);
            box-shadow:0 8px 20px rgba(0,0,0,.25);
        }

    </style>

</head>

<body>

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2>
                Olá, <?= htmlspecialchars($_SESSION["nome"]); ?> 👋
            </h2>

            <p>
                Bem-vindo ao Portal do Aluno PSID
            </p>

        </div>

        <a href="../auth/logout.php" class="btn btn-danger">
            Sair
        </a>

    </div>

    <div class="row g-4">

        <div class="col-md-4">

            <a href="notas.php" class="card-link">

                <div class="card p-4">

                    <h4>📊 Desempenho</h4>

                    <p>
                        Acompanhe suas notas.
                    </p>

                </div>

            </a>

        </div>

        <div class="col-md-4">

            <a href="disciplinas.php" class="card-link">

                <div class="card p-4">

                    <h4>📚 Disciplinas</h4>

                    <p>
                        Visualize suas disciplinas.
                    </p>

                </div>

            </a>

        </div>

        <div class="col-md-4">

            <a href="frequencia.php" class="card-link">

                <div class="card p-4">

                    <h4>📅 Frequência</h4>

                    <p>
                        Consulte sua frequência.
                    </p>

                </div>

            </a>

        </div>

        <div class="col-md-4">

            <!--a href="documentos.php" class="card-link">

                <div class="card p-4">

                    <h4>📄 Documentos</h4>

                    <p>
                        Baixe documentos acadêmicos.
                    </p>

                </div-->

            </a>

        </div>

        <div class="col-md-4">

            <a href="avisos.php" class="card-link">

                <div class="card p-4">

                    <h4>📢 Avisos</h4>

                    <p>
                        Leia os comunicados.
                    </p>

                </div>

            </a>

        </div>

        <div class="col-md-4">

            <a href="perfil.php" class="card-link">

                <div class="card p-4">

                    <h4>👤 Perfil</h4>

                    <p>
                        Atualize seus dados.
                    </p>

                </div>

            </a>

        </div>

    </div>

</div>

</body>

</html>