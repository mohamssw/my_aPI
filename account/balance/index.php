<?php
header('Content-Type: application/json; charset=utf-8');

echo json_encode([
  'status' => 'success',
  'message' => 'balance loaded',
  'balance' => 0,
  'currency' => 'EGP'
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
exit;
