<?php

$encrypted = 'uf11d3P2bNb3PkJZLvHwrQ...'; // Copy from database
$key = 'shopEaseSecureKey2024!!';
$iv = substr($key, 0, 16);

$decrypted = openssl_decrypt($encrypted, 'AES-256-CBC', $key, 0, $iv);

if ($decrypted) {
    echo '✅ Decrypted password: ' . $decrypted;
} else {
    echo '❌ Failed to decrypt. Wrong key or corrupted data.';
}