<?php
header('Content-Type: application/json; charset=utf-8');

echo json_encode([
  'status' => 'success',
  'message' => 'domino game loaded',
  'game' => ['id' => 501, 'name' => 'Domino']
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
exit;
