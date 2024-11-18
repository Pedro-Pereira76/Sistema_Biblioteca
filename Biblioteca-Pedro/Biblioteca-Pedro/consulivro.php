<?php
// pages/consusocio.php
include "conecta.php";

$stmt = $conexao->prepare("SELECT * FROM socios");
$stmt->execute();

echo "<table border='1'>
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Email</th>
        <th>Telefone</th>
    </tr>";

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>
        <td>" . $row['id'] . "</td>
        <td>" . $row['nome_socio'] . "</td>
        <td>" . $row['email_socio'] . "</td>
        <td>" . $row['telefone'] . "</td>
    </tr>";
}

echo "</table>";
?>
