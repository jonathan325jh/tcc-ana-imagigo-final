<?php
session_start();

if(isset($_POST['submit'])){

    include_once(__DIR__ . '/config.php');

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $genero = $_POST['genero'];

    if (isset($conexao) && $conexao) {
        
        // Define o nível inicial como 0, XP como 0 e personagem_criado como 0
        $result = mysqli_query($conexao, "INSERT INTO usuarios(nome, email, senha, sexo, xp, level, personagem_criado) 
        VALUES ('$nome', '$email', '$senha', '$genero', 0, 0, 0)");

        if($result) {
            $_SESSION['nome'] = $nome;
            $_SESSION['email'] = $email;

            header('Location: pagina-entrada.php');
            exit();
        } else {
            echo "Erro ao cadastrar: " . mysqli_error($conexao);
        }

    } else {
        die("Erro: Conexão com o banco de dados não foi estabelecida.");
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="entrar.css">
    <link rel="stylesheet" href="entrar.css?v=1.0">
</head>
<body class="fundo">

    <header>
        <div class="volta-dois">
            <a href="index.html">
                <img src="voltar-bt.png" id="voltar">
            </a>
        </div>
    </header>

    <div class="container">
        <h1 id="titulo">Cadastro</h1>

        <form action="entrar.php" method="POST">
            <div class="form">
                <input type="text" name="nome" placeholder="NOME COMPLETO" required
                oninvalid="this.setCustomValidity('Por favor, preencha o nome.')"
                oninput="this.setCustomValidity('')">
                
                <input id="email" type="email" name="email" placeholder="E-MAIL" required>
               
                <input type="password" name="senha" placeholder="SENHA" required>
                
                <input type="password" name="confirmar_senha" placeholder="CONFIRMAR SENHA" required>
               
                <h2>Como devemos te chamar?</h2>
                
                <div class="opcoes">
                    <div class="grupo-checkbox">
                        <input id="um" type="radio" name="genero" value="ELE" required>
                        <label for="um">ELE</label>
                    </div>
                    <div class="grupo-checkbox">
                        <input id="dois" type="radio" name="genero" value="ELA">
                        <label for="dois">ELA</label>
                    </div>
                    <div class="grupo-checkbox">
                        <input id="tres" type="radio" name="genero" value="ELU">
                        <label for="tres">ELU</label>
                    </div>
                </div> 

                <div class="container-link">
                    <button class="botao-link" type="submit" name="submit">Enviar</button>
                </div>
                <div class="container-link-login" id="login">
                    <a href="login.php">Já tenho uma conta</a>
                </div>
            </div> 
        </form>
    </div> 
</body>
</html>