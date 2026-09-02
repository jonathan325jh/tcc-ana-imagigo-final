<?php
session_start();

date_default_timezone_set('America/Sao_Paulo');

include_once(__DIR__ . '/config.php');

if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
    header('Location: entrar.php');
    exit();
}

if (isset($_POST['postar'])) {
    $mensagem = trim($_POST['mensagem']);
    $nomeUsuario = $_SESSION['nome'];
    $dataAtual = date('Y-m-d H:i:s');

    if (!empty($mensagem)) {
        $stmt = $conexao->prepare("INSERT INTO posts (usuario_nome, mensagem, data_criacao) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nomeUsuario, $mensagem, $dataAtual);
        $stmt->execute();
        $stmt->close();

        header("Location: forum.php?novo=1");
        exit();
    }
}

if (isset($_GET['apagar'])) {
    $idPost = (int)$_GET['apagar'];
    $nomeUsuario = $_SESSION['nome'];

    $stmt = $conexao->prepare("DELETE FROM posts WHERE id = ? AND usuario_nome = ?");
    $stmt->bind_param("is", $idPost, $nomeUsuario);
    $stmt->execute();
    $stmt->close();

    header("Location: forum.php");
    exit();
}

// Busca mensagens unindo com a tabela de usuários para obter o nível atualizado
$query = "SELECT posts.id, posts.usuario_nome, posts.mensagem, posts.data_criacao, COALESCE(usuarios.level, 0) AS level 
          FROM posts 
          LEFT JOIN usuarios ON posts.usuario_nome = usuarios.nome 
          ORDER BY posts.id DESC";

$resultado = mysqli_query($conexao, $query);
$primeiro = true;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fórum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="pagEntrada.css?v=1.0">
    <link rel="stylesheet" href="forum.css">
</head>
<body>

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

    <div class="container-entrada">
        <h2>Fórum da Comunidade</h2>

        <form action="forum.php" method="POST" class="form-post">
            <textarea name="mensagem" placeholder="Escreva sua mensagem aqui..." required class="input-mensagem"></textarea>
            <br><br>
            <button type="submit" name="postar" class="btn-publicar">Publicar</button>
        </form>

        <hr class="divisor">

        <div class="lista-posts">
        <?php if (mysqli_num_rows($resultado) > 0): ?>
            <?php while ($post = mysqli_fetch_assoc($resultado)): ?>
                <div class="card-post <?php if ($primeiro) { echo 'novo-post'; $primeiro = false; } ?>">
                    <p class="post-cabecalho">
                        <strong><?php echo htmlspecialchars($post['usuario_nome']); ?></strong>
                        <span class="badge bg-primary">Lvl <?php echo $post['level']; ?></span>
                        <small class="post-data">
                            (<?php 
                                $dataBanco = $post['data_criacao'];
                                if (!empty($dataBanco) && $dataBanco != '0000-00-00 00:00:00') {
                                    echo date('d/m/Y \à\s H:i', strtotime($dataBanco));
                                } else {
                                    echo date('d/m/Y \à\s H:i');
                                }
                            ?>)
                        </small>

                        <?php if ($post['usuario_nome'] === $_SESSION['nome']): ?>
                            <a class="btn btn-sm btn-danger float-end" href="forum.php?apagar=<?php echo $post['id']; ?>" onclick="return confirm('Tem certeza que deseja apagar este comentário?');" title="Deletar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                </svg>
                            </a>
                        <?php endif; ?>
                    </p>
                    <p class="post-conteudo">
                        <?php echo nl2br(htmlspecialchars($post['mensagem'])); ?>
                    </p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Nenhum comentário enviado ainda.</p>
        <?php endif; ?>
        </div>
    </div>

    <script>
    window.addEventListener('DOMContentLoaded', () => {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('novo')) {
            const containerPosts = document.querySelector('.lista-posts');
            if (containerPosts) {
                containerPosts.scrollTop = 0;
            }
        }
    });
    </script>
</body>
</html>