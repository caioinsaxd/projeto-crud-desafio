<?php
include('conexao.php');

//verificação id POST
if (!isset($_POST['id']) || empty($_POST['id'])) {
    die("Erro: ID não fornecido.");
}

$id = intval($_POST['id']); //segurança
$nome = $_POST['nome'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];

$erro = '';

if (strlen($nome) < 3) {
    $erro .= "Erro: O nome deve ter pelo menos 3 caracteres.<br>";
}

$telefoneNumerico = preg_replace('/\D/', '', $telefone);

if (strlen($telefoneNumerico) !== 11) {
    $erro .= "Erro: O telefone deve ter exatamente 11 números.<br>";
}

if ($erro) {
    echo $erro;
} else {
    
    $stmt = $conn->prepare("UPDATE pessoas SET nome=?, email=?, telefone=? WHERE id=?");
    $stmt->bind_param("sssi", $nome, $email, $telefone, $id);

    
    if ($stmt->execute()) {
        echo "Membro atualizado com sucesso!";
        header("Location: index.php"); 
        exit();
    } else {
        echo "Erro: " . $stmt->error;
    }

    
    $stmt->close();
}

$conn->close();
?>
