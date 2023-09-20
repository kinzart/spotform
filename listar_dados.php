<?php
$servername = "localhost";
$username = "u906429557_kinzart";
$password = "0Mp#UZ>7>!ebc2t16780o1";
$dbname = "u906429557_formspot";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$sql = "SELECT * FROM apresentacoes";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>Imagem</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        // Decodifique o JSON para obter os caminhos das imagens
        $caminhos_imagens = json_decode($row["fotos_divulgacao"]);

        if (!empty($caminhos_imagens)) {
            // Suponha que você deseje exibir a primeira imagem da lista
            for ($i = 0; $i < min(3, count($caminhos_imagens)); $i++) {
                echo "<td><a href='" . $caminhos_imagens[$i] . "' download><img src='" . $caminhos_imagens[$i] . "' width='100' height='100'</a> </td>";
          
            }
        } else {
            echo "<td>Nenhuma imagem disponível</td>";
        }
       echo"<tr><th>Nome dos Artista</th><th>Título da Apresentação</th><th>Descrição</th><th>Gêneros</th><th>Integrantes no IG</th><th>Orçamento Final</th></tr>""



        echo "<td><strong>" . $row["nome_artista"] . "</strong></td>";
        echo "<td>" . $row["titulo_apresentacao"] . "</td>";
        echo "<td>" . $row["descricao_apresentacao"] . "</td>";
        echo "<td>" . $row["generos"] . "</td>";
        echo "<td>" . $row["integrantes_ig"] . "</td>";
        echo "<td> R$ " . $row["orcamento_final"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Nenhum resultado encontrado.";
}
$conn->close();
?>
