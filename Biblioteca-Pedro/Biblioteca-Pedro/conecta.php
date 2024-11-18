<?php
// scripts/conecta.php
$servidor = "localhost";
$usuario = "root";
$senha = "";
$db = "biblioteca";

try {
    $conexao = new PDO("mysql:host=$servidor;dbname=$db", $usuario, $senha);
    // Definindo o modo de erro do PDO para exceções
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar: " . $e->getMessage());
}
?>
