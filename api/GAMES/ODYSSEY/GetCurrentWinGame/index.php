<?php
header('Content-Type: application/json; charset=utf-8');

echo json_encode([
  'status' => 'success',
  'message' => 'odyssey current win loaded',
  'win' => 0,
  'game' => 'Odyssey'
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
exit;
