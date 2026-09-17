<?php
header('Content-Type: application/json; charset=utf-8');

echo json_encode([
    'status' => 'success',
    'success' => true,
    'update_required' => false,
    'force_update' => false,
    'latest_version' => '256.0.3',
    'version' => '256.0.3',
    'app' => 'Gooobet',
    'apk_url' => 'https://myapi-production-49c5.up.railway.app/api/android/apk/Gooobet.apk',
    'message' => 'up to date'
], JSON_UNESCAPED_SLASHES);
