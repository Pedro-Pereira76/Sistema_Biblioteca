<?php
// pages/consuretirada.php
include "conecta.php";

$stmt = $conexao->prepare("SELECT * FROM retiradas");
$stmt->execute();

echo "<table border='1'>
    <tr>
        <th>ID Livro</th>
        <th>ID Sócio</th>
        <th>Data Retirada</th>
    </tr>";

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>
        <td>" . $row['livro_id'] . "</td>
        <td>" . $row['socio_id'] . "</td>
        <td>" . $row['data_retirada'] . "</td>
    </tr>";
}

echo "</table>";
?>
