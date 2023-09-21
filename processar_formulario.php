<?php
$servername = "localhost";
$username = "u906429557_kinzart";
$password = "0Mp#UZ>7>!ebc2t16780o1";
$dbname = "u906429557_formspot";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
// Verifique se o array $_FILES contém dados
if (!empty($_FILES['fotos_divulgacao']['name'])) {
    // Loop pelos arquivos enviados
    for ($i = 0; $i < count($_FILES['fotos_divulgacao']['name']); $i++) {
        // Exiba informações sobre o arquivo
        echo "Nome do arquivo: " . $_FILES['fotos_divulgacao']['name'][$i] . "<br>";
        echo "Tipo do arquivo: " . $_FILES['fotos_divulgacao']['type'][$i] . "<br>";
        echo "Tamanho do arquivo: " . $_FILES['fotos_divulgacao']['size'][$i] . " bytes<br>";
        echo "Erro de envio: " . $_FILES['fotos_divulgacao']['error'][$i] . "<br>";
    }
} else {
    echo "Nenhum arquivo foi enviado.";
}

// ...

$nome_artista = $_POST['nome_artista'];
$titulo_apresentacao = $_POST['titulo_apresentacao'];
$descricao_apresentacao = $_POST['descricao_apresentacao'];
$generos = $_POST['generos'];
$integrantes_ig = $_POST['integrantes_ig'];
$orcamento_final = $_POST['orcamento_final'];

// Processar o upload de imagens
$diretorio_upload = "imagens/";
$caminhos_imagens = [];

foreach ($_FILES['fotos_divulgacao']['tmp_name'] as $key => $tmp_name) {
    $nome_arquivo = $_FILES['fotos_divulgacao']['name'][$key];
    $caminho_destino = $diretorio_upload . $nome_arquivo;

    if (move_uploaded_file($tmp_name, $caminho_destino)) {
        $caminhos_imagens[] = $caminho_destino;
    } else {
        echo "$_FILES['fotos_divulgacao']['error'][$key]";
    }
}

// Agora, $caminhos_imagens contém os caminhos das imagens carregadas

// Inserir esses caminhos no banco de dados
$caminhos_imagens_json = json_encode($caminhos_imagens);

$sql = "INSERT INTO apresentacoes (nome_artista, titulo_apresentacao, descricao_apresentacao, generos, integrantes_ig, fotos_divulgacao, orcamento_final)
        VALUES ('$nome_artista', '$titulo_apresentacao', '$descricao_apresentacao', '$generos', '$integrantes_ig', '$caminhos_imagens_json', '$orcamento_final')";

if ($conn->query($sql) === TRUE) {
    echo "Dados inseridos com sucesso! (trocar url)";

} else {
    echo "Erro ao inserir dados: " . $conn->error;

}
$conn->close();
?>
