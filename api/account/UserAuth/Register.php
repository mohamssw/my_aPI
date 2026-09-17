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

$username = extract_first_value($input, ['username', 'user_name', 'userName', 'userid', 'user_id', 'userId', 'login', 'account', 'user']);
$email = extract_first_value($input, ['email', 'mail', 'email_address', 'emailAddress']);
if ($email === null || $email === '') {
    $email = $username ?? '';
}
$password = extract_first_value($input, ['password', 'pass', 'passwd', 'pwd', 'password1', 'passWord']);

if ($username === null || $username === '' || $email === '' || $password === null || $password === '') {
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
