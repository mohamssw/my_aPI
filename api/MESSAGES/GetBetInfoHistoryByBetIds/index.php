<?php
header('Content-Type: application/json; charset=utf-8');

echo json_encode([
  'status' => 'success',
  'message' => 'bet history by ids loaded',
  'items' => []
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
exit;
