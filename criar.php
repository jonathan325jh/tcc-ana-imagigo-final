<?php
session_start();
include_once(__DIR__ . '/config.php');

if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
    header('Location: entrar.php');
    exit();
}

$emailUsuario = $_SESSION['email'];

$userQuery = mysqli_query($conexao, "SELECT nome, level, xp FROM usuarios WHERE email = '$emailUsuario'");
$userData = mysqli_fetch_assoc($userQuery);

$nomeUsuario = $userData['nome'] ?? 'Usuário';
$level = $userData['level'] ?? 0;
$xp = $userData['xp'] ?? 0;

$xpAtualNoNivel = $xp % 100;
$xpParaProximoNivel = 100;
$porcentagemXp = min(100, max(0, ($xpAtualNoNivel / $xpParaProximoNivel) * 100));

$temInsigniaVerde = ($level >= 100);
$temInsigniaLaranja = ($level >= 300);
$temInsigniaAzul = ($level >= 500);
$temInsigniaRosa = ($level >= 900);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="criar.css">
    <title>Perfil e Customização</title>
</head>
<body class="corpito">

    <header>
        <a href="pagina-entrada.php" id="inicio">INÍCIO</a>
        <a href="" id="config">CONFIGURAÇÃO</a>
        
        <img src="foto-logo.png" alt="Logo" class="logo-img">
        
        <a href="sobre-nos.html" id="sobre">SOBRE NÓS</a>
        <a href="suporte.html" id="suporte">SUPORTE</a>

        <a href="perfil.php">
            <img src="perfil.png" id="perfil" alt="Perfil">
        </a>
    </header>

    <div class="conteudo-principal">

        <div class="container">
            <div class="boneco-area">
                <svg id="boneco-svg" width="300" height="420" viewBox="0 0 200 280" fill="#ffcc66">
                    <defs>
                        <clipPath id="recorte-corpo">
                            <path d="
                            M 100,60 
                            C 75,60 62,72 44,100 
                            C 35,114 47,128 55,115 
                            C 65,99 71,90 76,94 
                            C 73,115 67,155 62,215 
                            C 60,228 76,228 78,215 
                            C 84,175 92,142 100,142 
                            C 108,142 116,175 122,215 
                            C 124,228 140,228 138,215 
                            C 133,155 127,115 124,94 
                            C 129,90 135,99 145,115 
                            C 153,128 165,114 156,100 
                            C 138,72 125,60 100,60 Z" />
                        </clipPath>
                    </defs>
                    <circle cx="100" cy="40" r="18" class="cor-corpo" />
                    <path d="
                    M 100,60 
                    C 75,60 62,72 44,100 
                    C 35,114 47,128 55,115 
                    C 65,99 71,90 76,94 
                    C 73,115 67,155 62,215 
                    C 60,228 76,228 78,215 
                    C 84,175 92,142 100,142 
                    C 108,142 116,175 122,215 
                    C 124,228 140,228 138,215 
                    C 133,155 127,115 124,94 
                    C 129,90 135,99 145,115 
                    C 153,128 165,114 156,100 
                    C 138,72 125,60 100,60 Z" class="cor-corpo" />
                    <g id="grupo-bolinhas" clip-path="url(#recorte-corpo)"></g>
                </svg>
                <div class="sombra"></div>
            </div>
        </div>

        <div class="coluna-formulario">
            <div class="formulario">
                <div class="form-itens">
                    <div class="perfil-topo">
                        <img src="foto-login.png" id="foto-logo" alt="Foto Perfil">
                        <div class="perfil-texto">
                            <h1><?php echo htmlspecialchars($nomeUsuario); ?></h1>
                            <p>Level <?php echo $level; ?></p>
                            
                            <div class="container-barra-xp">
                                <div class="barra-xp-fundo">
                                    <div class="barra-xp-progresso" style="width: <?php echo $porcentagemXp; ?>%;"></div>
                                </div>
                                <span class="texto-xp"><?php echo $xpAtualNoNivel; ?> / <?php echo $xpParaProximoNivel; ?> XP</span>
                            </div>
                        </div>
                    </div>

                    <div class="baixo">
                        <h2>Insígnias</h2>
                        <div class="circulos">
                            <svg width="65" height="65" viewBox="0 0 100 100" class="<?php echo $temInsigniaVerde ? 'insignia-ativa' : 'insignia-bloqueada'; ?>">
                                <circle cx="50" cy="50" r="40" stroke="<?php echo $temInsigniaVerde ? '#2ecc71' : '#ccc'; ?>" stroke-width="4" fill="<?php echo $temInsigniaVerde ? '#2ecc7122' : 'none'; ?>"/>
                            </svg>
                            <svg width="65" height="65" viewBox="0 0 100 100" class="<?php echo $temInsigniaLaranja ? 'insignia-ativa' : 'insignia-bloqueada'; ?>">
                                <circle cx="50" cy="50" r="40" stroke="<?php echo $temInsigniaLaranja ? '#e67e22' : '#ccc'; ?>" stroke-width="4" fill="<?php echo $temInsigniaLaranja ? '#e67e2222' : 'none'; ?>"/>
                            </svg>
                            <svg width="65" height="65" viewBox="0 0 100 100" class="<?php echo $temInsigniaAzul ? 'insignia-ativa' : 'insignia-bloqueada'; ?>">
                                <circle cx="50" cy="50" r="40" stroke="<?php echo $temInsigniaAzul ? '#3498db' : '#ccc'; ?>" stroke-width="4" fill="<?php echo $temInsigniaAzul ? '#3498db22' : 'none'; ?>"/>
                            </svg>
                            <svg width="65" height="65" viewBox="0 0 100 100" class="<?php echo $temInsigniaRosa ? 'insignia-ativa' : 'insignia-bloqueada'; ?>">
                                <circle cx="50" cy="50" r="40" stroke="<?php echo $temInsigniaRosa ? '#e91e63' : '#ccc'; ?>" stroke-width="4" fill="<?php echo $temInsigniaRosa ? '#e91e6322' : 'none'; ?>"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="botao-custom">
                <a href="personagem.php">
                    <button type="button">Customizar</button>
                </a>
            </div>
        </div>

    </div>

    <div class="botoes-pao">
        <a href="tutoriais.php" id="tutoriais">Tutoriais</a>
        <a href="forum.php" id="forum">Fórum</a>
        <a href="" id="banco">Banco</a>
        <a href="" id="gestao">Gestão</a>
    </div>

</body>
</html>