<?php
// Configurações de conexão com o banco de dados
$host = 'localhost';
$dbname = 'biblioteca';
$username = 'root';
$password = '';

try {
    $conexao = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro de conexão: " . $e->getMessage();
    exit();
}

// Gráfico de Sócios: Total de sócios
$sql_socios = "SELECT COUNT(*) as total_socios FROM socios";
$stmt_socios = $conexao->prepare($sql_socios);
$stmt_socios->execute();
$total_socios = $stmt_socios->fetch(PDO::FETCH_ASSOC)['total_socios'];

// Gráfico de Retiradas: Total de retiradas por ano
$sql_retiradas_por_ano = "SELECT YEAR(data_retirada) as ano, COUNT(*) as total_retiradas
                          FROM retiradas
                          WHERE YEAR(data_retirada) BETWEEN 2020 AND 2028
                          GROUP BY ano
                          ORDER BY ano ASC";
$stmt_retiradas_por_ano = $conexao->prepare($sql_retiradas_por_ano);
$stmt_retiradas_por_ano->execute();
$result_retiradas = $stmt_retiradas_por_ano->fetchAll(PDO::FETCH_ASSOC);

// Inicializa os arrays de anos e total de retiradas por ano
$anos = [];
$total_retiradas_por_ano = [];
for ($ano = 2020; $ano <= 2028; $ano++) {
    $anos[] = $ano;
    $total_retiradas_por_ano[$ano] = 0;  // Inicializa com 0 para cada ano
}

// Atualiza a quantidade de retiradas por ano para os anos existentes
foreach ($result_retiradas as $row) {
    $ano_retirada = $row['ano'];
    $total_retiradas_por_ano[$ano_retirada] = $row['total_retiradas'];
}

// Gráfico de Livro Mais Retirado
$sql_livro_mais_retirado = "SELECT titulo, COUNT(*) as total_retiradas 
                            FROM retiradas 
                            JOIN livros ON retiradas.livro_id = livros.id 
                            GROUP BY titulo 
                            ORDER BY total_retiradas DESC LIMIT 1";
$stmt_livro_mais_retirado = $conexao->prepare($sql_livro_mais_retirado);
$stmt_livro_mais_retirado->execute();
$livro_mais_retirado = $stmt_livro_mais_retirado->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráficos de Biblioteca</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }

        .chart-container {
            width: 80%;
            max-width: 800px;
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
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            z-index: 1000;
        }

        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <!-- Botão para voltar ao início -->
    <a href="index1.html" class="back-button">Voltar para o Início</a>

    <!-- Gráfico de Sócios -->
    <div class="chart-container">
        <h2>Total de Sócios</h2>
        <canvas id="sociosChart"></canvas>
    </div>

    <!-- Gráfico de Retiradas por Ano -->
    <div class="chart-container">
        <h2>Total de Retiradas por Ano</h2>
        <canvas id="retiradasChart"></canvas>
        <p><strong>Livro mais retirado:</strong> <?php echo $livro_mais_retirado['titulo']; ?> (<?php echo $livro_mais_retirado['total_retiradas']; ?> retiradas)</p>
    </div>

    <script>
        // Gráfico de Sócios
        var ctxSocios = document.getElementById('sociosChart').getContext('2d');
        new Chart(ctxSocios, {
            type: 'bar',
            data: {
                labels: ['Sócios'],
                datasets: [{
                    label: 'Total de Sócios',
                    data: [<?php echo $total_socios; ?>],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Gráfico de Retiradas por Ano
        var ctxRetiradas = document.getElementById('retiradasChart').getContext('2d');
        new Chart(ctxRetiradas, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($anos); ?>,  // Anos de 2020 a 2028
                datasets: [{
                    label: 'Total de Retiradas por Ano',
                    data: <?php echo json_encode(array_values($total_retiradas_por_ano)); ?>,  // Total de retiradas por ano
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
