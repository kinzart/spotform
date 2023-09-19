$servername = "localhost";
$username = "root";
$password = "nova_senha";


// Crie uma conexão com o banco de dados
$conn = new mysqli($servername, $username, $password);

// Verifique a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Crie o banco de dados se ele não existir
$sql = "CREATE DATABASE IF NOT EXISTS meu_banco_de_dados";
if ($conn->query($sql) === TRUE) {
    echo "Banco de dados criado com sucesso!";
} else {
    echo "Erro ao criar o banco de dados: " . $conn->error;
}

$conn->close();
