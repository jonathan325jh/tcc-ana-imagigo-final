<?php
session_start();
include_once(__DIR__ . '/config.php');

if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
    header('Location: entrar.php');
    exit();
}

$usuarioLogado = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="conserto.css">
    <title>Compras de Supermercado</title>
    <style>
        /* Estilos das Notificações de XP */
        #container-notificacao {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 12px;
            max-width: 350px;
            width: calc(100% - 40px);
            pointer-events: none;
        }

        .toast-xp {
            pointer-events: auto;
            position: relative;
            display: flex;
            align-items: center;
            gap: 14px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            color: #2b2b2b;
            padding: 14px 18px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12), 0 4px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.6);
            overflow: hidden;
            transform: translateX(120%);
            animation: slideIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
            font-family: system-ui, -apple-system, sans-serif;
        }

        .toast-icone {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, #28a745, #20c997);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
            box-shadow: 0 4px 10px rgba(40, 167, 69, 0.3);
        }

        .toast-conteudo {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .toast-titulo {
            font-size: 15px;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 2px;
        }

        .toast-subtitulo {
            font-size: 13px;
            color: #64748b;
            font-weight: 500;
        }

        .toast-level .toast-icone {
            background: linear-gradient(135deg, #ffb703, #fb8500);
            box-shadow: 0 4px 10px rgba(251, 133, 0, 0.4);
        }

        .toast-level {
            border-left: 5px solid #fb8500;
        }

        .toast-fechar {
            background: none;
            border: none;
            color: #94a3b8;
            font-size: 18px;
            cursor: pointer;
            padding: 0 4px;
        }

        .toast-barra-progresso {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 4px;
            background: #28a745;
            width: 100%;
            animation: encolherBarra 7s linear forwards;
        }

        .toast-level .toast-barra-progresso {
            background: #fb8500;
        }

        @keyframes slideIn {
            to { transform: translateX(0); }
        }

        @keyframes slideOut {
            to { transform: translateX(130%); opacity: 0; }
        }

        @keyframes encolherBarra {
            from { width: 100%; }
            to { width: 0%; }
        }

        /* Seus estilos originais */
        #segundo-h3 {
            margin-left: 15rem;
        }

        h3 {
            color: #ff0077;
            border: none;
            font-size: 3rem;
            position: relative;
            right: 30rem;
            margin-top: 3rem;
        }

        #segundo-para {
            font-size: 2rem;
            color: #33333396;
        }

        .p-titulo-para {
            font-size: 90rem;
            color: #ff0077;
            font-family: Arial, sans-serif;
            letter-spacing: 2px;
            text-shadow: 2px 2px 3px #e24a6be2;
        }

        #para-titulo {
            font-size: 3rem;
            margin: right;
        }

        .btn-2{
            background-color: #bcc4f9;
            border: 4px solid #96a3fc;
        }

        .img-receita img{
            border: 4px solid #96a3fc;
        }
    </style>
</head>

