<?php
header('Content-Type: application/json; charset=utf-8');

echo json_encode([
  'status' => 'success',
  'message' => 'logged out',
  'logout' => true
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
exit;
