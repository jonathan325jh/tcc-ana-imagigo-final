 <?php
session_start();
header('Content-Type: application/json');

include_once(__DIR__ . '/config.php');

if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
    echo json_encode(['error' => 'Não autenticado']);
    exit();
}

$emailUsuario = $_SESSION['email'];

$userQuery = mysqli_query($conexao, "SELECT level, xp FROM usuarios WHERE email = '$emailUsuario'");
$userData = mysqli_fetch_assoc($userQuery);

if ($userData) {
    $level = (int)($userData['level'] ?? 0);
    $xp = (int)($userData['xp'] ?? 0);
    $xpAtual = $xp % 100;
    $porcentagemXp = min(100, max(0, $xpAtual));

    echo json_encode([
        'status' => 'success',
        'level' => $level,
        'xp' => $xp,
        'xpAtual' => $xpAtual,
        'porcentagemXp' => $porcentagemXp
    ]);
} else {
    echo json_encode(['error' => 'Usuário não encontrado']);
}