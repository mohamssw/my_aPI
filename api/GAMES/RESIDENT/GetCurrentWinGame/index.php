<?php
header('Content-Type: application/json; charset=utf-8');

echo json_encode([
  'status' => 'success',
  'message' => 'resident win loaded',
  'win' => 0,
  'game' => 'Resident'
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
exit;
