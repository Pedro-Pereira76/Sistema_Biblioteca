<?php
// Incluir a conexão com o banco de dados
include('conecta.php');

// Consultar todos os livros
$queryLivros = "SELECT * FROM livros";
$resultLivros = $conexao->query($queryLivros);

// Consultar todos os sócios
$querySocios = "SELECT * FROM socios";
$resultSocios = $conexao->query($querySocios);

// Consultar todas as retiradas
$queryRetiradas = "SELECT * FROM retiradas";
$resultRetiradas = $conexao->query($queryRetiradas);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/styletbl.css">
    <title>Biblioteca - Visualizar Dados</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        table th, table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        table th {
            background-color: #0056b3;
            color: white;
        }

        .back-button {
            position: fixed;
            top: 10px;
            right: 10px;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
            z-index: 1000;
        }

        .back-button:hover {
            background-color: #0056b3;
        }

        h2 {
            text-align: center;
            color: #000;
        }
    </style>
</head>
<body>
    <!-- Botão "Voltar para o Início" -->
    <a href="index1.html" class="back-button">Voltar para o Início</a>

    <!-- Lista de Livros -->
    <h2>Lista de Livros</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>ISBN</th>
            <th>Título</th>
            <th>Autor</th>
            <th>Categoria</th>
            <th>Ano de Publicação</th>
        </tr>
        <?php while ($livro = $resultLivros->fetch(PDO::FETCH_ASSOC)): ?>
        <tr>
            <td><?php echo $livro['id']; ?></td>
            <td><?php echo $livro['isbn']; ?></td>
            <td><?php echo $livro['titulo']; ?></td>
            <td><?php echo $livro['autor']; ?></td>
            <td><?php echo $livro['categoria']; ?></td>
            <td><?php echo $livro['ano_publicacao']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <!-- Lista de Sócios -->
    <h2>Lista de Sócios</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Telefone</th>
            <th>Endereço</th>
            <th>Data de Nascimento</th>
        </tr>
        <?php while ($socio = $resultSocios->fetch(PDO::FETCH_ASSOC)): ?>
        <tr>
            <td><?php echo $socio['id']; ?></td>
            <td><?php echo $socio['nome']; ?></td>
            <td><?php echo $socio['email']; ?></td>
            <td><?php echo $socio['telefone']; ?></td>
            <td><?php echo $socio['endereco']; ?></td>
            <td><?php echo $socio['data_nascimento']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <!-- Lista de Retiradas -->
    <h2>Lista de Retiradas</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Livro ID</th>
            <th>Sócio ID</th>
            <th>Data de Retirada</th>
            <th>Data de Devolução</th>
        </tr>
        <?php while ($retirada = $resultRetiradas->fetch(PDO::FETCH_ASSOC)): ?>
        <tr>
            <td><?php echo $retirada['id']; ?></td>
            <td><?php echo $retirada['livro_id']; ?></td>
            <td><?php echo $retirada['socio_id']; ?></td>
            <td><?php echo $retirada['data_retirada']; ?></td>
            <td><?php echo $retirada['data_devolucao']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
