<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Portal do Aluno PSID</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

    <div class="login-container">

        <div class="login-card">

            <div class="login-header">

                <img src="../assets/img/log/logo.png"
                     alt="Logo PSID"
                     class="login-logo">

                <h1>Portal do Aluno</h1>

                <p>
                    Acesse sua área acadêmica
                </p>

            </div>

            <?php if(isset($_GET['erro'])): ?>

                <div class="alert alert-danger">

                    CPF ou senha inválidos.

                </div>

            <?php endif; ?>

            <form action="process-login.php" method="POST">

                <div class="mb-3">

                    <label class="form-label">

                        CPF

                    </label>

                    <input
                        type="text"
                        name="cpf"
                        id="cpf"
                        class="form-control"
                        placeholder="000.000.000-00"
                        maxlength="14"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Senha

                    </label>

                    <div class="input-group">

                        <input
                            type="password"
                            name="senha"
                            id="senha"
                            class="form-control"
                            placeholder="Digite sua senha"
                            required>

                        <button
                            type="button"
                            class="btn btn-outline-secondary"
                            onclick="mostrarSenha()">

                            👁️

                        </button>

                    </div>

                </div>

                <div class="d-grid">

                    <button
                        type="submit"
                        class="btn btn-primary btn-login">

                        Entrar

                    </button>

                </div>

                <div class="login-links">

                    <a href="forgot-password.php">

                        Esqueci minha senha

                    </a>

                </div>

            </form>

        </div>

    </div>

    <script>

        function mostrarSenha() {

            const senha = document.getElementById('senha');

            if (senha.type === 'password') {

                senha.type = 'text';

            } else {

                senha.type = 'password';

            }

        }

        const cpf = document.getElementById('cpf');

        cpf.addEventListener('input', function () {

            let valor = this.value.replace(/\D/g, '');

            valor = valor.replace(/(\d{3})(\d)/, '$1.$2');
            valor = valor.replace(/(\d{3})(\d)/, '$1.$2');
            valor = valor.replace(/(\d{3})(\d{1,2})$/, '$1-$2');

            this.value = valor;

        });

    </script>

</body>

</html>