<body class="fundo-receita">
    <header>
        <div class="volta-dois">
            <a href="" onclick="history.back(); return false;">
                <img src="voltar-bt.png" id="voltar" alt="Voltar">
            </a>
            <img src="tres-pontos-azul-btn.png" id="tres-pontos" alt="Opções">
        </div>
    </header>

    <div class="container-receitas">
        <h1>Finanças</h1>

        <div class="img-receita">
            <img src="lista de supermercado.png" alt="Compras de Supermercado">
        </div>

        <div class="textos">
            <p class="p-titulo">Como fazer compras de supermercado inteligentes:</p>

            <div class="btn-paragrafo">
                <p class="btn-1">Economia</p>
                <br>
                <p id="btn-financas" class="btn-2">Finanças</p>
            </div>
            <br>

            <p id="segundo-para">Uso de lista, comparação de preço por litro/quilo e marcas próprias.</p>
        </div>

        <div class="segunda-parte">
            <h3 id="segundo-h3">O Pré-Supermercado (A Preparação)</h3>

            <p id="segundo-para">A maior parte do dinheiro é perdida antes mesmo de você sair de casa.</p>

            <ul>
                <li><b>Faça o inventário reversível:</b> Nunca vá ao mercado sem olhar o fundo da despensa <br>
                  e da geladeira. Monte o cardápio da semana com base nos ingredientes que já vão vencer.</li>
                <br>
                <li><b>Defina a lista rígida:</b> Divida sua lista por categorias (hortifrúti, açougue, <br>
                   limpeza, mercearia) para economizar tempo. Se não está na lista, não entra no carrinho.</li>
                <br>
                <li><b>Alimente-se antes:</b> Nunca faça compras com fome. Biologicamente, a fome faz <br>
                  você comprar alimentos ultraprocessados, mais caros e em maior quantidade por impulso.</li>
            </ul>

            <h3 id="segundo-h3">No Corredor (Táticas de Consumo)</h3>

            <p id="segundo-para">Os supermercados são projetados psicologicamente para fazer você gastar <br>
               mais. Use a lógica para se defender:</p>

            <ul>
                <li><b>A Regra do "Olhe para Cima e para Baixo":</b> Os produtos mais caros e de marcas <br>
                   famosas ficam sempre posicionados na altura dos seus olhos. As marcas próprias do <br>
                    mercado e os produtos mais baratos ficam nas prateleiras de baixo ou do topo.</li>
                <br>
                <li><b>Calcule o preço por quilo/litro:</b> Nem sempre a embalagem maior (tamanho "família") <br>
                   é a mais barata. Olhe a etiqueta de preço na prateleira com atenção: por lei, ela deve <br>
                   exibir o valor proporcional por kg ou por litro. Use isso para comparar marcas de tamanhos <br>
                    diferentes.</li>
                <br>
                <li><b>Evite os produtos de conveniência:</b> Alimentos já picados, lavados ou temperados <br>
                   (como bandejas de alho descascado ou bifes já temperados) podem custar até o dobro do <br>
                    preço do produto in natura.</li>
            </ul>

            <h3 id="segundo-h3">Cronograma e Frequência</h3>

            <p id="segundo-para">A frequência das suas visitas dita o tamanho do seu gasto. Evite compras <br>
               mensais gigantes, pois geram desperdício de alimentos perecíveis que estragam na geladeira.</p>

            <p><b>Adote o modelo híbrido:</b></p>
            <ul>
                <li><b>Mensal/Quinzenal:</b> Produtos de limpeza, higiene e mercearia não perecível (arroz, <br>
                   feijão, óleo).</li>
                <br>
                <li><b>Semanal:</b> Hortifrúti e proteínas frescas.</li>
                <br>
                <li><b>Aproveite os dias temáticos:</b> Descubra os dias de promoção fixa do seu mercado <br>
                   local (geralmente Terça ou Quarta do Hortifrúti e Quinta do Açougue) e programe suas <br>
                    compras para essas datas.</li>
            </ul>

            <h3 id="segundo-h3">O Perigo das "Promoções" e Aplicativos</h3>

            <ul>
                <li><b>A armadilha do "Leve 3, Pague 2":</b> Só vale a pena se for um produto não perecível <br>
                   que você já usa rotineiramente (como papel higiênico ou sabão em pó). Comprar itens <br>
                    supérfluos só porque estão em promoção é gastar dinheiro que você não precisava.</li>
                <br>
                <li><b>Use os aplicativos de fidelidade:</b> Quase todas as grandes redes possuem aplicativos <br>
                   de desconto próprios. Antes de passar no caixa, ative os cupons no app. Mas atenção: use <br>
                    apenas para os itens que você já ia comprar de qualquer forma.</li>
            </ul>
        </div>
    </div>

    <!-- Container das Notificações -->
    <div id="container-notificacao"></div>

    <br><br>

    <script>
        function exibirNotificacao(titulo, subtitulo, icone = '⚡', ehLevelUp = false) {
            const container = document.getElementById('container-notificacao');
            if (!container) return;
            
            const toast = document.createElement('div');
            toast.className = `toast-xp ${ehLevelUp ? 'toast-level' : ''}`;
            
            toast.innerHTML = `
                <div class="toast-icone">${icone}</div>
                <div class="toast-conteudo">
                    <span class="toast-titulo">${titulo}</span>
                    <span class="toast-subtitulo">${subtitulo}</span>
                </div>
                <button class="toast-fechar" onclick="fecharToast(this.parentElement)">&times;</button>
                <div class="toast-barra-progresso"></div>
            `;

            container.appendChild(toast);
            setTimeout(() => {
                fecharToast(toast);
            }, 7000);
        }

        function fecharToast(toastElement) {
            if (!toastElement) return;
            toastElement.style.animation = 'slideOut 0.4s ease forwards';
            setTimeout(() => {
                toastElement.remove();
            }, 400);
        }

        function adicionarXP(quantidade, motivo) {
            fetch('adicionar_xp.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ xp: quantidade })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    exibirNotificacao(`+${quantidade} XP Conquistados!`, motivo, '⭐');
                    
                    if (data.subiuLevel) {
                        setTimeout(() => {
                            exibirNotificacao(`NÍVEL ALCANÇADO! 🎉`, `Você subiu para o Level ${data.novoLevel}!`, '🏆', true);
                        }, 600);
                    }
                } else {
                    console.warn('Servidor retornou erro:', data.message);
                }
            })
            .catch(err => console.error('Erro na requisição Fetch:', err));
        }

        const usuarioAtual = "<?php echo addslashes($usuarioLogado); ?>";
        const idArtigo = 'financas_compras_supermercado';
        const chaveStorage = `xp_lido_${usuarioAtual}_${idArtigo}`;

        document.addEventListener('DOMContentLoaded', () => {
            if (!localStorage.getItem(chaveStorage)) {
                localStorage.setItem(chaveStorage, 'true');
                adicionarXP(25, 'Por aprender sobre Compras de Supermercado!');
            }
        });
    </script>
</body>
</html>