<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "u906429557_kinzart";
$password = "0Mp#UZ>7>!ebc2t16780o1";
$dbname = "u906429557_formspot";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$nome_artista = $_POST['nome_artista'];
$titulo_apresentacao = $_POST['titulo_apresentacao'];
$descricao_apresentacao = $_POST['descricao_apresentacao'];
$generos = $_POST['generos'];
$integrantes_ig = $_POST['integrantes_ig'];
$orcamento_final = $_POST['orcamento_final'];

// Processar o upload de imagens
$diretorio_upload = "imagens/";
$caminhos_imagens = [];
$upload_errors = []; // Array para armazenar erros de upload


foreach ($_FILES['fotos_divulgacao']['tmp_name'] as $key => $tmp_name) {
    $nome_arquivo = $_FILES['fotos_divulgacao']['name'][$key];
    $caminho_destino = $diretorio_upload . $nome_arquivo;

    if (move_uploaded_file($tmp_name, $caminho_destino)) {
        $caminhos_imagens[] = $caminho_destino;
    } else {
 // Adicione informações sobre o erro ao array de erros
 $upload_errors[] = "Erro ao fazer upload da imagem $nome_arquivo.";
    }
}
if (!empty($upload_errors)) {
    // Se houver erros de upload, retorne-os como parte da resposta AJAX
    echo json_encode(array(
        'success' => false,
        'message' => 'Erro durante o upload das imagens.',
        'errors' => $upload_errors
    ));
} else {
    // Se não houver erros de upload, continue com a inserção no banco de dados
    $caminhos_imagens_json = json_encode($caminhos_imagens);

    $sql = "INSERT INTO apresentacoes (nome_artista, titulo_apresentacao, descricao_apresentacao, generos, integrantes_ig, fotos_divulgacao, orcamento_final)
            VALUES ('$nome_artista', '$titulo_apresentacao', '$descricao_apresentacao', '$generos', '$integrantes_ig', '$caminhos_imagens_json', '$orcamento_final')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array(
            'success' => true,
            'message' => 'Dados inseridos com sucesso! (trocar url)'
        ));
    } else {
        echo json_encode(array(
            'success' => false,
            'message' => 'Erro ao inserir dados: ' . $conn->error
        ));
    }
}

$conn->close();
?>