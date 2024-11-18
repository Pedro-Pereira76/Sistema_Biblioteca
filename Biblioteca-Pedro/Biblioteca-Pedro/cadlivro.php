<?php
// pages/cadlivro.php
include "conecta.php";
error_reporting(0);

if (isset($_POST['subLivro'])) {
    $isbn = $_POST["isbn"];
    $titulo = $_POST["titulo"];
    $autor = $_POST["autor"];
    $categoria = $_POST["categoria"];
    $ano_publicacao = $_POST["ano_publicacao"];

    // Validação de campos
    if (empty($isbn) || empty($titulo) || empty($autor) || empty($categoria) || empty($ano_publicacao)) {
        echo "<center><div class='alerta'>Preencha todos os campos</div></center>";
    } else {
        try {
            $insere = "INSERT INTO livros (isbn, titulo, autor, categoria, ano_publicacao) 
                       VALUES (:isbn, :titulo, :autor, :categoria, :ano_publicacao)";
            $stmt = $conexao->prepare($insere);
            $stmt->bindParam(':isbn', $isbn);
            $stmt->bindParam(':titulo', $titulo);
            $stmt->bindParam(':autor', $autor);
            $stmt->bindParam(':categoria', $categoria);
            $stmt->bindParam(':ano_publicacao', $ano_publicacao);

            // Executa a inserção
            $stmt->execute();

            echo "<center><div class='sucesso'>Livro cadastrado com sucesso!</div></center>";
        } catch (PDOException $e) {
            echo "<center><div class='erro'>Erro ao cadastrar: " . $e->getMessage() . "</div></center>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Livros</title>
    <style>
        /* Estilos Gerais */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        /* Formulário de Cadastro */
        form {
            background-color: #fff;
            margin: 50px auto;
            padding: 30px;
            border-radius: 8px;
            width: 400px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        form label {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 8px;
            display: block;
            color: #333;
        }

        form input,
        form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        form input[type="submit"] {
            background-color: #0056b3;
            color: white;
            border: none;
            padding: 12px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
            width: 100%;
        }

        form input[type="submit"]:hover {
            background-color: #00408d;
        }

        /* Estilo para o botão "Voltar para o início" fixo */
        .voltar-btn {
            position: fixed;
            top: 10px;
            right: 10px;
            background-color: #0056b3; /* Cor personalizada */
            color: white;
            border: none;
            padding: 15px 25px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 8px; /* Bordas arredondadas */
            z-index: 1000; /* Garante que o botão fique sobre os outros elementos */
        }

        .voltar-btn:hover {
            background-color: #00408d; /* Cor de hover */
        }

        /* Estilos de alerta e sucesso */
        .alerta {
            color: red;
            font-weight: bold;
        }

        .sucesso {
            color: green;
            font-weight: bold;
        }

        .erro {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <form method="post" action="cadlivro.php">
        <label for="isbn">ISBN:</label><br>
        <input type="text" name="isbn" id="isbn" required><br>

        <label for="titulo">Título do Livro:</label><br>
        <input type="text" name="titulo" id="titulo" required><br>

        <label for="autor">Autor do Livro:</label><br>
        <input type="text" name="autor" id="autor" required><br>

        <label for="categoria">Categoria:</label><br>
        <input type="text" name="categoria" id="categoria" required><br>

        <label for="ano_publicacao">Ano de Publicação:</label><br>
        <input type="number" name="ano_publicacao" id="ano_publicacao" required><br>

        <input type="submit" name="subLivro" value="Cadastrar">
    </form>

    <!-- Botão "Voltar para o início" -->
    <a href="cadastro.html">
        <button class="voltar-btn">Voltar para o Início</button>
    </a>

</body>
</html>
