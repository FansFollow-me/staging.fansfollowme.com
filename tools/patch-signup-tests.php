<?php

$files = [
    __DIR__.'/../tests/Feature/AuthAndQrTest.php',
    __DIR__.'/../tests/Feature/QrJoinFlowTest.php',
    __DIR__.'/../tests/Feature/VaultReferralTest.php',
];

$needle = "'terms' => '1',";
$replace = "'terms' => '1',\n            'age_confirm' => '1',\n            'date_of_birth' => now()->subYears(30)->format('Y-m-d'),";

foreach ($files as $file) {
    $c = file_get_contents($file);
    if (strpos($c, $needle) === false) {
        echo "skip ".basename($file)."\n";
        continue;
    }
    $c = str_replace($needle, $replace, $c);
    file_put_contents($file, $c);
    echo "patched ".basename($file)."\n";
}

// Also handle indented versions
$needle2 = "            'terms' => '1',\n";
$replace2 = "            'terms' => '1',\n            'age_confirm' => '1',\n            'date_of_birth' => now()->subYears(30)->format('Y-m-d'),\n";

foreach ($files as $file) {
    $c = file_get_contents($file);
    if (strpos($c, "'age_confirm'") !== false) {
        echo "already has age_confirm: ".basename($file)."\n";
        continue;
    }
    $c = str_replace($needle2, $replace2, $c);
    file_put_contents($file, $c);
    echo "patched2 ".basename($file)."\n";
}
