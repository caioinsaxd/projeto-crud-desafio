<?php
include('conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];

   
    $telefoneNumerico = preg_replace('/\D/', '', $telefone);

    //validação telefone
    if (strlen($telefoneNumerico) !== 11) {
        echo "Erro: O telefone deve ter exatamente 11 números.";
        exit; 
    }

  
    $stmt = $conn->prepare("INSERT INTO pessoas (nome, email, telefone) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nome, $email, $telefone);

   
    if ($stmt->execute()) {
        echo "Membro adicionado com sucesso!";
    } else {
        echo "Erro: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    
    header("Location: index.php");
    exit();
}
?>
