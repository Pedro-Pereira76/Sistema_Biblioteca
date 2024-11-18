<?php
// scripts/insere.php
include "conecta.php";

if (isset($_POST['subCadastrar'])) {
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $exemplares = $_POST['exemplares'];
    $paginas = $_POST['paginas'];

    if (empty($titulo) || empty($autor) || empty($exemplares) || empty($paginas)) {
        echo "Por favor, preencha todos os campos!";
    } else {
        try {
            $stmt = $conexao->prepare("INSERT INTO livros (titulo, autor, exemplares, paginas) VALUES (:titulo, :autor, :exemplares, :paginas)");
            $stmt->bindParam(':titulo', $titulo);
            $stmt->bindParam(':autor', $autor);
            $stmt->bindParam(':exemplares', $exemplares);
            $stmt->bindParam(':paginas', $paginas);
            $stmt->execute();
            echo "Livro inserido com sucesso!";
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    }
}
?>
