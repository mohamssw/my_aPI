<?php
header('Content-Type: application/json; charset=utf-8');

echo json_encode([
  'status' => 'success',
  'message' => 'action executed',
  'result' => 'ok'
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
exit;
