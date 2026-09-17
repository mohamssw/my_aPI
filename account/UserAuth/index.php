<?php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../db.php';

$input = json_decode(file_get_contents('php://input'), true);
$input = is_array($input) ? $input : $_POST;
$login = trim((string) ($input['username'] ?? $input['userName'] ?? $input['login'] ?? $input['email'] ?? ''));
$password = (string) ($input['password'] ?? $input['pass'] ?? '');

if ($login === '' || $password === '') {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'success' => false, 'message' => 'username and password are required']);
    exit;
}

try {
    $database = database();
    $query = $database->prepare('SELECT id, username, email, password_hash, balance FROM users WHERE username = :login OR email = :login LIMIT 1');
    $query->execute(['login' => $login]);
    $user = $query->fetch();

    if (!$user || !password_verify($password, (string) $user['password_hash'])) {
        http_response_code(401);
        echo json_encode(['status' => 'error', 'success' => false, 'message' => 'incorrect username or password']);
        exit;
    }

    $token = hash('sha256', 'cairo-city:' . $user['id'] . ':' . $user['username']);
    $refreshToken = hash('sha256', 'cairo-city-refresh:' . $user['id'] . ':' . $user['username']);
    $profile = [
        'id' => (int) $user['id'],
        'user_id' => (int) $user['id'],
        'userId' => (int) $user['id'],
        'username' => $user['username'],
        'email' => $user['email'],
        'balance' => (float) $user['balance']
    ];

    echo json_encode([
        'status' => 'success',
        'success' => true,
        'isSuccess' => true,
        'code' => 200,
        'result' => true,
        'message' => 'auth ok',
        'token' => $token,
        'access_token' => $token,
        'accessToken' => $token,
        'refresh_token' => $refreshToken,
        'refreshToken' => $refreshToken,
        'token_type' => 'Bearer',
        'tokenType' => 'Bearer',
        'expires_in' => 86400,
        'expiresIn' => 86400,
        'data' => ['user' => $profile, 'userData' => $profile],
        'user' => $profile,
        'userData' => $profile
    ], JSON_UNESCAPED_SLASHES);
} catch (Throwable $error) {
    http_response_code(503);
    echo json_encode(['status' => 'error', 'success' => false, 'message' => 'database unavailable']);
}
