<?php

session_start();

require_once "../config/database.php";

/*
|--------------------------------------------------------------------------
| Dados do formulário
|--------------------------------------------------------------------------
*/

$cpf = preg_replace('/\D/', '', $_POST['cpf'] ?? '');
$senha = trim($_POST['senha'] ?? '');

/*
|--------------------------------------------------------------------------
| Buscar usuário
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT *
    FROM usuarios
    WHERE REPLACE(REPLACE(cpf,'.',''),'-','') = ?
    AND status = 'ativo'
    LIMIT 1
");

$stmt->execute([$cpf]);

$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| Usuário não encontrado
|--------------------------------------------------------------------------
*/

if (!$usuario) {

    header("Location: login.php?erro=1");
    exit;

}

/*
|--------------------------------------------------------------------------
| Validar senha
|--------------------------------------------------------------------------
*/

$senhaValida = false;

/* Senha criptografada */
if (
    !empty($usuario['senha']) &&
    password_verify($senha, $usuario['senha'])
) {

    $senhaValida = true;

}

/* Senha em texto puro */
if ($senha === $usuario['senha']) {

    $senhaValida = true;

}

if (!$senhaValida) {

    header("Location: login.php?erro=1");
    exit;

}

/*
|--------------------------------------------------------------------------
| Criar sessão
|--------------------------------------------------------------------------
*/

$_SESSION['usuario_id'] = $usuario['id'];
$_SESSION['nome'] = $usuario['nome'];
$_SESSION['cpf'] = $usuario['cpf'];
$_SESSION['tipo'] = $usuario['tipo'];

/*
|--------------------------------------------------------------------------
| Atualizar último acesso
|--------------------------------------------------------------------------
*/

$update = $pdo->prepare("
    UPDATE usuarios
    SET ultimo_acesso = NOW()
    WHERE id = ?
");

$update->execute([$usuario['id']]);

/*
|--------------------------------------------------------------------------
| Redirecionamento
|--------------------------------------------------------------------------
*/

if (
    $usuario['tipo'] === 'admin' ||
    $usuario['tipo'] === 'professor'
) {

    header("Location: ../admin/dashboard.php");
    exit;

}

if ($usuario['tipo'] === 'aluno') {

    header("Location: ../dashboard/dashboard.php");
    exit;

}

/*
|--------------------------------------------------------------------------
| Tipo inválido
|--------------------------------------------------------------------------
*/

session_destroy();

header("Location: login.php?erro=1");
exit;