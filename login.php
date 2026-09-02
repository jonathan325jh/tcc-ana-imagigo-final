<?php
session_start();
include_once(__DIR__ . '/config.php');

if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    if (isset($conexao) && $conexao) {
        $result = mysqli_query($conexao, "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'");

        if(mysqli_num_rows($result) > 0) {
            $usuario = mysqli_fetch_assoc($result);

            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['email'] = $usuario['email'];

            header('Location: pagina-entrada.php');
            exit();
        } else {
            $erro = "E-mail ou senha incorretos!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css?v=1.0">
    <title>Tela de login</title>
</head>
<body>
    <a href="home.php">Voltar</a>
    <div>
        <h1>Login</h1>

        <?php if(isset($erro)): ?>
            <p style="color: red;"><?php echo $erro; ?></p>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <input type="text" name="email" placeholder="Email" required>
            <br><br>
            <input type="password" name="senha" placeholder="Senha" required>
            <br><br>
            <input class="inputSubmit" type="submit" name="submit" value="Enviar">
        </form>
    </div>
</body>
</html>