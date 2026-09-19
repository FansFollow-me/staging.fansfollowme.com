<?php

$path = __DIR__.'/../app/Http/Controllers/ShopController.php';
$lines = file($path);
foreach ($lines as $i => $line) {
    if (strpos($line, 'pushNotificationById') !== false && strpos($line, 'number_format') !== false) {
        $lines[$i] = "        app(\\App\\Services\\NotificationService::class)->pushNotificationById(\n            (int) \$product->creator_id,\n            'sale',\n            'Sale: '.\$product->title,\n            'Bought by @'.\$user->username.' for \$'.number_format(\$amount / 100, 2)\n        );\n";
        echo "fixed line ".($i+1)."\n";
        break;
    }
}
file_put_contents($path, implode('', $lines));
// syntax check
passthru('php -l '.escapeshellarg($path));
