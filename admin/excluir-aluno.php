<?php

session_start();

if (
    !isset($_SESSION['usuario_id']) ||
    $_SESSION['tipo'] !== 'admin' &&
    $_SESSION['tipo'] !== 'professor'
){
    header("Location: ../auth/login.php");
    exit;
}

require_once "../config/database.php";

$id = $_GET['id'] ?? 0;

$stmt = $pdo->prepare("
DELETE FROM usuarios
WHERE id = ?
AND tipo = 'aluno'
");

$stmt->execute([$id]);

header("Location: alunos.php");
exit;