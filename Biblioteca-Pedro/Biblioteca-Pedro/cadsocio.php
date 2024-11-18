<?php
// pages/cadsocio.php
include "conecta.php";

// Verificando se o formulário foi enviado
if (isset($_POST['subSocio'])) {
    // Recebendo dados do formulário
    $nome_socio = trim($_POST['nome_socio']);
    $email_socio = trim($_POST['email_socio']);
    $telefone = trim($_POST['telefone']);
    $endereco = trim($_POST['endereco']);
    $data_nascimento = $_POST['data_nascimento'];

    // Validação simples
    if (empty($nome_socio) || empty($email_socio) || empty($telefone) || empty($endereco) || empty($data_nascimento)) {
        echo "<div class='erro'>Por favor, preencha todos os campos!</div>";
    } else {
        try {
            // Verificando se o e-mail já existe
            $stmtCheck = $conexao->prepare("SELECT COUNT(*) FROM socios WHERE email = :email_socio");
            $stmtCheck->bindParam(':email_socio', $email_socio);
            $stmtCheck->execute();
            $emailExists = $stmtCheck->fetchColumn();

            if ($emailExists > 0) {
                echo "<div class='erro'>Este e-mail já está cadastrado.</div>";
            } else {
                // Inserção no banco de dados
                $stmt = $conexao->prepare("INSERT INTO socios (nome, email, telefone, endereco, data_nascimento) VALUES (:nome_socio, :email_socio, :telefone, :endereco, :data_nascimento)");
                $stmt->bindParam(':nome_socio', $nome_socio);
                $stmt->bindParam(':email_socio', $email_socio);
                $stmt->bindParam(':telefone', $telefone);
                $stmt->bindParam(':endereco', $endereco);
                $stmt->bindParam(':data_nascimento', $data_nascimento);

                // Executando a inserção
                $stmt->execute();

                // Sucesso
                echo "<div class='sucesso'>Sócio cadastrado com sucesso!</div>";
            }
        } catch (PDOException $e) {
            echo "<div class='erro'>Erro: " . $e->getMessage() . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Sócio</title>
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
        form input[type="email"],
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

        /* Estilo para o botão "Voltar para o Início" fixo */
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

    <form method="POST" action="cadsocio.php">
        <label for="nome">Nome do Sócio:</label>
        <input type="text" name="nome_socio" required><br>

        <label for="email">Email do Sócio:</label>
        <input type="email" name="email_socio" required><br>

        <label for="telefone">Telefone:</label>
        <input type="text" name="telefone" required><br>

        <label for="endereco">Endereço:</label>
        <input type="text" name="endereco" required><br>

        <label for="data_nascimento">Data de Nascimento:</label>
        <input type="date" name="data_nascimento" required><br>

        <input type="submit" name="subSocio" value="Cadastrar Sócio">
    </form>

    <!-- Botão "Voltar para o Início" -->
    <a href="cadastro.html">
        <button class="voltar-btn">Voltar para o Início</button>
    </a>

</body>
</html>
