<?php

$files = [
    __DIR__.'/../app/Http/Controllers/ShopController.php',
    __DIR__.'/../app/Http/Controllers/ReportController.php',
    __DIR__.'/../app/Http/Controllers/MoneyController.php',
];

foreach ($files as $path) {
    if (! is_file($path)) {
        continue;
    }
    $c = file_get_contents($path);
    $orig = $c;

    // Replace static send( calls with service push — keep arg shapes that are ints
    // AppNotification::send($id, $type, $title, $body) → service
    $c = preg_replace(
        '/\\\\App\\\\Models\\\\AppNotification::send\(\s*(.+?),\s*(.+?),\s*(.+?),\s*(.+?),\s*(.+?)\s*\);/s',
        'app(\\App\\Services\\NotificationService::class)->pushNotificationById((int) $1, $2, $3, $4);',
        $c
    );
    $c = preg_replace(
        '/\\\\App\\\\Models\\\\AppNotification::send\(\s*(.+?),\s*(.+?),\s*(.+?),\s*(.+?)\s*\);/s',
        'app(\\App\\Services\\NotificationService::class)->pushNotificationById((int) $1, $2, $3, $4);',
        $c
    );
    $c = preg_replace(
        '/AppNotification::send\(\s*(.+?),\s*(.+?),\s*(.+?),\s*(.+?)\s*\);/s',
        'app(\\App\\Services\\NotificationService::class)->pushNotificationById((int) $1, $2, $3, $4);',
        $c
    );

    if ($c !== $orig) {
        file_put_contents($path, $c);
        echo 'PATCHED '.basename($path)."\n";
    } else {
        echo 'ok     '.basename($path)."\n";
    }
}

// Add pushNotificationById to NotificationService
$svc = __DIR__.'/../app/Services/NotificationService.php';
$s = file_get_contents($svc);
if (! str_contains($s, 'pushNotificationById')) {
    $s = str_replace(
        '    public function push(',
        <<<'PHP'
    public function pushNotificationById(int $userId, string $type, string $title, ?string $body = null, array $data = []): AppNotification
    {
        $user = User::find($userId);
        if (! $user) {
            return AppNotification::create([
                'user_id' => $userId,
                'type' => $type,
                'title' => $title,
                'body' => $body,
                'data' => $data ?: null,
            ]);
        }

        return $this->push($user, $type, $title, $body, $data);
    }

    public function push(
PHP,
        $s
    );
    file_put_contents($svc, $s);
    echo "service updated\n";
}

echo "done\n";
