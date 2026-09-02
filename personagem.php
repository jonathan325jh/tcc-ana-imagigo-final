<?php
session_start();
include_once(__DIR__ . '/config.php');

if (!isset($_SESSION['email'])) {
    header('Location: entrar.php');
    exit();
}

$email = $_SESSION['email'];
$query = mysqli_query($conexao, "SELECT * FROM usuarios WHERE email = '$email'");
$user = mysqli_fetch_assoc($query);

$cor1 = $user['cor_1'] ?? '#4a7bc7';
$cor2 = $user['cor_2'] ?? '#ff0000';
$pronome = $user['pronome'] ?? '';
$nomePersonagem = $user['nome_personagem'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Customizador de Personagem</title>
    <link rel="stylesheet" href="personagem.css">
    <style>
        .boneco-area {
            position: relative;
            display: inline-block;
            overflow: visible;
        }
        #video-fundo {
            position: absolute;
            top: -20px;
            left: -20px;
            width: calc(100% + 40px);
            height: calc(100% + 40px);
            object-fit: cover;
            z-index: 1;
            display: none;
            pointer-events: none;
            border-radius: 12px;
        }
        #boneco-svg {
            position: relative;
            z-index: 2;
            overflow: visible;
            pointer-events: none;
        }
        #boneco-svg image {
            pointer-events: none;
        }
    </style>
</head>
<body class="corpito">

<div class="customizador-wrapper">
    <div class="header-info-esquerda">
        <h1 class="titulo-personagem" id="titulo-nome"><?php echo htmlspecialchars($nomePersonagem); ?></h1>
        <span class="nivel-tag">LV50</span>
    </div>

    <div class="voltar-dois">
        <a href="" onclick="history.back(); return false;">
            <img src="voltar-bt.png" id="voltar" alt="Voltar">
        </a>
        <img src="tres-pontos-azul-btn.png" id="tres-pontos" alt="Opções">
    </div>

    <div class="conteudo-principal">
        <div class="container-esq">
            <div class="boneco-area">
                <video id="video-fundo" autoplay loop muted playsinline></video>

                <svg id="boneco-svg" width="285" height="388" viewBox="0 0 200 280">
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

                    <image id="img-animacao" x="-20" y="-20" width="240" height="320" href="" />

                    <circle cx="100" cy="40" r="18" class="cor-corpo" fill="<?php echo $cor1; ?>" />
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
                    C 138,72 125,60 100,60 Z" class="cor-corpo" fill="<?php echo $cor1; ?>" />

                    <g id="grupo-estampa" clip-path="url(#recorte-corpo)"></g>
                    <image id="img-roupa" x="33" y="35" width="140" height="170" href="" />
                    <image id="img-chapeu" x="70" y="2" width="60" height="46" href="" />
                </svg>
            </div>

            <div class="sombra"></div>

            <input type="text" id="input-nome" class="input-nome" placeholder="Nome......" value="<?php echo htmlspecialchars($nomePersonagem); ?>" style="position: relative; z-index: 10;">
        </div>

        <div class="painel-container-externo">
            <div class="painel">
                <div class="linha custom-container">
                    <span class="label-visual">Pronomes:</span>
                    <select id="pronome">
                        <option value="" <?php if(empty($pronome)) echo 'selected'; ?>>Selecione</option>
                        <option value="Ele/Dele" <?php if($pronome == 'Ele/Dele') echo 'selected'; ?>>Ele/Dele</option>
                        <option value="Ela/Dela" <?php if($pronome == 'Ela/Dela') echo 'selected'; ?>>Ela/Dela</option>
                        <option value="Elu/Delu" <?php if($pronome == 'Elu/Delu') echo 'selected'; ?>>Elu/Delu</option>
                        <option value="Outros" <?php if($pronome == 'Outros') echo 'selected'; ?>>Outros</option>
                    </select>
                </div>

                <div class="linha">
                    <span class="label-visual">Cor 1:</span>
                    <input type="color" id="picker-c1" value="<?php echo $cor1; ?>">
                </div>

                <div class="linha">
                    <span class="label-visual">Cor 2:</span>
                    <input type="color" id="picker-c2" value="<?php echo $cor2; ?>">
                </div>

                <div class="linha">
                    <span class="label-visual">Estilo:</span>
                    <select id="sel-estampa">
                        <option value="nenhuma" selected>Nenhuma</option>
                        <option value="bolinhas">Bolinhas</option>
                        <option value="linhas">Linhas</option>
                    </select>
                </div>

                <div class="linha">
                    <span class="label-visual">Roupa:</span>
                    <select id="sel-roupa">
                        <option value="nenhuma" selected>Nenhuma</option>
                        <option value="camiseta">Camiseta</option>
                        <option value="jaqueta">Jaqueta</option>
                    </select>
                </div>

                <div class="linha">
                    <span class="label-visual">Chapéu:</span>
                    <select id="sel-chapeu">
                        <option value="nenhum" selected>Nenhum</option>
                        <option value="bone">Boné</option>
                        <option value="festa">Chapéu de Festa</option>
                    </select>
                </div>

                <div class="linha">
                    <span class="label-visual">Partículas:</span>
                    <select id="sel-animacao">
                        <option value="nenhuma" selected>Nenhuma</option>
                        <option value="fogo">Aura de Fogo (MP4)</option>
                        <option value="brilho">Brilho / Estrelas (GIF)</option>
                    </select>
                </div>

                <button type="button" id="btnSalvar" class="btn-salvar" onclick="salvarPersonagem()">Salvar Personagem</button>
            </div>
        </div>
    </div>
