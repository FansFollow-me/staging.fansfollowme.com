<?php

$path = __DIR__.'/../app/Http/Controllers/MoneyController.php';
$lines = file($path);
$out = [];
$i = 0;
$n = count($lines);
while ($i < $n) {
    $line = $lines[$i];
    // Replace the subscribe tip-notification block that references $giftLabel/$amount
    if (strpos($line, 'NotificationService') !== false
        && isset($lines[$i+1]) && strpos($lines[$i+1], '$creator') !== false
        && isset($lines[$i+2]) && strpos($lines[$i+2], "'tip'") !== false
        && isset($lines[$i+3]) && strpos($lines[$i+3], 'giftLabel') !== false) {
        $out[] = "        app(\\App\\Services\\NotificationService::class)->push(\n";
        $out[] = "            \$creator,\n";
        $out[] = "            'subscribe',\n";
        $out[] = "            'New subscriber @'.\$user->username,\n";
        $out[] = "            '\$'.number_format(\$price / 100, 2).'/mo',\n";
        $out[] = "            ['from' => \$user->username]\n";
        $out[] = "        );\n";
        // skip until closing );
        while ($i < $n && strpos($lines[$i], ');') === false) {
            $i++;
        }
        $i++; // skip );
        continue;
    }
    $out[] = $line;
    $i++;
}
file_put_contents($path, implode('', $out));
echo "patched subscribe notify\n";
