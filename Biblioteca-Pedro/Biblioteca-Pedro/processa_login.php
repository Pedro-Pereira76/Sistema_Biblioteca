<?php
// Defina as credenciais do banco de dados
$host = 'localhost';  // Ou o IP do seu servidor MySQL
$dbname = 'biblioteca';  // Nome do banco de dados
$username = 'root';  // Nome de usuário do banco de dados
$password = '';  // Senha do banco de dados

try {
    // Criando a conexão PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  // Habilita exceções para erros

} catch (PDOException $e) {
    // Caso ocorra um erro de conexão
    echo "Erro de conexão: " . $e->getMessage();
    die();  // Interrompe a execução caso não consiga conectar
}

// Verificando se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        // Verifique se a variável $pdo foi criada corretamente
        if (isset($pdo)) {
            // Preparando a consulta SQL
            $sql = "SELECT * FROM superior WHERE username = :username AND password = :password";
            $stmt = $pdo->prepare($sql);

            // Bind de parâmetros
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password);

            // Executando a consulta
            $stmt->execute();

            // Verificando se o usuário foi encontrado
            if ($stmt->rowCount() > 0) {
                // Login bem-sucedido, redireciona para a página principal
                header("Location: index1.html");
                exit();
            } else {
                // Caso contrário, redireciona de volta para a página de login com a mensagem de erro
                header("Location: login.php?error=invalid");
                exit();
            }
        } else {
            echo "Erro: Conexão com o banco de dados não foi estabelecida.";
        }
    } catch (PDOException $e) {
        // Caso ocorra um erro na consulta
        echo "Erro: " . $e->getMessage();
    }
}
?>
