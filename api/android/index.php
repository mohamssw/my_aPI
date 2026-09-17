<?php
header('Content-Type: application/json; charset=utf-8');

echo json_encode([
  'status' => 'success',
  'success' => true,
  'update_required' => false,
  'force_update' => false,
  'latest_version' => '256.0.3',
  'version' => '256.0.3',
  'message' => 'app is up to date',
  'download_url' => null
], JSON_UNESCAPED_SLASHES);
exit;
