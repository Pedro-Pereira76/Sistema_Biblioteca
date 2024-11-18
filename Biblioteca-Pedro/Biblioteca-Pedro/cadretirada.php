<?php
// pages/cadretirada.php
include "conecta.php";

if (isset($_POST['subRetirada'])) {
    $livro_id = $_POST['livro_id'];
    $socio_id = $_POST['socio_id'];
    $data_retirada = $_POST['data_retirada'];
    $data_devolucao = $_POST['data_devolucao']; // Novo campo

    if (empty($livro_id) || empty($socio_id) || empty($data_retirada) || empty($data_devolucao)) {
        echo "<div class='erro'>Por favor, preencha todos os campos!</div>";
    } else {
        // Verificar se o livro e sócio existem no banco
        $stmtLivro = $conexao->prepare("SELECT COUNT(*) FROM livros WHERE id = :livro_id");
        $stmtLivro->bindParam(':livro_id', $livro_id);
        $stmtLivro->execute();
        $livroExiste = $stmtLivro->fetchColumn() > 0;

        $stmtSocio = $conexao->prepare("SELECT COUNT(*) FROM socios WHERE id = :socio_id");
        $stmtSocio->bindParam(':socio_id', $socio_id);
        $stmtSocio->execute();
        $socioExiste = $stmtSocio->fetchColumn() > 0;

        if (!$livroExiste) {
            echo "<div class='erro'>ID do livro não encontrado!</div>";
        } elseif (!$socioExiste) {
            echo "<div class='erro'>ID do sócio não encontrado!</div>";
        } else {
            try {
                $stmt = $conexao->prepare("INSERT INTO retiradas (livro_id, socio_id, data_retirada, data_devolucao) VALUES (:livro_id, :socio_id, :data_retirada, :data_devolucao)");
                $stmt->bindParam(':livro_id', $livro_id);
                $stmt->bindParam(':socio_id', $socio_id);
                $stmt->bindParam(':data_retirada', $data_retirada);
                $stmt->bindParam(':data_devolucao', $data_devolucao);
                $stmt->execute();
                echo "<div class='sucesso'>Retirada registrada com sucesso!</div>";
            } catch (PDOException $e) {
                echo "<div class='erro'>Erro: " . $e->getMessage() . "</div>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Retirada</title>
    <style>
        /* Estilos gerais */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        /* Formulário de cadastro */
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

        form input[type="text"],
        form input[type="date"] {
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

        /* Estilos de alerta e sucesso */
        .erro {
            color: red;
            font-weight: bold;
            text-align: center;
        }

        .sucesso {
            color: green;
            font-weight: bold;
            text-align: center;
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
            background-color: #004080; /* Cor de hover */
        }
    </style>
</head>
<body>

    <form method="POST" action="cadretirada.php">
        <label for="livro_id">ID do Livro:</label>
        <input type="text" name="livro_id" required><br>

        <label for="socio_id">ID do Sócio:</label>
        <input type="text" name="socio_id" required><br>

        <label for="data_retirada">Data da Retirada:</label>
        <input type="date" name="data_retirada" required><br>

        <label for="data_devolucao">Data da Devolução:</label>
        <input type="date" name="data_devolucao" required><br>

        <input type="submit" name="subRetirada" value="Cadastrar Retirada">
    </form>

    <!-- Botão "Voltar para o Início" -->
    <a href="cadastro.html">
        <button class="voltar-btn">Voltar para o Início</button>
    </a>

</body>
</html>
