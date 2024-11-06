<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Sisteminha - CRUD</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/solzinho.css"> 
</head>
<body>

    <div id="solzinho"></div> 

    <h1>Sisteminha de armazenagem de membros</h1> 

    <!-- formulário -->
    <h2>Adicionar Membro</h2>
    <form action="inserir.php" method="POST" onsubmit="return validarFormulario()">
        <div class="input-container">
            <img src="imagens/nome.png" alt="Nome" class="input-icon">
            <input type="text" name="nome" id="nome" placeholder="Nome" required minlength="3">
        </div>
        <div class="input-container">
            <img src="imagens/email.png" alt="Email" class="input-icon">
            <input type="email" name="email" placeholder="Email" required>
        </div>
        <div class="input-container">
            <img src="imagens/telefone.png" alt="Telefone" class="input-icon">
            <input type="text" name="telefone" id="telefone" placeholder="Telefone" required maxlength="15">
        </div>
        <button type="submit">Adicionar</button>
    </form>

    <!-- validação -->
    <script>
    function validarFormulario() {
        const nome = document.getElementById('nome').value;
        const telefone = document.getElementById('telefone').value;

        // no mínimo 3 caracteres para nomes
        if (nome.length < 3) {
            alert('O nome deve ter pelo menos 3 caracteres.');
            return false;
        }

        // remove caracter errado para ver se tem 11 números
        const telefoneNumerico = telefone.replace(/\D/g, '');
        if (telefoneNumerico.length !== 11) {
            alert('O telefone deve ter exatamente 11 números.');
            return false;
        }

        return true;
    }

    // formata o número automaticamente
    document.getElementById('telefone').addEventListener('input', function (e) {
        let telefone = e.target.value;

        // remove caracter não numérico
        telefone = telefone.replace(/\D/g, '');

        // formato com ddd e hífen
        if (telefone.length > 0) {
            telefone = '(' + telefone;
        }
        if (telefone.length > 3) {
            telefone = telefone.slice(0, 3) + ') ' + telefone.slice(3);
        }
        if (telefone.length > 10) {
            telefone = telefone.slice(0, 10) + '-' + telefone.slice(10);
        }

        // limite de caracteres do número
        e.target.value = telefone.slice(0, 15);
    });
    </script>

    <h2>Membros do Time</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Telefone</th>
            <th>Ações</th>
        </tr>
        
        <?php
        include('conexao.php');

        $sql = "SELECT * FROM pessoas";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["nome"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . $row["telefone"] . "</td>";
                echo "<td>
                        <a href='editar.php?id=" . $row["id"] . "'>
                            <img src='imagens/editar.png' alt='Editar' class='icon'>
                        </a>
                        <a href='deletar.php?id=" . $row["id"] . "' onclick=\"return confirm('Tem certeza que deseja deletar?')\">
                            <img src='imagens/excluir.png' alt='Deletar' class='icon'>
                        </a>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Nenhum membro ainda 🤓</td></tr>";
        }

        $conn->close();
        ?>
    </table>
</body>
</html>
