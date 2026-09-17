<?php
header('Content-Type: application/json; charset=utf-8');

$input = json_decode(file_get_contents('php://input'), true);
$input = is_array($input) ? $input : $_POST;
$username = trim((string) ($input['username'] ?? $input['userName'] ?? 'demo'));
$token = hash('sha256', 'cairo-city:' . $username);
$refreshToken = hash('sha256', 'cairo-city-refresh:' . $username);

echo json_encode([
  'status' => 'success',
  'success' => true,
  'message' => 'auth ok',
  'token' => $token,
  'access_token' => $token,
  'accessToken' => $token,
  'refresh_token' => $refreshToken,
  'refreshToken' => $refreshToken,
  'user_id' => 1,
  'userId' => 1,
  'username' => $username,
  'expires_in' => 86400,
  'expiresIn' => 86400,
  'token_type' => 'Bearer',
  'tokenType' => 'Bearer'
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
exit;
