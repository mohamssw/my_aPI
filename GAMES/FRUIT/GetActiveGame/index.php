<?php
header('Content-Type: application/json; charset=utf-8');

echo json_encode([
  'status' => 'success',
  'message' => 'fruit game loaded',
  'game' => ['id' => 201, 'name' => 'Fruit']
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
exit;
