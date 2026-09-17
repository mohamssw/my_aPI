<?php
header('Content-Type: application/json; charset=utf-8');

echo json_encode([
  'status' => 'success',
  'message' => 'bet submitted',
  'game_id' => 101,
  'bet_id' => 999,
  'result' => 'accepted'
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
exit;
