<?php

$path = __DIR__.'/../app/Http/Controllers/MoneyController.php';
$c = file_get_contents($path);

$bad = "\\App\\Models\\AppNotification::send(
            \$creator->id,
            'tip',
            (\$giftLabel ?: 'Tip').' from @'.\$user->username,
            '\$'.number_format(\$amount / 100, 2),
            route('profile', \$user->username)
        );";

// simpler str replace on unique marker
$c = str_replace(
    "\\App\\Models\\AppNotification::send(",
    "app(\\App\\Services\\NotificationService::class)->pushNotificationTemp(",
    $c
);

// Actually replace the whole broken call with service push
$c = preg_replace(
    '/app\(\\\\App\\\\Services\\\\NotificationService::class\)->pushNotificationTemp\([\s\S]*?\);/',
    'app(\\App\\Services\\NotificationService::class)->push(
            $creator,
            \'tip\',
            ($giftLabel ?: \'Tip\').\' from @\'.$user->username,
            \'$\'.number_format($amount / 100, 2),
            [\'from\' => $user->username]
        );',
    $c,
    1
);

// Follow notification
$c = str_replace(
    "\$user->following()->syncWithoutDetaching([\$creator->id]);\n\n        return back()->with('status', 'Following @'.\$creator->username);",
    "\$user->following()->syncWithoutDetaching([\$creator->id]);\n\n        app(\\App\\Services\\NotificationService::class)->push(\$creator, 'follow', '@'.\$user->username.' started following you');\n\n        return back()->with('status', 'Following @'.\$creator->username);",
    $c
);

file_put_contents($path, $c);
echo "patched money controller\n";
echo (strpos($c, 'AppNotification::send') === false ? "no bad send\n" : "STILL BAD\n");
echo (strpos($c, 'NotificationService') !== false ? "has service\n" : "no service\n");
