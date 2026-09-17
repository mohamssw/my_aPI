<?php
header('Content-Type: application/json; charset=utf-8');

echo json_encode([
  'status' => 'success',
  'message' => 'resident game loaded',
  'game' => ['id' => 301, 'name' => 'Resident']
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
exit;
