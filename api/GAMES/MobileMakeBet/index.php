<?php
header('Content-Type: application/json; charset=utf-8');

echo json_encode([
  'status' => 'success',
  'message' => 'bet submitted',
  'result' => 'accepted',
  'bet_id' => 1
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
exit;