<?php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../db.php';

$input = json_decode(file_get_contents('php://input'), true);
$input = is_array($input) ? $input : $_POST;
$input = array_merge($_GET, is_array($input) ? $input : []);
$normalized = [];
foreach ($input as $key => $value) {
    $normalized[strtolower((string) $key)] = $value;
}
$username = trim((string) ($normalized['username'] ?? $normalized['user_name'] ?? $normalized['userid'] ?? $normalized['user_id'] ?? $normalized['user'] ?? $normalized['login'] ?? $normalized['account'] ?? ''));
$email = trim((string) ($normalized['email'] ?? $normalized['mail'] ?? $normalized['email_address'] ?? $username));
$password = (string) ($normalized['password'] ?? $normalized['pass'] ?? $normalized['passwd'] ?? $normalized['pwd'] ?? $normalized['password1'] ?? '');

if ($username === '' || $email === '' || $password === '') {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'success' => false, 'message' => 'username, email and password are required']);
    exit;
}

try {
    $database = database();
    $query = $database->prepare('INSERT INTO users (username, email, password_hash, balance, created_at) VALUES (:username, :email, :password_hash, 0, NOW()) RETURNING id');
    $query->execute([
        'username' => $username,
        'email' => $email,
        'password_hash' => password_hash($password, PASSWORD_DEFAULT)
    ]);
    $userId = (int) $query->fetchColumn();
    echo json_encode([
        'status' => 'success',
        'success' => true,
        'code' => 200,
        'message' => 'account created',
        'result' => true,
        'user_id' => $userId,
        'id' => $userId,
        'data' => ['user_id' => $userId, 'id' => $userId, 'username' => $username, 'email' => $email]
    ]);
} catch (PDOException $error) {
    http_response_code($error->getCode() === '23505' ? 409 : 503);
    echo json_encode(['status' => 'error', 'success' => false, 'message' => 'account could not be created']);
}
