<?php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../db.php';

function extract_first_value(array $source, array $keys): ?string
{
    $stack = [$source];

    while (!empty($stack)) {
        $current = array_pop($stack);
        if (!is_array($current)) {
            continue;
        }

        foreach ($current as $key => $value) {
            $normalizedKey = strtolower((string) $key);
            if (in_array($normalizedKey, $keys, true)) {
                if (is_array($value)) {
                    $nested = extract_first_value($value, $keys);
                    if ($nested !== null) {
                        return trim((string) $nested);
                    }
                    continue;
                }

                return trim((string) $value);
            }

            if (is_array($value)) {
                $stack[] = $value;
            }
        }
    }

    return null;
}

$rawBody = trim((string) file_get_contents('php://input'));
$input = [];
if ($rawBody !== '') {
    $decoded = json_decode($rawBody, true);
    if (is_array($decoded)) {
        $input = $decoded;
    } else {
        parse_str($rawBody, $parsed);
        if (is_array($parsed)) {
            $input = $parsed;
        }
    }
}
if (!is_array($input) || count($input) === 0) {
    $input = $_POST;
}
if (!is_array($input)) {
    $input = [];
}
$input = array_merge($_GET, $_POST, $_REQUEST, $input);

$login = extract_first_value($input, ['username', 'user_name', 'userName', 'userid', 'user_id', 'userId', 'login', 'email', 'mobile', 'phone', 'account', 'user']);
$password = extract_first_value($input, ['password', 'pass', 'passwd', 'pwd', 'password1', 'passWord']);

if ($login === null || $login === '' || $password === null || $password === '') {
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
        'user_id' => (int) $user['id'],
        'id' => (int) $user['id'],
        'data' => ['user' => $profile, 'userData' => $profile, 'id' => (int) $user['id'], 'user_id' => (int) $user['id']],
        'user' => $profile,
        'userData' => $profile
    ], JSON_UNESCAPED_SLASHES);
} catch (Throwable $error) {
    http_response_code(503);
    echo json_encode(['status' => 'error', 'success' => false, 'message' => 'database unavailable']);
}