</div>

<script>
const CAMINHO_ROUPAS = {
    'nenhuma': '',
    'camiseta': 'camisa.png',
    'jaqueta': 'img/roupas/jaqueta.png'
};

const CAMINHO_CHAPEUS = {
    'nenhum': '',
    'bone': 'chapeu.png',
    'festa': 'img/chapeus/chapeu-festa.png'
};

const CAMINHO_AURAS = {
    'nenhuma': '',
    'fogo': 'animacao.gif',
    'brilho': 'img/auras/aura-brilho.gif'
};

document.addEventListener('DOMContentLoaded', () => {
    const picker1 = document.getElementById('picker-c1');
    const picker2 = document.getElementById('picker-c2');
    const selEstampa = document.getElementById('sel-estampa');
    const selRoupa = document.getElementById('sel-roupa');
    const selChapeu = document.getElementById('sel-chapeu');
    const selAnimacao = document.getElementById('sel-animacao');
    const inputNome = document.getElementById('input-nome');
    const tituloNome = document.getElementById('titulo-nome');

    const partesCorpo = document.querySelectorAll('.cor-corpo');
    const grupoEstampa = document.getElementById('grupo-estampa');
    const imgRoupa = document.getElementById('img-roupa');
    const imgChapeu = document.getElementById('img-chapeu');
    const imgAnimacao = document.getElementById('img-animacao');
    const videoFundo = document.getElementById('video-fundo');

    inputNome.addEventListener('input', (e) => {
        tituloNome.textContent = e.target.value || '';
    });

    function atualizarCorCorpo(cor) {
        partesCorpo.forEach(el => {
            el.setAttribute('fill', cor);
            el.style.fill = cor;
        });
    }

    function atualizarEstampa() {
        grupoEstampa.innerHTML = '';
        const tipo = selEstampa.value;
        const cor = picker2.value;

        if (tipo === 'bolinhas') {
            const pos = [
                {cx: 80, cy: 90, r: 8}, {cx: 120, cy: 110, r: 12},
                {cx: 95, cy: 140, r: 10}, {cx: 110, cy: 180, r: 9}
            ];
            pos.forEach(p => {
                const c = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
                c.setAttribute('cx', p.cx); 
                c.setAttribute('cy', p.cy);
                c.setAttribute('r', p.r); 
                c.setAttribute('fill', cor);
                c.style.fill = cor;
                grupoEstampa.appendChild(c);
            });
        } else if (tipo === 'linhas') {
            const espacamento = 16; 
            const espessura = 5;     

            for (let offset = -250; offset < 400; offset += espacamento) {
                const linha = document.createElementNS('http://www.w3.org/2000/svg', 'line');
                linha.setAttribute('x1', offset + 250);
                linha.setAttribute('y1', 0);
                linha.setAttribute('x2', offset);
                linha.setAttribute('y2', 280);
                linha.setAttribute('stroke', cor);
                linha.setAttribute('stroke-width', espessura);
                linha.style.stroke = cor;
                grupoEstampa.appendChild(linha);
            }
        }
    }

    function atualizarMidias() {
        imgRoupa.setAttribute('href', CAMINHO_ROUPAS[selRoupa.value] || '');
        imgChapeu.setAttribute('href', CAMINHO_CHAPEUS[selChapeu.value] || '');

        const anim = CAMINHO_AURAS[selAnimacao.value] || '';
        
        if (anim.endsWith('.mp4')) {
            imgAnimacao.setAttribute('href', '');
            videoFundo.src = anim;
            videoFundo.style.display = 'block';
            videoFundo.play();
        } else {
            videoFundo.pause();
            videoFundo.src = '';
            videoFundo.style.display = 'none';
            imgAnimacao.setAttribute('href', anim);
        }
    }

    picker1.addEventListener('input', (e) => atualizarCorCorpo(e.target.value));
    picker1.addEventListener('change', (e) => atualizarCorCorpo(e.target.value));

    picker2.addEventListener('input', atualizarEstampa);
    picker2.addEventListener('change', atualizarEstampa);

    selEstampa.addEventListener('change', atualizarEstampa);
    selRoupa.addEventListener('change', atualizarMidias);
    selChapeu.addEventListener('change', atualizarMidias);
    selAnimacao.addEventListener('change', atualizarMidias);

    atualizarCorCorpo(picker1.value);
    atualizarEstampa();
    atualizarMidias();
});

function salvarPersonagem() {
    const btn = document.getElementById('btnSalvar');
    btn.disabled = true;

    const formData = new FormData();
    formData.append('nome', document.getElementById('input-nome').value);
    formData.append('cor_1', document.getElementById('picker-c1').value);
    formData.append('cor_2', document.getElementById('picker-c2').value);
    formData.append('pronome', document.getElementById('pronome').value);
    formData.append('estampa', document.getElementById('sel-estampa').value);
    formData.append('roupa', document.getElementById('sel-roupa').value);
    formData.append('chapeu', document.getElementById('sel-chapeu').value);
    formData.append('animacao_fundo', document.getElementById('sel-animacao').value);

    fetch('salvar-customizacao.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if(data.status === 'success') {
            window.location.href = 'pagina-entrada.php';
        } else {
            alert('Erro ao salvar: ' + (data.message || 'Falha no banco de dados.'));
            btn.disabled = false;
        }
    })
    .catch(err => {
        alert('Erro de conexão ou resposta inválida do servidor.');
        console.error(err);
        btn.disabled = false;
    });
}
</script>
</body>
</html>