<?php
header('Content-Type: application/json; charset=utf-8');

echo json_encode([
  'status' => 'success',
  'message' => 'wheel spin ok',
  'spin' => 1,
  'win' => 0
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
exit;
