<?php
session_start();
include_once(__DIR__ . '/config.php');

if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
    header('Location: entrar.php');
    exit();
}

$emailUsuario = $_SESSION['email'];

$userQuery = mysqli_query($conexao, "SELECT nome, email, level FROM usuarios WHERE email = '$emailUsuario'");
$userData = mysqli_fetch_assoc($userQuery);

$nome = $userData['nome'] ?? 'Usuário';
$email = $userData['email'] ?? $emailUsuario;
$level = (int)($userData['level'] ?? 0);

// Insígnias desbloqueadas com base no nível
$insignias = [];
if ($level >= 100) $insignias[] = ['nome' => 'Iniciante', 'classe' => 'insignia-verde'];
if ($level >= 300) $insignias[] = ['nome' => 'Intermediário', 'classe' => 'insignia-laranja'];
if ($level >= 500) $insignias[] = ['nome' => 'Avançado', 'classe' => 'insignia-azul'];
if ($level >= 900) $insignias[] = ['nome' => 'Mestre', 'classe' => 'insignia-rosa'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="perfil.css?v=3.0"> 
    <title>Perfil</title>
</head>
<body>

    <header class="header-lateral">
        <a href="pagina-entrada.php">
            <img src="voltar-bt.png" id="voltar" alt="Voltar">
        </a>
        <img src="tres-pontos.png" id="tres-pontos" alt="Opções">
    </header>

    <main class="container">
        <div class="pri-parte">
            <!-- Imagem do usuário sem fundo de container -->
            <img src="foto-login.png" id="login" alt="Foto de Perfil">
            
            <h3><?php echo htmlspecialchars($nome); ?></h3>
            <p class="email-texto"><?php echo htmlspecialchars($email); ?></p>

            <!-- Seção de Insígnias -->
            <div class="habilidades">
                <h2>Insígnias</h2>
                <div class="circulos">
                    <?php if (count($insignias) > 0): ?>
                        <?php foreach ($insignias as $item): ?>
                            <div class="insignia-item <?php echo $item['classe']; ?>" title="<?php echo $item['nome']; ?>"></div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="sem-insignia">Você ainda não possui insígnias.</p>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="botoes-rodape">
                <a id="sair" href="sair.php">
                    <button type="button">Sair</button>
                </a>
                <a id="termo" href="termos.html">TERMOS DE USO</a>
            </div>
        </div>
    </main>

</body>
</html>