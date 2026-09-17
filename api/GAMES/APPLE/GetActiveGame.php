<?php
header('Content-Type: application/json; charset=utf-8');

echo json_encode([
  'status' => 'success',
  'message' => 'game loaded',
  'game' => [
    'id' => 101,
    'name' => 'Apple'
  ]
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
exit;
