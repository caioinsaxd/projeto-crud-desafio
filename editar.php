<?php
include('conexao.php');

// Verificação id GET
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Erro: sem ID.");
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM pessoas WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Erro: Membro não encontrado.");
}

$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar membro</title>
    <link rel="stylesheet" href="css/editar.css">
    <link rel="stylesheet" href="css/solzinho.css"> 
</head>
<body>

    <div id="solzinho"></div> 

    <h1>Editar Membro</h1>

    <form id="form-editar" action="atualizar.php?id=<?php echo htmlspecialchars($row['id']); ?>" method="POST" onsubmit="return validarFormulario()">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">

        <div class="form-group">
            <label for="nome">Nome:</label>
            <div class="input-container">
                <img src="imagens/nome.png" alt="Ícone Nome" class="input-icon">
                <input type="text" name="nome" id="nome" value="<?php echo htmlspecialchars($row['nome']); ?>" required minlength="3">
            </div>
            <div class="error" id="error-nome"></div>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <div class="input-container">
                <img src="imagens/email.png" alt="Ícone Email" class="input-icon">
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($row['email']); ?>" required>
            </div>
        </div>

        <div class="form-group">
            <label for="telefone">Telefone:</label>
            <div class="input-container">
                <img src="imagens/telefone.png" alt="Ícone Telefone" class="input-icon">
                <input type="text" name="telefone" id="telefone" value="<?php echo htmlspecialchars($row['telefone']); ?>" required>
            </div>
            <div class="error" id="error-telefone"></div>
        </div>

        <button type="submit">Atualizar</button>
    </form>
    
    <script>
        function validarFormulario() {
            const nome = document.getElementById('nome').value;
            const telefone = document.getElementById('telefone').value;
            const errorNome = document.getElementById('error-nome');
            const errorTelefone = document.getElementById('error-telefone');
            errorNome.innerHTML = '';
            errorTelefone.innerHTML = '';

            let erro = false;

            if (nome.length < 3) {
                errorNome.innerHTML = 'Erro: O nome deve ter pelo menos 3 caracteres.';
                erro = true;
            }

            const telefoneNumerico = telefone.replace(/\D/g, '');
            
            if (telefoneNumerico.length !== 11) {
                errorTelefone.innerHTML = 'Erro: Utilize um número de telefone válido.';
                erro = true;
            }

            return !erro;
        }

        document.getElementById('telefone').addEventListener('input', function (e) {
            let telefone = e.target.value;
            telefone = telefone.replace(/\D/g, '');

            if (telefone.length > 0) {
                telefone = '(' + telefone;
            }
            if (telefone.length > 3) {
                telefone = telefone.slice(0, 3) + ') ' + telefone.slice(3);
            }
            if (telefone.length > 10) {
                telefone = telefone.slice(0, 10) + '-' + telefone.slice(10);
            }

            e.target.value = telefone.slice(0, 15);
        });
    </script>
</body>
</html>
