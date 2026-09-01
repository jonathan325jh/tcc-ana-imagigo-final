<?php
session_start();
header('Content-Type: application/json');
include_once(__DIR__ . '/config.php');

// Verifica sessão
if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
    echo json_encode(['success' => false, 'message' => 'Não autenticado']);
    exit();
}

// Recebe os dados em formato JSON
$input = json_decode(file_get_contents('php://input'), true);
$xpAdicionar = isset($input['xp']) ? intval($input['xp']) : 0;

if ($xpAdicionar <= 0) {
    echo json_encode(['success' => false, 'message' => 'Quantidade de XP inválida']);
    exit();
}

$email = $_SESSION['email'];
$queryUser = mysqli_query($conexao, "SELECT xp, level FROM usuarios WHERE email = '$email'");

if ($queryUser && mysqli_num_rows($queryUser) > 0) {
    $usuario = mysqli_fetch_assoc($queryUser);
    $xpAtual = intval($usuario['xp']);
    $levelAtual = intval($usuario['level']);

    $novoXP = $xpAtual + $xpAdicionar;
    $xpNecessarioProximoNivel = $levelAtual * 100;
    $subiuLevel = false;
    $novoLevel = $levelAtual;

    if ($novoXP >= $xpNecessarioProximoNivel) {
        $novoLevel += 1;
        $subiuLevel = true;
    }

    $update = mysqli_query($conexao, "UPDATE usuarios SET xp = '$novoXP', level = '$novoLevel' WHERE email = '$email'");

    if ($update) {
        echo json_encode([
            'success' => true,
            'novoXP' => $novoXP,
            'novoLevel' => $novoLevel,
            'subiuLevel' => $subiuLevel
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao atualizar no banco']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Usuário não encontrado']);
}
?>