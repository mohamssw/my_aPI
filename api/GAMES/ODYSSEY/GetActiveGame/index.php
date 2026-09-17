<?php
header('Content-Type: application/json; charset=utf-8');

echo json_encode([
  'status' => 'success',
  'message' => 'odyssey game loaded',
  'game' => ['id' => 401, 'name' => 'Odyssey']
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
exit;
