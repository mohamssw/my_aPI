<?php
header('Content-Type: application/json; charset=utf-8');

$token = hash('sha256', 'cairo-city:demo');
$refreshToken = hash('sha256', 'cairo-city-refresh:demo');

echo json_encode([
  'status' => 'success',
  'success' => true,
  'message' => 'token refreshed',
  'token' => $token,
  'access_token' => $token,
  'accessToken' => $token,
  'refresh_token' => $refreshToken,
  'refreshToken' => $refreshToken,
  'expires_in' => 86400,
  'expiresIn' => 86400,
  'token_type' => 'Bearer',
  'tokenType' => 'Bearer'
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
exit;
